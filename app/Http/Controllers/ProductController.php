<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductEditRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductStatusRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductIndexRequest $request)
    {
        $products = Product::with('category:id,name')->select(['id', 'name', 'status', 'quantity', 'category_id', 'image']);

        if ($request->status != null && ($request->status == 0 || $request->status == 1))
            $products = $products->where('status', $request->status);

        $products = $products->get();
        return view('layouts.product.index')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductCreateRequest $request)
    {
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $data = [
            'categories' => $categories,
            'sub_categories' => $sub_categories
        ];
        return view('layouts.product.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {

        $fileName = '';
        try {
            DB::beginTransaction();
            $item = new Product();
            $item->fill([
                'name' => $request->name,
                'article_code' => $request->article_code,
                'quantity' => $request->stock,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'status' => 1,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = Str::uuid()->toString() . Carbon::now()->timestamp . '.' .  $image->getClientOriginalExtension();
                Storage::putFileAs('products', $image, $fileName);
            }
            $item->image = 'products/' . $fileName;
            $item->save();

            DB::commit();
            $request->session()->flash('popupMessage', ['status' => 'success', 'message' => 'Product has been created successfully.']);
            return redirect()->route('product.index');
        } catch (\Throwable $th) {
            if (Storage::exists($fileName)) {
                Storage::delete($fileName);
            }
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'An error occured while processing your request.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductEditRequest $request, Product $product)
    {
        $product->load(['category:id', 'subCategory:id']);
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $data = [
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'product' => $product
        ];
        return view('layouts.product.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $item = $product;
            $item->fill([
                'name' => $request->name,
                'article_code' => $request->article_code,
                'quantity' => $request->stock,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = Str::uuid()->toString() . Carbon::now()->timestamp . '.' .  $image->getClientOriginalExtension();
                Storage::putFileAs('products', $image, $fileName);
                $item->image = 'products/' . $fileName;
            }

            $item->save();

            DB::commit();
            $request->session()->flash('popupMessage', ['status' => 'success', 'message' => 'Product has been updated successfully.']);
            return redirect()->route('product.index');
        } catch (\Throwable $th) {
            if (isset($fileName) && Storage::exists($fileName)) {
                Storage::delete($fileName);
            }
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'An error occured while processing your request.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Change the specified product status.
     *
     * @param  ProductStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function status(ProductStatusRequest $request, Product $product)
    {
        $product->status = $request->status;
        $product->save();
        return 'ok';
    }


    /**
     * Return the specified product image.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getImage(Request $request, Product $product)
    {
        if (Storage::exists($product->image)) {
            $file = Storage::get($product->image);
            $type = Storage::mimeType($product->image);
            return Response::make($file, 200)->header("Content-Type", $type);
        }
        return response()->file(storage_path() . '/assets/no-pictures.png');
    }
}
