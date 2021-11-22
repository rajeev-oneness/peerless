<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementData;
use App\Models\AgreementField;
use App\Models\AgreementRfq;
use App\Models\Borrower;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $borrowers = Borrower::select(['id', 'full_name', 'gender', 'mobile', 'occupation']);

        return Datatables::of($borrowers)
            ->addColumn('action', function ($borrower) {
                return '<a href="#edit-'. $borrower->id.'" class="btn btn-xs btn-primary"> Edit</a>';
            })
            ->editColumn('id', '{{$id}}')
            ->removeColumn('updated_at')
            ->setRowId('id')
            ->setRowClass(function ($user) {
                return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
            })
            ->setRowData([
                'id' => 'test',
            ])
            ->setRowAttr([
                'color' => 'red',
            ])
            ->make(true);
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
            'mobile' => 'required|numeric|min:1',
            'occupation' => 'required|string|min:1|max:200',
            'marital_status' => 'required|string|min:1|max:30',
            'street_address' => 'required|string|min:1|max:200',
            'city' => 'required|string|min:1|max:200',
            'pincode' => 'required|string|min:1|max:200',
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
            $user->occupation = $request->occupation;
            $user->marital_status = $request->marital_status;
            $user->street_address = $request->street_address;
            $user->city = $request->city;
            $user->pincode = $request->pincode;
            $user->state = $request->state;
            $user->agreement_id = $request->agreement_id ? $request->agreement_id : 0;
            $user->save();

            DB::commit();
            return redirect()->route('user.borrower.list')->with('success', 'Borrower created');
        } catch(Exception $e) {
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
        $userimage_path = asset($data->image_path);
        $useroccupation = $data->occupation;
        $usermarital_status = $data->marital_status;
        $userstreet_address = $data->street_address;
        $usercity = $data->city;
        $userpincode = $data->pincode;
        $userstate = $data->state;

        return response()->json(['error' => false, 'data' => ['user_id' => $userid, 'name_prefix' => $username_prefix, 'name' => $userfull_name, 'gender' => $usergender, 'dateofbirth' => $userdate_of_birth, 'email' => $useremail, 'mobile' => $usermobile, 'image_path' => $userimage_path, 'occupation' => $useroccupation, 'marital_status' => $usermarital_status, 'street_address' => $userstreet_address, 'city' => $usercity, 'pincode' => $userpincode, 'state' => $userstate]]);
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
            'occupation' => 'required|string|min:1|max:200',
            'marital_status' => 'required|string|min:1|max:30',
            'street_address' => 'required|string|min:1|max:200',
            'city' => 'required|string|min:1|max:200',
            'pincode' => 'required|string|min:1|max:200',
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
        foreach($data->agreement as $agreement) {
            $data->name_prefix = $agreement->name_prefix;
            $data->full_name = $agreement->full_name;
            $data->agreement_id = $agreement->agreement_id;
            $data->agreement_name = $agreement->agreementDetails->name;
            break;
        }

        $data->fields = AgreementField::where('agreement_id', $data->agreement_id)->get();
        $data->agreementRfq = AgreementRfq::where('borrower_id', $borrower_id)->where('agreement_id', $data->agreement_id)->count();

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
                    // $agreement->borrower_id = $request->borrower_id;
                    // $agreement->agreement_id = $request->agreement_id;
                    $agreement->field_id = 0;
                    $agreement->field_name = $index;
                    $agreement->field_value = checkStringFileAray($field);
                    // $agreement->data_filled_by = auth()->user()->id;
                    $agreement->save();
                }

                DB::commit();

                return redirect()->route('user.borrower.agreement', $request->borrower_id)->with('success', 'Fields added');
            } catch(Exception $e) {
                DB::rollback();
            }
        } else {
            return response()->json(['error' => true, 'message' => $validate->errors()->first()]);
        }
    }
}
