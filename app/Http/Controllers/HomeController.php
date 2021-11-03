<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
        // return view('home');
    }

    public function profile(Request $request)
    {
        return view('admin.profile');
    }

    public function profileUpdate(Request $request)
    {
        $rules = [
            'name' => 'required|min:1|max:200',
            'mobile' => 'nullable|numeric|min:1'
        ];

        $validate = validator()->make($request->all(), $rules);

        if (!$validate->fails()) {
            $user = Auth::user();

            if ($user->name != $request->name || $user->mobile != $request->mobile) {
                $user->name = $request->name;
                $user->mobile = $request->mobile;
                $user->save();

                return response()->json(['error' => false, 'message' => 'Profile updated', 'type' => 'success']);
            } else {
                return response()->json(['error' => false, 'message' => 'No changes made', 'type' => 'info']);
            }
        }

        return response()->json(['error' => true, 'message' => $validate->errors()->first()]);
    }

    public function passwordUpdate(Request $request)
    {
        $rules = [
            'oldPassword' => 'required|string',
            'password' => 'required|string|min:4|max:50|confirmed'
        ];

        $rulesMessage = [
            'password.required' => 'The new password field is required',
            'password.confirmed' => 'New password does not match',
        ];

        $validate = validator()->make($request->all(), $rules, $rulesMessage);
        if (!$validate->fails()) {
            $user = Auth::user();

            if (Hash::check($request->oldPassword, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['error' => false, 'message' => 'Password updated']);
            }
            return response()->json(['error' => true, 'message' => 'Old password missmatched']);
        }

        return response()->json(['error' => true, 'message' => $validate->errors()->first()]);
    }

    public function imageUpdate(Request $request)
    {
        $save_location = 'admin/uploads/profile-picture/';
        $data = $request->image;
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = time() . '.png';

        if (file_put_contents($save_location.$imageName, $data)) {
            $user = Auth::user();
            $user->image_path = $save_location.$imageName;
            $user->save();
            return response()->json(['error' => false, 'message' => 'Image updated', 'image' => asset($save_location.$imageName)]);
        } else {
            return response()->json(['error' => true, 'message' => 'Something went wrong']);
        }
    }

    public function employeeList(Request $request)
    {
        # code...
    }
}
