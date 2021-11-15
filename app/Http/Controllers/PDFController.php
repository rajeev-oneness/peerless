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

    public function getData($agreement, $checkFeld){
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
            'value' => $agreement
        ];

        // show in browser
        $viewhtml = View::make('admin.agreement.dynamic.personal-loan-agreement', $data)->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($viewhtml)->setPaper('a4', 'portrait');
        return $pdf->stream();
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
            'value' => $agreement
        ];

        // download
        $pdf = PDF::loadView('admin.agreement.dynamic.personal-loan-agreement', $data)->setPaper('a4', 'portrait');
        return $pdf->download($data['fileName'].'.pdf');
    }
}
