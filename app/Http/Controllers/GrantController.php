<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\GrantStoreRequest;
use App\Models\Grant;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Grant::with(['product:id,quantity,name,image'])->get();
        return view('layouts.transactions.grant', ['grants' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrantStoreRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $request->validate([
            'quantity' => 'max:' . $product->quantity
        ]);
        try {
            DB::beginTransaction();
            $item = new Grant();
            $item->user_id = auth()->user()->id;
            $item->product_id = $product->id;
            $item->quantity = $request->quantity;
            $item->recipient = $request->recipient;
            $item->description = $request->note;
            $item->save();

            $product->quantity -= $item->quantity;
            $product->save();

            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollBack();
            return response(['message' => 'An error occured while processing your transaction.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function show(Grant $grant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function edit(Grant $grant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grant $grant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Grant $grant)
    {
        try {
            DB::beginTransaction();
            $item = $grant->product;
            $item->quantity += $grant->quantity;
            $item->save();
            $grant->delete();

            DB::commit();
            $request->session()->flash('popupMessage', ['status' => 'success', 'message' => 'Your grant has been canceled successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->session()->flash('popupMessage', ['status' => 'error', 'message' => 'An error occured while processing your transaction.']);
        }

        return redirect()->back();
    }
}
