<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementData;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class PDFController extends Controller
{
    public function showPdf(Request $request, $id)
    {
        $agreement = Agreement::select('html')->findOrFail($id);
        $data = [
            'fileName' => 'personal_loan_pdf',
            'title' => 'personal loan pdf',
            'date' => date('Y-m-d'),
            'html' => $agreement->html
        ];

        // show in browser
        $viewhtml = View::make('admin.pdf.index', $data)->render();
        // $viewhtml = View::make('admin.agreement.pdf', $data)->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($viewhtml)->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function generatePdf(Request $request, $id)
    {
        $agreement = Agreement::select('html')->findOrFail($id);
        $data = [
            'fileName' => 'personal_loan_pdf',
            'title' => 'personal loan pdf',
            'date' => date('Y-m-d'),
            'html' => $agreement->html
        ];

        // download
        $pdf = PDF::loadView('admin.agreement.pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->download($data['fileName'].'.pdf');
    }

    public function getData($agreement, $checkFeld,$image = false){
        $response = '';
        foreach ($agreement as $key => $value) {
            if($value->field_name == $checkFeld){
                $response = $value->field_value;
                break;
            }
        }
        
        return $response;
    }

    // dynamic PDF after filling up data
    public function showDynamicPdf(Request $request, $borrowerId, $agreementId)
    {
        $data = (object)[];
        $agreement = AgreementData::join('agreement_rfqs', 'agreement_data.rfq_id', '=', 'agreement_rfqs.id')->where('borrower_id', $borrowerId)->where('agreement_id', $agreementId)->get();

        $data->fileName = 'personal_loan_pdf';
        $data->title = 'personal loan pdf';
        $data->date = date('Y-m-d');
        $data->customerid = $this->getData($agreement, 'customerid');
        $data->nameoftheborrower = $this->getData($agreement, 'nameoftheborrower');
        $data->nameofthecoborrower = $this->getData($agreement, 'nameofthecoborrower');
        $data->nameoftheguarantor = $this->getData($agreement, 'nameoftheguarantor');
        $data->loanapplicationnumber = $this->getData($agreement, 'loanapplicationnumber');
        $data->loanaccountnumber = $this->getData($agreement, 'loanaccountnumber');

        // $data->signatureoftheauthorisedsignatory = $this->getData($agreement, 'signatureoftheauthorisedsignatory');
        // $data->signatureoftheborrower = $this->getData($agreement, 'signatureoftheborrower');
        // $data->signatureofthecoborrower = $this->getData($agreement, 'signatureofthecoborrower');

        // witness 1
        $data->witness1fullname = $this->getData($agreement, 'witness1fullname');
        $data->witness1streetaddress = $this->getData($agreement, 'witness1streetaddress');
        $data->witness1city = $this->getData($agreement, 'witness1city');
        $data->witness1pincode = $this->getData($agreement, 'witness1pincode');
        $data->witness1state = $this->getData($agreement, 'witness1state');

        // witness 2
        $data->witness2fullname = $this->getData($agreement, 'witness2fullname');
        $data->witness2streetaddress = $this->getData($agreement, 'witness2streetaddress');
        $data->witness2city = $this->getData($agreement, 'witness2city');
        $data->witness2pincode = $this->getData($agreement, 'witness2pincode');
        $data->witness2state = $this->getData($agreement, 'witness2state');

        // guarantor
        $data->guarantorfullname = $this->getData($agreement, 'guarantorfullname');
        $data->guarantorstreetaddress = $this->getData($agreement, 'guarantorstreetaddress');
        $data->guarantorcity = $this->getData($agreement, 'guarantorcity');
        $data->guarantorpincode = $this->getData($agreement, 'guarantorpincode');
        $data->guarantorstate = $this->getData($agreement, 'guarantorstate');

        // borrower
        $data->streetaddressoftheborrower = $this->getData($agreement, 'streetaddressoftheborrower');
        $data->pancardnumberoftheborrower = $this->getData($agreement, 'pancardnumberoftheborrower');
        $data->officiallyvaliddocumentsoftheborrower = $this->getData($agreement, 'officiallyvaliddocumentsoftheborrower');
        $data->occupationoftheborrower = $this->getData($agreement, 'occupationoftheborrower');
        $data->residentstatusoftheborrower = $this->getData($agreement, 'residentstatusoftheborrower');
        $data->dateofbirthoftheborrower = $this->getData($agreement, 'dateofbirthoftheborrower');
        $data->maritalstatusoftheborrower = $this->getData($agreement, 'maritalstatusoftheborrower');
        $data->highesteducationoftheborrower = $this->getData($agreement, 'highesteducationoftheborrower');
        $data->mobilenumberoftheborrower = $this->getData($agreement, 'mobilenumberoftheborrower');
        $data->emailidoftheborrower = $this->getData($agreement, 'emailidoftheborrower');

        // co-borrower
        $data->nameofthecoborrower = $this->getData($agreement, 'nameofthecoborrower');
        $data->streetaddressofthecoborrower = $this->getData($agreement, 'streetaddressofthecoborrower');
        $data->pancardnumberofthecoborrower = $this->getData($agreement, 'pancardnumberofthecoborrower');
        $data->officiallyvaliddocumentsofthecoborrower = $this->getData($agreement, 'officiallyvaliddocumentsofthecoborrower');
        $data->occupationofthecoborrower = $this->getData($agreement, 'occupationofthecoborrower');
        $data->residentstatusofthecoborrower = $this->getData($agreement, 'residentstatusofthecoborrower');
        $data->dateofbirthofthecoborrower = $this->getData($agreement, 'dateofbirthofthecoborrower');
        $data->maritalstatusofthecoborrower = $this->getData($agreement, 'maritalstatusofthecoborrower');
        $data->highesteducationofthecoborrower = $this->getData($agreement, 'highesteducationofthecoborrower');
        $data->mobilenumberofthecoborrower = $this->getData($agreement, 'mobilenumberofthecoborrower');
        $data->emailidofthecoborrower = $this->getData($agreement, 'emailidofthecoborrower');

        // agreement place & date
        $data->placeofagreement = $this->getData($agreement, 'placeofagreement');
        $data->dateofagreement = $this->getData($agreement, 'dateofagreement');





        // $data = [
        //     'fileName' => 'personal_loan_pdf',
        //     'title' => 'personal loan pdf',
        //     'date' => date('Y-m-d'),
        //     'customerid' => $this->getData($agreement, 'customerid'),
        //     'nameoftheborrower' => $this->getData($agreement, 'nameoftheborrower'),
        //     'nameofthecoborrower' => $this->getData($agreement, 'nameofthecoborrower'),
        //     'nameoftheguarantor' => $this->getData($agreement, 'nameoftheguarantor'),
        //     'loanapplicationnumber' => $this->getData($agreement, 'loanapplicationnumber'),
        //     'loanaccountnumber' => $this->getData($agreement, 'loanaccountnumber'),
        //     'signatureoftheauthorisedsignatory' => $this->getData($agreement, 'signatureoftheauthorisedsignatory',true),
        //     'signatureoftheborrower' => $this->getData($agreement, 'signatureoftheborrower'),
        //     'signatureofthecoborrower' => $this->getData($agreement, 'signatureofthecoborrower'),
        //     // 'value' => $agreement
        // ];

        // show in browser
        // $viewhtml = View::make('admin.agreement.dynamic.personal-loan-agreement', $data)->render();
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($viewhtml)->setPaper('a4', 'portrait');
        // return $pdf->stream();
        return view('admin.agreement.dynamic.personal-loan-agreement', compact('data'));
    }

    // dynamic PDF after filling up data
    public function showDynamicDOMPdf(Request $request, $borrowerId, $agreementId)
    {
        // $data = (object)[];
        $agreement = AgreementData::join('agreement_rfqs', 'agreement_data.rfq_id', '=', 'agreement_rfqs.id')->where('borrower_id', $borrowerId)->where('agreement_id', $agreementId)->get();

        // $data->fileName = 'personal_loan_pdf';
        // $data->title = 'personal loan pdf';
        // $data->date = date('Y-m-d');
        // $data->customerid = $this->getData($agreement, 'customerid');
        // $data->nameoftheborrower = $this->getData($agreement, 'nameoftheborrower');
        // $data->nameofthecoborrower = $this->getData($agreement, 'nameofthecoborrower');
        // $data->nameoftheguarantor = $this->getData($agreement, 'nameoftheguarantor');
        // $data->loanapplicationnumber = $this->getData($agreement, 'loanapplicationnumber');
        // $data->loanaccountnumber = $this->getData($agreement, 'loanaccountnumber');
        // $data->signatureoftheauthorisedsignatory = $this->getData($agreement, 'signatureoftheauthorisedsignatory');
        // $data->signatureoftheborrower = $this->getData($agreement, 'signatureoftheborrower');
        // $data->signatureofthecoborrower = $this->getData($agreement, 'signatureofthecoborrower');

        $data = [
            'fileName' => 'personal_loan_pdf',
            'title' => 'personal loan pdf',
            'date' => date('Y-m-d'),
            'customerid' => $this->getData($agreement, 'customerid'),
            'nameoftheborrower' => $this->getData($agreement, 'nameoftheborrower'),
            'nameofthecoborrower' => $this->getData($agreement, 'nameofthecoborrower'),
            'nameoftheguarantor' => $this->getData($agreement, 'nameoftheguarantor'),
            'loanapplicationnumber' => $this->getData($agreement, 'loanapplicationnumber'),
            'loanaccountnumber' => $this->getData($agreement, 'loanaccountnumber'),
            'signatureoftheauthorisedsignatory' => $this->getData($agreement, 'signatureoftheauthorisedsignatory',true),
            'signatureoftheborrower' => $this->getData($agreement, 'signatureoftheborrower'),
            'signatureofthecoborrower' => $this->getData($agreement, 'signatureofthecoborrower'),
            // 'value' => $agreement
        ];

        // show in browser
        $viewhtml = View::make('admin.agreement.dynamic.personal-loan-agreement-old', $data)->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($viewhtml)->setPaper('a4', 'portrait');
        return $pdf->stream();
        // return view('admin.agreement.dynamic.personal-loan-agreement', compact('data'));
    }

    public function generateDynamicPdf(Request $request, $borrowerId, $agreementId)
    {
        $agreement = AgreementData::join('agreement_rfqs', 'agreement_data.rfq_id', '=', 'agreement_rfqs.id')->where('borrower_id', $borrowerId)->where('agreement_id', $agreementId)->get();
        $data = [
            'fileName' => 'personal_loan_pdf',
            'title' => 'personal loan pdf',
            'date' => date('Y-m-d'),
            'customerid' => $this->getData($agreement, 'customerid'),
            'nameoftheborrower' => $this->getData($agreement, 'nameoftheborrower'),
            'nameofthecoborrower' => $this->getData($agreement, 'nameofthecoborrower'),
            'nameoftheguarantor' => $this->getData($agreement, 'nameoftheguarantor'),
            'loanapplicationnumber' => $this->getData($agreement, 'loanapplicationnumber'),
            'loanaccountnumber' => $this->getData($agreement, 'loanaccountnumber'),
            'signatureoftheauthorisedsignatory' => $this->getData($agreement, 'signatureoftheauthorisedsignatory'),
            'signatureoftheborrower' => $this->getData($agreement, 'signatureoftheborrower'),
            'signatureofthecoborrower' => $this->getData($agreement, 'signatureofthecoborrower'),
            // 'value' => $agreement
        ];

        // download
        $pdf = PDF::loadView('admin.agreement.dynamic.personal-loan-agreement', $data)->setPaper('a4', 'portrait');
        return $pdf->download($data['fileName'].'.pdf');
    }
}
