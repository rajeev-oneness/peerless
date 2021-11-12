<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Borrower::latest()->get();
        return view('admin.borrower.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.borrower.create');
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
        $username_prefix = $data->name_prefix;
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
}
