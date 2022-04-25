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
                'mobile' => $borrowerValue->mobile,
                'occupation' => $borrowerValue->occupation,
                'date_of_birth' => $borrowerValue->date_of_birth,
                'marital_status' => $borrowerValue->marital_status,
                'image_path' => $borrowerValue->image_path,
                'signature_path' => $borrowerValue->signature_path,
                'street_address' => $borrowerValue->street_address,
                'city' => $borrowerValue->city,
                'pincode' => $borrowerValue->pincode,
                'state' => $borrowerValue->state,
                'block' => $borrowerValue->block,
                'pan_card_number' => $borrowerValue->pan_card_number,
                'Customer_Type' => $borrowerValue->Customer_Type,
                'Resident_Status' => $borrowerValue->Resident_Status,
                'Aadhar_Number' => $borrowerValue->Aadhar_Number,
                'Main_Constitution' => $borrowerValue->Main_Constitution,
                'Sub_Constitution' => $borrowerValue->Sub_Constitution,
                'KYC_Date' => $borrowerValue->KYC_Date,
                'Re_KYC_Due_Date' => $borrowerValue->Re_KYC_Due_Date,
                'Minor' => $borrowerValue->Minor,
                'Customer_Category' => $borrowerValue->Customer_Category,
                'Alternate_Mobile_No' => $borrowerValue->Alternate_Mobile_No,
                'Telephone_No' => $borrowerValue->Telephone_No,
                'Office_Telephone_No' => $borrowerValue->Office_Telephone_No,
                'FAX_No' => $borrowerValue->FAX_No,
                'Preferred_Language' => $borrowerValue->Preferred_Language,
                'REMARKS' => $borrowerValue->REMARKS,
                'KYC_Care_of' => $borrowerValue->KYC_Care_of,
                'KYC_HOUSE_NO' => $borrowerValue->KYC_HOUSE_NO,
                'KYC_LANDMARK' => $borrowerValue->KYC_LANDMARK,
                'KYC_Street' => $borrowerValue->KYC_Street,
                'KYC_LOCALITY' => $borrowerValue->KYC_LOCALITY,
                'KYC_PINCODE' => $borrowerValue->KYC_PINCODE,
                'KYC_Country' => $borrowerValue->KYC_Country,
                'KYC_State' => $borrowerValue->KYC_State,
                'KYC_District' => $borrowerValue->KYC_District,
                'KYC_POST_OFFICE' => $borrowerValue->KYC_POST_OFFICE,
                'KYC_CITY' => $borrowerValue->KYC_CITY,
                'KYC_Taluka' => $borrowerValue->KYC_Taluka,
                'KYC_Population_Group' => $borrowerValue->KYC_Population_Group,
                'COMM_Care_of' => $borrowerValue->COMM_Care_of,
                'COMM_HOUSE_NO' => $borrowerValue->COMM_HOUSE_NO,
                'COMM_LANDMARK' => $borrowerValue->COMM_LANDMARK,
                'COMM_Street' => $borrowerValue->COMM_Street,
                'COMM_LOCALITY' => $borrowerValue->COMM_LOCALITY,
                'COMM_PINCODE' => $borrowerValue->COMM_PINCODE,
                'COMM_Country' => $borrowerValue->COMM_Country,
                'COMM_State' => $borrowerValue->COMM_State,
                'COMM_District' => $borrowerValue->COMM_District,
                'COMM_POST_OFFICE' => $borrowerValue->COMM_POST_OFFICE,
                'COMM_CITY' => $borrowerValue->COMM_CITY,
                'COMM_Taluka' => $borrowerValue->COMM_Taluka,
                'COMM_Population_Group' => $borrowerValue->COMM_Population_Group,
                'Social_Media' => $borrowerValue->Social_Media,
                'Social_Media_ID' => $borrowerValue->Social_Media_ID,
                'PROFESSION' => $borrowerValue->PROFESSION,
                'EDUCATION' => $borrowerValue->EDUCATION,
                'ORGANISATION_NAME' => $borrowerValue->ORGANISATION_NAME,
                'NET_INCOME' => $borrowerValue->NET_INCOME,
                'NET_EXPENSE' => $borrowerValue->NET_EXPENSE,
                'NET_SAVINGS' => $borrowerValue->NET_SAVINGS,
                'Years_in_Organization' => $borrowerValue->Years_in_Organization,
                'CIBIL_SCORE' => $borrowerValue->CIBIL_SCORE,
                'PERSONAL_LOAN_SCORE' => $borrowerValue->PERSONAL_LOAN_SCORE,
                'GST_EXEMPTED' => $borrowerValue->GST_EXEMPTED,
                'RM_EMP_ID' => $borrowerValue->RM_EMP_ID,
                'RM_Designation' => $borrowerValue->RM_Designation,
                'RM_TITLE' => $borrowerValue->RM_TITLE,
                'RM_NAME' => $borrowerValue->RM_NAME,
                'RM_Landline_No' => $borrowerValue->RM_Landline_No,
                'RM_MOBILE_NO' => $borrowerValue->RM_MOBILE_NO,
                'RM_EMAIL_ID' => $borrowerValue->RM_EMAIL_ID,
                'DSA_ID' => $borrowerValue->DSA_ID,
                'DSA_NAME' => $borrowerValue->DSA_NAME,
                'DSA_LANDLINE_NO' => $borrowerValue->DSA_LANDLINE_NO,
                'DSA_MOBILE_NO' => $borrowerValue->DSA_MOBILE_NO,
                'DSA_EMAIL_ID' => $borrowerValue->DSA_EMAIL_ID,
                'GIR_NO' => $borrowerValue->GIR_NO,
                'RATION_CARD_NO' => $borrowerValue->RATION_CARD_NO,
                'DRIVING_LINC' => $borrowerValue->DRIVING_LINC,
                'NPR_NO' => $borrowerValue->NPR_NO,
                'PASSPORT_NO' => $borrowerValue->PASSPORT_NO,
                'EXPORTER_CODE' => $borrowerValue->EXPORTER_CODE,
                'GST_NO' => $borrowerValue->GST_NO,
                'Voter_ID' => $borrowerValue->Voter_ID,
                'CUSTM_2' => $borrowerValue->CUSTM_2,
                'CATEGORY' => $borrowerValue->CATEGORY,
                'RELIGION' => $borrowerValue->RELIGION,
                'MINORITY_STATUS' => $borrowerValue->MINORITY_STATUS,
                'CASTE' => $borrowerValue->CASTE,
                'SUB_CAST' => $borrowerValue->SUB_CAST,
                'RESERVATION_TYP' => $borrowerValue->RESERVATION_TYP,
                'Physically_Challenged' => $borrowerValue->Physically_Challenged,
                'Weaker_Section' => $borrowerValue->Weaker_Section,
                'Valued_Customer' => $borrowerValue->Valued_Customer,
                'Special_Category_1' => $borrowerValue->Special_Category_1,
                'Vip_Category' => $borrowerValue->Vip_Category,
                'Special_Category_2' => $borrowerValue->Special_Category_2,
                'Senior_Citizen' => $borrowerValue->Senior_Citizen,
                'Senior_Citizen_From' => $borrowerValue->Senior_Citizen_From,
                'NO_OF_DEPEND' => $borrowerValue->NO_OF_DEPEND,
                'SPOUSE' => $borrowerValue->SPOUSE,
                'CHILDREN' => $borrowerValue->CHILDREN,
                'PARENTS' => $borrowerValue->PARENTS,
                'Employee_Staus' => $borrowerValue->Employee_Staus,
                'Employee_No' => $borrowerValue->Employee_No,
                'EMP_Date' => $borrowerValue->EMP_Date,
                'Nature_of_Occupation' => $borrowerValue->Nature_of_Occupation,
                'EMPLYEER_NAME' => $borrowerValue->EMPLYEER_NAME,
                'Role' => $borrowerValue->Role,
                'SPECIALIZATION' => $borrowerValue->SPECIALIZATION,
                'EMP_GRADE' => $borrowerValue->EMP_GRADE,
                'DESIGNATION' => $borrowerValue->DESIGNATION,
                'Office_Address' => $borrowerValue->Office_Address,
                'Office_Phone' => $borrowerValue->Office_Phone,
                'Office_EXTENSION' => $borrowerValue->Office_EXTENSION,
                'Office_Fax' => $borrowerValue->Office_Fax,
                'Office_MOBILE' => $borrowerValue->Office_MOBILE,
                'Office_PINCODE' => $borrowerValue->Office_PINCODE,
                'Office_CITY' => $borrowerValue->Office_CITY,
                'Working_Since' => $borrowerValue->Working_Since,
                'Working_in_Current_company_Yrs' => $borrowerValue->Working_in_Current_company_Yrs,
                'RETIRE_AGE' => $borrowerValue->RETIRE_AGE,
                'Nature_of_Business' => $borrowerValue->Nature_of_Business,
                'Annual_Income' => $borrowerValue->Annual_Income,
                'Prof_Self_Employed' => $borrowerValue->Prof_Self_Employed,
                'Prof_Self_Annual_Income' => $borrowerValue->Prof_Self_Annual_Income,
                'IT_RETURN_YR1' => $borrowerValue->IT_RETURN_YR1,
                'INCOME_DECLARED1' => $borrowerValue->INCOME_DECLARED1,
                'TAX_PAID' => $borrowerValue->TAX_PAID,
                'REFUND_CLAIMED1' => $borrowerValue->REFUND_CLAIMED1,
                'IT_RETURN_YR2' => $borrowerValue->IT_RETURN_YR2,
                'INCOME_DECLARED2' => $borrowerValue->INCOME_DECLARED2,
                'TAX_PAID2' => $borrowerValue->TAX_PAID2,
                'REFUND_CLAIMED2' => $borrowerValue->REFUND_CLAIMED2,
                'IT_RETURN_YR3' => $borrowerValue->IT_RETURN_YR3,
                'INCOME_DECLARED3' => $borrowerValue->INCOME_DECLARED3,
                'TAX_PAID3' => $borrowerValue->TAX_PAID3,
                'REFUND_CLAIMED3' => $borrowerValue->REFUND_CLAIMED3,
                'Maiden_Title' => $borrowerValue->Maiden_Title,
                'Maiden_First_Name' => $borrowerValue->Maiden_First_Name,
                'Maiden_Middle_Name' => $borrowerValue->Maiden_Middle_Name,
                'Maiden_Last_Name' => $borrowerValue->Maiden_Last_Name,
                'Father_Title' => $borrowerValue->Father_Title,
                'Father_First_Name' => $borrowerValue->Father_First_Name,
                'Father_Middle_Name' => $borrowerValue->Father_Middle_Name,
                'Father_Last_Name' => $borrowerValue->Father_Last_Name,
                'Mother_Title' => $borrowerValue->Mother_Title,
                'Mother_First_Name' => $borrowerValue->Mother_First_Name,
                'Mothers_Maiden_Name' => $borrowerValue->Mothers_Maiden_Name,
                'Generic_Surname' => $borrowerValue->Generic_Surname,
                'Spouse_Title' => $borrowerValue->Spouse_Title,
                'Spouse_First_Name' => $borrowerValue->Spouse_First_Name,
                'Spouse_Family_Name' => $borrowerValue->Spouse_Family_Name,
                'Identification_Mark' => $borrowerValue->Identification_Mark,
                'Country_of_Domicile' => $borrowerValue->Country_of_Domicile,
                'Qualification' => $borrowerValue->Qualification,
                'Nationality' => $borrowerValue->Nationality,
                'Blood_Group' => $borrowerValue->Blood_Group,
                'Offences' => $borrowerValue->Offences,
                'Politically_Exposed' => $borrowerValue->Politically_Exposed,
                'Residence_Type' => $borrowerValue->Residence_Type,
                'AREA' => $borrowerValue->AREA,
                'land_mark' => $borrowerValue->land_mark,
                'Owned' => $borrowerValue->Owned,
                'Rented' => $borrowerValue->Rented,
                'Rent_Per_Month' => $borrowerValue->Rent_Per_Month,
                'Ancestral' => $borrowerValue->Ancestral,
                'Staying_Since' => $borrowerValue->Staying_Since,
                'EMPLOYERRS' => $borrowerValue->EMPLOYERRS,
                'agreement_details' => $agreement
            ];
        }

        return response()->json(['message' => 'Borrower List', 'data' => $data]);
    }
}
