<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ProductAdded;
use App\Models\Product;
use Validator;
use Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('user','type');

        if($request->product_name) {
            $query->where('name', 'LIKE', '%' . $request->product_name .'%');
        }

        if($request->added_by) {
            $query->where('added_by', $request->added_by);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse($products, 'Products Retrieved Successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validation($request->all());

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($request->all());

        if($product) {
            $user = $product->user;
            Mail::to($user->email)->send(new ProductAdded($user));
        }

        return $this->sendResponse($product, 'Product Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('user','type')->find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse($product, 'Product Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = $this->validation($request->all());

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::where('id', $id)->update($request->all());

        return $this->sendResponse($product, 'Product Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return $this->sendResponse([], 'Product Deleted Successfully.');
    }

    /**
     * Validation
     */
    protected function validation(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'price' => 'required',
            'status' => 'required',
            'added_by' => 'required',
            'type_id' => 'required',
        ]);
    }
}
