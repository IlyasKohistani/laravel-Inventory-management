<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\RequestStatusRequest;
use App\Http\Requests\Transaction\RequestStoreRequest;
use App\Models\Product;
use App\Models\RequestTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RequestTransaction::with(['product:id,quantity,name,image'])->get();
        return view('layouts.transactions.request', ['requests' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        try {
            DB::beginTransaction();
            $item = new RequestTransaction();
            $item->user_id = auth()->user()->id;
            $item->product_id = $product->id;
            $item->quantity = $request->quantity;
            $item->description = $request->note;
            $item->stock = $product->quantity;
            $item->save();

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
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(RequestTransaction $requestTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestTransaction $requestTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestTransaction $requestTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RequestTransaction $requestTransaction)
    {
        try {
            DB::beginTransaction();
            $requestTransaction->delete();
            DB::commit();
            $request->session()->flash('popupMessage', ['status' => 'success', 'message' => 'Request has been removed successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->session()->flash('popupMessage', ['status' => 'error', 'message' => 'An error occured while processing your transaction.']);
        }

        return redirect()->back();
    }

    /**
     * Change status of the specified resource.
     * 
     * @param   Request $request
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Http\Response
     */
    public function status(RequestStatusRequest $request, RequestTransaction $requestTransaction)
    {
        $message = '';
        switch ($request->status) {
            case 0:
                $message = 'Request has been rejected successfully.';
                break;
            case 2:
                $message = 'Request has been approved successfully.';
                break;
            case 3:
                $message = 'Request has been completed successfully.';
                break;
            default:
                $message = 'Request status has been reset successfully.';
                break;
        }
        try {
            DB::beginTransaction();
            $requestTransaction->status = $request->status;
            if ($request->status == 2) {
                $requestTransaction->approved_by = request()->user()->id;
                $requestTransaction->approved_at = date('Y-m-d H:i:s');
            }
            $requestTransaction->save();

            if ($request->status == 3) {
                $product = $requestTransaction->product;
                $product->quantity += $requestTransaction->quantity;
                $product->save();
            }


            DB::commit();
            $request->session()->flash('popupMessage', ['status' => 'success', 'message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->session()->flash('popupMessage', ['status' => 'error', 'message' => 'An error occured while processing your transaction.']);
        }

        return redirect()->back();
    }
}
