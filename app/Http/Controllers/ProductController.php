<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function imageUpload(Request $req)
    {
        $postObj = new Product();

        if ($req->hasFile('image')) {
            $filename = $req->file('image')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $req->file('image')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $req->file('image')->storeAs('public/post_img', $createnewFileName);
            $postObj->image = $createnewFileName;
        }

        if ($postObj->save()) {
            return response()->json(['status' => true, 'message' => "Image uploaded successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Error: Image not uploaded successfully"]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variants')->latest()->get();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('image')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('image')->storeAs('public/post_img', $createnewFileName);
            $data['image'] = $createnewFileName;
        }

        $product = Product::create($data);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('variants'); // Eager load the variants relationship
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->update($validated);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
