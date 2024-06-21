<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InteriorDesigner;
use App\Http\Resources\InteriorDesignerResource;
use App\Http\Requests\StoreInteriorDesignerRequest;
use App\Http\Requests\UpdateInteriorDesignerRequest;

class InteriorDesignerController extends Controller
{

    public function imageUpload(Request $req)
    {
        $postObj = new InteriorDesigner();

        if ($req->hasFile('image')) {
            $filename = $req->file('image')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $req->file('image')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $req->file('image')->storeAs('public/post_img', $createnewFileName);
            $postObj->image = $createnewFileName;
        }

        if ($postObj->save()) { // save file in databse
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
        return InteriorDesignerResource::collection(InteriorDesigner::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInteriorDesignerRequest $request)
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
        $interiorDesigner = InteriorDesigner::create($data);

        return InteriorDesignerResource::make($interiorDesigner);
    }

    /**
     * Display the specified resource.
     */
    public function show(InteriorDesigner $interiorDesigner)
    {
        return InteriorDesignerResource::make($interiorDesigner);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInteriorDesignerRequest $request, InteriorDesigner $interiorDesigner)
    {
        $interiorDesigner->update($request->validated());
        return InteriorDesignerResource::make($interiorDesigner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InteriorDesigner $interiorDesigner)
    {
        //
    }
}
