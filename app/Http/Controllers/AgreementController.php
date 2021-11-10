<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementField;
use App\Models\Field;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $agreement->authorised_signatory = $request->authorised_signatory ? $request->authorised_signatory : '';
        $agreement->borrower = $request->borrower ? $request->borrower : '';
        $agreement->co_borrower = $request->co_borrower ? $request->co_borrower : '';
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

    // fields setup
    public function fieldsIndex(Request $request, $id)
    {
        $data = (object)[];
        $data->agreement = Agreement::findOrFail($id);
        $data->fields = Field::latest()->get();
        $data->agreementFields = AgreementField::select('field_id')->where('agreement_id', $id)->pluck('field_id')->toArray();
        return view('admin.agreement.fields', compact('data'));
    }

    // fields store
    public function fieldsStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'agreement_id' => 'required|numeric|min:1',
            'field_id' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            if (!empty($request->field_id) && count($request->field_id) > 0) {
                $array = [];
                foreach ($request->field_id as $field_id) {
                    $checkFields = AgreementField::where('agreement_id', $request->agreement_id)->where('field_id', $field_id)->first();
                    if ($checkFields) {
                        $array[] = $checkFields->id;
                    } else {
                        $array[] = AgreementField::insertGetId(['agreement_id' => $request->agreement_id, 'field_id' => $field_id]);
                    }
                }
                if (!empty($array) && count($array) > 0) {
                    AgreementField::where('agreement_id', $request->agreement_id)->whereNotIn('id', $array)->delete();
                }
            } else {
                DB::table('agreement_fields')->where('agreement_id', $request->agreement_id)->delete();
            }

            DB::commit();

            return redirect()->route('user.agreement.fields', $request->agreement_id)->with('success', 'Fields updated for agreement');
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}
