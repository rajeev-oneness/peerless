<?php

namespace App\Http\Controllers;

use App\Models\Estamp;
use Illuminate\Http\Request;

class EstampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['allStamps'] = Estamp::latest()->get();
        return view('admin.estamp.index')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());

        $request->validate([
            'unique_stamp_code' => 'required|string|min:1|max:255|unique:estamps',
            'back_page' => 'required|mimes:png,jpg,jpeg,pdf',
            'front_page' => 'required|mimes:png,jpg,jpeg,pdf',
        ], [
            'back_page.required' => 'This field is required',
            'front_page.required' => 'This field is required',
            'unique_stamp_code.required' => 'This field is required',
            'unique_stamp_code.max' => 'Maximum character reached',
            'unique_stamp_code.unique' => 'Already taken'
        ]);

        if($request->hasFile('back_page')){
            $file = $request->file('back_page');
            $fileNameForBack = fileUpload($file,'estamp');
        }else{
            $fileNameForBack = null;
        }
        if($request->hasFile('front_page')){
            $file = $request->file('front_page');
            $fileNameForFront = fileUpload($file,'estamp');
        }else{
            $fileNameForFront = null;
        }

        $estamp = new Estamp();
        $estamp->unique_stamp_code = $request->unique_stamp_code;
        $estamp->back_file_path = $fileNameForBack;
        $estamp->front_file_path = $fileNameForFront;
        $estamp->amount = $request->amount;
        $estamp->save();

        return redirect()->route('user.estamp.list')->with('success', 'Estamp created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Estamp::findOrFail($request->id);
        return response()->json(['error' => false, 'data' => $data]);
    }

    public function details(Request $request)
    {
        $data = [];
        $data['stamp_details'] = Estamp::findOrFail($request->id);
        return view('admin.estamp.view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = [];
        $data['stamp_details'] = Estamp::findOrFail($id);
        return view('admin.estamp.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'unique_stamp_code' => 'required|string|min:1|max:255',
            'file' => 'nullable|mimes:png,jpg,jpeg,pdf',
        ], [
            'unique_stamp_code.required' => 'This field is required',
            'unique_stamp_code.max' => 'Maximum character reached',
        ]);

        $estamp = Estamp::findOrFail($id);

        if($request->hasFile('file')){
            $image = $request->file('file');
            $fileName = fileUpload($image,'estamp');
        }else{
            $fileName = $estamp->file_path;
        }        
        $estamp->unique_stamp_code = $request->unique_stamp_code;
        $estamp->file_path = $fileName;
        $estamp->save();

        return redirect()->route('user.estamp.list')->with('success', 'Estamp updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Estamp::where('id', $request->id)->delete();
        return response()->json(['error' => false, 'title' => 'Deleted', 'message' => 'Estamp deleted', 'type' => 'success']);
    }



}
