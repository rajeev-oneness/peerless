<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::latest()->get();
        return view('admin.employee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (object)[];
        $data->users = User::select('id', 'name', 'user_type')->orderBy('name')->get();
        $data->user_type = UserType::all();
        return view('admin.employee.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|string|email|unique:users',
            'mobile' => 'nullable|numeric|min:1',
            'parent_id' => 'nullable|numeric|min:1',
            'user_type' => 'required|numeric|min:1',
            'sendPassword' => 'nullable',
            'password' => 'nullable',
        ]);

        if (!empty($request->password)) {
            $password = $request->password;
        } else {
            $password = generateUniqueAlphaNumeric(8);
        }

        DB::beginTransaction();

        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->parent_id = $request->parent_id ? $request->parent_id : 0;
            $user->user_type = $request->user_type;
            $user->password = Hash::make($password);
            $user->save();

            if (empty($request->password) || ($request->password == null)) {
                $email_data = [
                    'name' => $request->name,
                    'subject' => 'New registration notification',
                    'email' => $request->email,
                    'password' => $password,
                    'blade_file' => 'user-registration',
                ];

                SendMail($email_data);
            }

            // notification params -> $sender, $receiver, $type
            createNotification(1, $user->id, 'user_registration');

            DB::commit();
            return redirect()->route('user.employee.list')->with('success', 'User created');
        } catch(Exception $e) {
            DB::rollback();
            $error['email'] = 'Something went wrong. Try using manual password';
            return redirect(route('user.employee.create'))->withErrors($error)->withInput($request->all());
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
        $data = User::findOrFail($request->id);
        $user_name = $data->name;
        $user_email = $data->email;
        $user_mobile = $data->mobile;
        $user_image_path = asset($data->image_path);
        $user_type = $data->type->name;
        $user_type_color = $data->type->color;
        $user_parent = $data->parent_id ? $data->parent->name : null;

        return response()->json(['error' => false, 'data' => ['name' => $user_name, 'email' => $user_email, 'mobile' => $user_mobile, 'image_path' => $user_image_path, 'user_type' => $user_type, 'user_type_color' => $user_type_color, 'user_parent' => $user_parent]]);
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
        $data->user = User::findOrFail($id);
        $data->users = User::select('id', 'name', 'user_type')->where('id', '!=', $id)->orderBy('name')->get();
        $data->user_type = UserType::all();
        return view('admin.employee.edit', compact('data'));
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
            'mobile' => 'nullable|numeric|min:1',
            'parent_id' => 'nullable|numeric|min:1',
            'user_type' => 'required|numeric|min:1',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->parent_id = $request->parent_id ? $request->parent_id : 0;
        $user->user_type = $request->user_type;
        $user->save();

        return redirect()->route('user.employee.list')->with('success', 'User updated');
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
        User::where('id', $request->id)->delete();
        return response()->json(['error' => false, 'title' => 'Deleted', 'message' => 'Record deleted', 'type' => 'success']);
    }

    public function block(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($user->block == 0) {
            $user->block = 1;
            $title = 'Blocked';
            $message = 'User is blocked';
        } else {
            $user->block = 0;
            $title = 'Active';
            $message = 'User is active';
        }
        $user->save();

        return response()->json(['error' => false, 'title' => $title, 'message' => $message, 'type' => 'success']);
    }
}
