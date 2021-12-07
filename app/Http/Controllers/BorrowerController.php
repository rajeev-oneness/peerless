<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementData;
use App\Models\AgreementDocument;
use App\Models\AgreementDocumentUpload;
use App\Models\AgreementField;
use App\Models\AgreementRfq;
use App\Models\Borrower;
use App\Models\FieldParent;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $borrowers = Borrower::select('*')->with(['agreementDetails', 'borrowerAgreementRfq'])->latest('id');

            return Datatables::of($borrowers)->make(true);
        }
        return view('admin.borrower.index');
    }

    public function indexOld(Request $request)
    {
        $data = Borrower::with('agreementDetails')->latest()->paginate(20);
        return view('admin.borrower.index-old', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (object)[];
        $data->agreement = Agreement::orderBy('name')->get();
        return view('admin.borrower.create', compact('data'));
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
            'name_prefix' => 'required|string|min:1|max:50',
            'full_name' => 'required|string|min:1|max:200',
            'gender' => 'required|string|min:1|max:30',
            'date_of_birth' => 'required',
            'email' => 'required|string|email',
            'mobile' => 'required|integer|digits:10',
            'pan_card_number' => 'required|string|min:10|max:10',
            'occupation' => 'required|string|min:1|max:200',
            'marital_status' => 'required|string|min:1|max:30',
            'street_address' => 'required|string|min:1|max:200',
            'city' => 'required|string|min:1|max:200',
            'pincode' => 'required|integer|digits:6',
            'state' => 'required|string|min:1|max:200',
            'agreement_id' => 'nullable|numeric|min:1'
        ]);

        DB::beginTransaction();

        try {
            $user = new Borrower;
            $user->name_prefix = $request->name_prefix;
            $user->full_name = $request->full_name;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->pan_card_number = $request->pan_card_number;
            $user->occupation = $request->occupation;
            $user->marital_status = $request->marital_status;
            $user->street_address = $request->street_address;
            $user->city = $request->city;
            $user->pincode = $request->pincode;
            $user->state = $request->state;
            $user->agreement_id = $request->agreement_id ? $request->agreement_id : 0;
            $user->uploaded_by = auth()->user()->id;
            $user->save();

            // notification fire
            createNotification(auth()->user()->id, 1, 'new_borrower', 'New borrower, ' . $request->name_prefix . ' ' . $request->full_name . ' added by ' . auth()->user()->emp_id);

            // activity log
            $logData = [
                'type' => 'new_borrower',
                'title' => 'New borrower created',
                'desc' => 'New borrower, ' . $request->full_name . ' created by ' . auth()->user()->emp_id
            ];
            activityLog($logData);

            DB::commit();
            return redirect()->route('user.borrower.list')->with('success', 'Borrower created');
        } catch (Exception $e) {
            DB::rollback();
            $error['email'] = 'Something went wrong';
            return redirect(route('user.borrower.create'))->withErrors($error)->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Borrower::findOrFail($request->id);

        $userid = $data->id;
        $username_prefix = ucwords($data->name_prefix);
        $userfull_name = $data->full_name;
        $usergender = $data->gender;
        $userdate_of_birth = $data->date_of_birth;
        $useremail = $data->email;
        $usermobile = $data->mobile;
        $userpan_card_number = $data->pan_card_number;
        $userimage_path = asset($data->image_path);
        $useroccupation = $data->occupation;
        $usermarital_status = $data->marital_status;
        $userstreet_address = $data->street_address;
        $usercity = $data->city;
        $userpincode = $data->pincode;
        $userstate = $data->state;

        return response()->json(['error' => false, 'data' => ['user_id' => $userid, 'name_prefix' => $username_prefix, 'name' => $userfull_name, 'gender' => $usergender, 'dateofbirth' => $userdate_of_birth, 'email' => $useremail, 'mobile' => $usermobile, 'pan_card_number' => $userpan_card_number, 'image_path' => $userimage_path, 'occupation' => $useroccupation, 'marital_status' => $usermarital_status, 'street_address' => $userstreet_address, 'city' => $usercity, 'pincode' => $userpincode, 'state' => $userstate]]);
    }

    public function details(Request $request)
    {
        $data = Borrower::findOrFail($request->id);
        return view('admin.borrower.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = (object)[];
        $data->user = Borrower::findOrFail($id);
        $data->agreement = Agreement::orderBy('name')->get();
        return view('admin.borrower.edit', compact('data'));
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
            'name_prefix' => 'required|string|min:1|max:50',
            'full_name' => 'required|string|min:1|max:200',
            'gender' => 'required|string|min:1|max:30',
            'date_of_birth' => 'required',
            'email' => 'required|string|email',
            'mobile' => 'required|numeric|min:1',
            'pan_card_number' => 'required|string|min:10|max:10',
            'occupation' => 'required|string|min:1|max:200',
            'marital_status' => 'required|string|min:1|max:30',
            'street_address' => 'required|string|min:1|max:200',
            'city' => 'required|string|min:1|max:200',
            'pincode' => 'required|integer|digits:6',
            'state' => 'required|string|min:1|max:200',
            'agreement_id' => 'nullable|numeric|min:1'
        ]);

        $user = Borrower::findOrFail($id);
        $user->name_prefix = $request->name_prefix;
        $user->full_name = $request->full_name;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->pan_card_number = $request->pan_card_number;
        $user->occupation = $request->occupation;
        $user->marital_status = $request->marital_status;
        $user->street_address = $request->street_address;
        $user->city = $request->city;
        $user->pincode = $request->pincode;
        $user->state = $request->state;
        $user->agreement_id = $request->agreement_id ? $request->agreement_id : 0;
        $user->save();

        return redirect()->route('user.borrower.list')->with('success', 'Borrower updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $request->validate(['id' => 'required|numeric|min:1']);
        Borrower::where('id', $request->id)->delete();
        return response()->json(['error' => false, 'title' => 'Deleted', 'message' => 'Record deleted', 'type' => 'success']);
    }

    public function agreementFields(Request $request, $id)
    {
        $borrower_id = $id;
        $data = (object)[];
        $data->agreement = Borrower::select('id', 'name_prefix', 'full_name', 'agreement_id')->where('id', $borrower_id)->get();
        foreach ($data->agreement as $agreement) {
            $data->name_prefix = $agreement->name_prefix;
            $data->full_name = $agreement->full_name;
            $data->agreement_id = $agreement->agreement_id;
            $data->agreement_name = $agreement->agreementDetails->name;
            break;
        }
        $data->parentFields = FieldParent::with('childRelation')->get();

        $data->fields = AgreementField::with('fieldDetails')->where('agreement_id', $data->agreement_id)->get();
        $data->agreementRfq = AgreementRfq::where('borrower_id', $borrower_id)->where('agreement_id', $data->agreement_id)->count();

        $data->requiredDocuments = AgreementDocument::with('siblingsDocuments')->where('agreement_id', $data->agreement_id)->where('parent_id', null)->get();

        // $data->uploadedDocuments = AgreementDocumentUpload::where('borrower_id', $borrower_id)->get();

        return view('admin.borrower.fields', compact('data', 'id'));
    }

    public function agreementStore(Request $request)
    {
        //dd($request->all());
        $rules = [
            'borrower_id' => 'required|numeric|min:1',
            'agreement_id' => 'required|numeric|min:1',
            'field_name' => 'required'
        ];

        $validate = validator()->make($request->all(), $rules);

        if (!$validate->fails()) {
            DB::beginTransaction();

            try {
                $rfq = new AgreementRfq();
                $rfq->borrower_id = $request->borrower_id;
                $rfq->agreement_id = $request->agreement_id;
                $rfq->data_filled_by = auth()->user()->id;
                $rfq->save();

                foreach ($request->field_name as $index => $field) {
                    $agreement = new AgreementData();
                    $agreement->rfq_id = $rfq->id;
                    $agreement->field_id = 0;
                    $agreement->field_name = $index;
                    $agreement->field_value = checkStringFileAray($field);
                    $agreement->save();
                }

                // activity log
                $logData = [
                    'type' => 'agreement_data_upload',
                    'title' => 'Agreement data uploaded',
                    'desc' => ucwords($rfq->borrowerDetails->name_prefix) . ' ' . $rfq->borrowerDetails->full_name . ', ' . $rfq->agreementDetails->name . ' data added by ' . auth()->user()->emp_id
                ];
                activityLog($logData);

                // notification(sender, receiver, type, message(optional), route(optional))
                $notificationMessage = ucwords($rfq->borrowerDetails->name_prefix) . ' ' . $rfq->borrowerDetails->full_name . ', ' . $rfq->agreementDetails->name . ' data added by ' . auth()->user()->emp_id;
                $notificationRoute = 'user.borrower.list';
                createNotification(auth()->user()->id, 1, 'agreement_data_upload', $notificationMessage, $notificationRoute);

                DB::commit();

                return redirect()->route('user.borrower.agreement', $request->borrower_id)->with('success', 'Fields added');
            } catch (Exception $e) {
                DB::rollback();
            }
        } else {
            return response()->json(['error' => true, 'message' => $validate->errors()->first()]);
        }
    }

    public function uploadToServer(Request $request)
    {
        // dd($request->all());

        $rules = [
            'borrower_id' => 'required|integer|min:1',
            'agreement_document_id' => 'required|integer|min:1',
            'document' => 'required|max:500000|mimes:jpg, jpeg, png, pdf',
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $filePath = fileUpload($request->document, 'borrower-documents');
            AgreementDocumentUpload::where('borrower_id', $request->borrower_id)->where('agreement_document_id', $request->agreement_document_id)->update(['status' => 0]);
            $file = new AgreementDocumentUpload();
            $file->borrower_id = $request->borrower_id;
            $file->agreement_document_id = $request->agreement_document_id;
            $file->file_path = $filePath;
            $file->file_type = request()->document->getClientOriginalExtension();
            $file->uploaded_by = auth()->user()->id;
            $file->save();

            return response()->json(['response_code' => 200, 'title' => 'success', 'message' => 'Successfully uploaded.']);
        } else {
            return response()->json(['response_code' => 400, 'title' => 'failure', 'message' => $validator->errors()->first()]);
        }
    }

    public function showDocument(Request $request)
    {
        $rules = [
            'id' => 'required|integer|min:1'
        ];

        $validator = validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $data = (object)[];
            $data->agreement_document_upload = AgreementDocumentUpload::with(['documentDetails', 'borrowerDetails'])->findOrFail($request->id);

            $data->image = asset($data->agreement_document_upload->file_path);

            return response()->json(['response_code' => 200, 'tile' => 'success', 'message' => $data, 'file' => $data->image]);
        } else {
            return response()->json(['response_code' => 400, 'tile' => 'failure', 'message' => $validator->errors()->first()]);
        }
    }

    public function verifyDocument(Request $request)
    {
        $rules = [
            'id' => 'required|integer|min:1',
            'type' => 'required|integer',
        ];

        $validator = validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            if ($request->type == 0) {
                $updateType = 1;
            } else {
                $updateType = 0;
            }

            AgreementDocumentUpload::where('id', $request->id)->update(['verify' => $updateType, 'verified_by' => auth()->user()->id]);

            return response()->json(['response_code' => 200, 'tile' => 'success', 'message' => 'Document updated', 'updateStatusCode' => $updateType]);
        } else {
            return response()->json(['response_code' => 400, 'tile' => 'failure', 'message' => $validator->errors()->first()]);
        }
    }
}
