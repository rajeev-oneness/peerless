<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\AgreementRfq;

class AgreementController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function agreementDownload(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'auth_user_id' => 'required|integer|min:1',
            'auth_user_emp_id' => 'required|string|min:1|exists:users,emp_id',
            'borrower_id'=> 'required|integer|min:1',
            'agreement_id'=> 'required|integer|min:1',
        ]);

        // activity log
        $logData = [
            'type' => 'agreement_download_request',
            'title' => 'Agreement download request',
            'desc' => 'Agreement download request generated for Agreement id: '.$request->agreement_id.' and Borrower id: '.$request->borrower_id.' by EMP ID '.$request->auth_user_emp_id
        ];
        activityLog($logData);

        if (!$validate->fails()) {
            $borrowerAgreementDataExists = AgreementRfq::where('borrower_id', $request->borrower_id)->where('agreement_id', $request->agreement_id)->count();

            if ($borrowerAgreementDataExists > 0) {
                return response()->json(['status' => 200, 'Agreement download url' => url('/').'/user/borrower/'.$request->borrower_id.'/agreement/'.$request->agreement_id.'/pdf/view'], 200);
            } else {
                return response()->json(['status' => 400, 'message' => 'No document found'], 400);
            }
        } else {
            return response()->json(['status' => 400, 'message' => $validate->errors()->first()], 400);
        }
    }
}
