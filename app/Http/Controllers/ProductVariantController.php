<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Http\Resources\VariantResource;

class ProductVariantController extends Controller
{
    public function imageUpload(Request $request)
    {
        $variant = new Variant();

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('image')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('image')->storeAs('public/post_img', $createnewFileName);
            $variant->image = $createnewFileName;
        }

        if ($variant->save()) {
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
        $variants = Variant::latest()->get();
        return VariantResource::collection($variants);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/post_img', $filename);
            $data['image'] = $filename;
        }

        $variant = Variant::create($data);

        return new VariantResource($variant);
    }

    /**
     * Display the specified resource.
     */
    public function show(Variant $variants)
    {
        return new VariantResource($variants);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant $variants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantRequest $request, Variant $variants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variants)
    {
        //
    }
}
