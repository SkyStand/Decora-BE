<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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

        if ($postObj->save()) { // save file in databse
            return ['status' => true, 'message' => "Image uploded successfully"];
        } else {
            return ['status' => false, 'message' => "Error : Image not uploded successfully"];
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variants')->latest()->get();
        return response()->json($products);
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
    public function store(StoreProductRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
