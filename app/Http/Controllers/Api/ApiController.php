<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Borrower;
use App\Models\BorrowerAgreement;

class ApiController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function login() {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function profile() {
        return response()->json(auth()->guard('api')->user());
    }

    public function logout() {
        auth()->guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function borrowerList() {
        $borrowerData = Borrower::with('agreement', 'borrowerAgreementRfq')->get();

        $data = [];
        foreach($borrowerData as $borrowerKey => $borrowerValue) {
            $agreement = [];

            foreach ($borrowerValue->agreement as $key => $value) {
                $agreement[] = [
                    'name' => $value->agreementDetails->name
                ];
            }

            $data[] = [
                'customer_id' => $borrowerValue->CUSTOMER_ID,
                'name_prefix' => $borrowerValue->name_prefix,
                'full_name' => $borrowerValue->full_name,
                'first_name' => $borrowerValue->first_name,
                'middle_name' => $borrowerValue->middle_name,
                'last_name' => $borrowerValue->last_name,
                'gender' => $borrowerValue->gender,
                'email' => $borrowerValue->email,
                'agreement_details' => $agreement
            ];
        }

        return response()->json(['message' => 'Borrower List', 'data' => $data]);
    }
}
