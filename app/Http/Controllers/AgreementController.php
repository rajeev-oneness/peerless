<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Agreement::latest()->get();
        return view('admin.agreement.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (object)[];
        // $data->users = User::select('id', 'name', 'user_type')->orderBy('name')->get();
        // $data->user_type = UserType::all();
        return view('admin.agreement.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string',
            'authorised_signatory' => 'nullable',
            'borrower' => 'nullable',
            'co_borrower' => 'nullable',
        ]);

        $agreement = new Agreement;
        $agreement->name = $request->name;
        $agreement->description = $request->description;
        $agreement->authorised_signatory = $request->authorised_signatory ? $request->authorised_signatory : '' ;
        $agreement->borrower = $request->borrower ? $request->borrower : '' ;
        $agreement->co_borrower = $request->co_borrower ? $request->co_borrower : '' ;
        $agreement->save();

        return redirect()->route('user.agreement.list')->with('success', 'Agreement created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Agreement::findOrFail($request->id);
        return response()->json(['error' => false, 'data' => $data]);
    }

    public function details(Request $request)
    {
        $data = Agreement::findOrFail($request->id);
        return view('admin.agreement.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = Agreement::findOrFail($id);
        return view('admin.agreement.edit', compact('data'));
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
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string',
            'authorised_signatory' => 'nullable',
            'borrower' => 'nullable',
            'co_borrower' => 'nullable',
        ]);

        $agreement = Agreement::findOrFail($id);
        $agreement->name = $request->name;
        $agreement->description = $request->description;
        $agreement->authorised_signatory = $request->authorised_signatory ? $request->authorised_signatory : '';
        $agreement->borrower = $request->borrower ? $request->borrower : '';
        $agreement->co_borrower = $request->co_borrower ? $request->co_borrower : '';
        $agreement->save();

        return redirect()->route('user.agreement.list')->with('success', 'Agreement updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Agreement::where('id', $request->id)->delete();
        return response()->json(['error' => false, 'title' => 'Deleted', 'message' => 'Record deleted', 'type' => 'success']);
    }
}
