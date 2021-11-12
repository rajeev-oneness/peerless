<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('type')->comment('input text, input email, textarea, select');
            $table->longText('value')->nullable()->comment('comma separated value of fields');
            $table->text('key_name');
            $table->tinyInteger('required')->default(0)->comment('1 is required, 0 is not');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $validDocumentsList = 'PAN card, Aadhar card, Bank Statement, Driving License, Passport';
        $natureOfLoan = 'Holiday/ Vacation financing, To Finance Festive Celebrations or Needs, Finance Weddings, Build/ Renovate house, Medical Emergency, Refinancing The Home Loan, To Fix A Car, Financing Education, Business Expansion, Debt Consolidation';
        $loanApplicationDocumentsToAttach = 'Salary Certificate from current Employer, Proof of identity, Proof of current residential & official address, Latest three months&apos; Bank Statement (where salary / income is credited or accumulated), Salary slips for last three months preceding application date, Two passport size photographs, Certified copy of standing Instructions/ Signed ECS / ACH mandate/other relevant mandate to designated bank&#44; of the Borrower(s) to transfer to the Lender on the Due Dates&#44; the amounts which are required to be paid by the Borrower(s)&#44; as specified in terms of Repayment in Schedule II, Copies of last 2 years&apos; ITR, Signature Verification by banker (as per PFSL format), Proof of other income, Proof of assets (copy of registered deed of house property / statement of accounts of mutual fund / insurance policy / statement of demat account), Guarantor&apos;s net worth certificate (as per PFSL format)';

        $data = [
            // ['name' => 'Name prefix', 'type' => '7', 'value' => 'Mr., Ms., Mrs.', 'key_name' => 'nameprefix'],
            // ['name' => 'First name', 'type' => '1', 'value' => '', 'key_name' => 'firstname'],
            // ['name' => 'Middle name', 'type' => '1', 'value' => '', 'key_name' => 'middlename'],
            // ['name' => 'Last name', 'type' => '1', 'value' => '', 'key_name' => 'lastname'],
            // ['name' => 'Date of birth', 'type' => '4', 'value' => '', 'key_name' => 'dateofbirth'],
            // ['name' => 'Marital status', 'type' => '7', 'value' => 'Married, Unmarried, Divorced, Widowed', 'key_name' => 'maritalstatus'],
            // ['name' => 'Email id', 'type' => '2', 'value' => '', 'key_name' => 'emailid'],
            // ['name' => 'Phone number', 'type' => '3', 'value' => '', 'key_name' => 'phonenumber'],

            ['name' => 'Name of the authorised signatory', 'type' => 1, 'value' => '', 'key_name' => 'nameoftheauthorisedsignatory'],
            ['name' => 'Stamp of the authorised signatory', 'type' => 6, 'value' => '', 'key_name' => 'stampoftheauthorisedsignatory'],
            ['name' => 'Signature of the authorised signatory', 'type' => 6, 'value' => '', 'key_name' => 'signatureoftheauthorisedsignatory'],

            // borrower details
            ['name' => 'Customer ID', 'type' => 1, 'value' => '', 'key_name' => 'customerid'],
            ['name' => 'Prefix of the Borrower', 'type' => 7, 'value' => 'Mr., Ms., Mrs.', 'key_name' => 'prefixoftheborrower'],
            ['name' => 'Name of the Borrower', 'type' => 1, 'value' => '', 'key_name' => 'nameoftheborrower'],
            ['name' => 'Street address of the Borrower', 'type' => 1, 'value' => '', 'key_name' => 'streetaddressoftheborrower'],
            ['name' => 'PAN card number of the Borrower', 'type' => 1, 'value' => '', 'key_name' => 'pancardnumberoftheborrower'],
            ['name' => 'Officially Valid Documents of the Borrower', 'type' => 8, 'value' => $validDocumentsList, 'key_name' => 'officiallyvaliddocumentsoftheborrower'],
            ['name' => 'Occupation of the Borrower', 'type' => 1, 'value' => $validDocumentsList, 'key_name' => 'occupationoftheborrower'],
            ['name' => 'Resident status of the Borrower', 'type' => 8, 'value' => 'Permanent address, Temporary address', 'key_name' => 'residentstatusoftheborrower'],
            ['name' => 'Date of birth of the Borrower', 'type' => 4, 'value' => '', 'key_name' => 'dateofbirthoftheborrower'],
            ['name' => 'Marital status of the Borrower', 'type' => 7, 'value' => 'Married, Unmarried, Divorced, Widowed', 'key_name' => 'maritalstatusoftheborrower'],
            ['name' => 'Highest education of the Borrower', 'type' => 4, 'value' => '', 'key_name' => 'highesteducationoftheborrower'],
            ['name' => 'Mobile number of the Borrower', 'type' => 4, 'value' => '', 'key_name' => 'mobilenumberoftheborrower'],
            ['name' => 'Email ID of the Borrower', 'type' => 4, 'value' => '', 'key_name' => 'emailidoftheborrower'],
            ['name' => 'Signature of the Borrower', 'type' => 6, 'value' => '', 'key_name' => 'signatureoftheborrower'],

            // co borrower details
            ['name' => 'Prefix of the Co-Borrower', 'type' => 7, 'value' => 'Mr., Ms., Mrs.', 'key_name' => 'prefixofthecoborrower'],
            ['name' => 'Name of the Co-Borrower', 'type' => 1, 'value' => '', 'key_name' => 'nameofthecoborrower'],
            ['name' => 'Street address of the Co-Borrower', 'type' => 1, 'value' => '', 'key_name' => 'streetaddressofthecoborrower'],
            ['name' => 'PAN card number of the Co-Borrower', 'type' => 1, 'value' => '', 'key_name' => 'pancardnumberofthecoborrower'],
            ['name' => 'Officially Valid Documents of the Co-Borrower', 'type' => 8, 'value' => $validDocumentsList, 'key_name' => 'officiallyvaliddocumentsofthecoborrower'],
            ['name' => 'Occupation of the Co-Borrower', 'type' => 1, 'value' => $validDocumentsList, 'key_name' => 'occupationofthecoborrower'],
            ['name' => 'Resident status of the Co-Borrower', 'type' => 8, 'value' => 'Permanent address, Temporary address', 'key_name' => 'residentstatusofthecoborrower'],
            ['name' => 'Date of birth of the Co-Borrower', 'type' => 4, 'value' => '', 'key_name' => 'dateofbirthofthecoborrower'],
            ['name' => 'Marital status of the Co-Borrower', 'type' => 7, 'value' => 'Married, Unmarried, Divorced, Widowed', 'key_name' => 'maritalstatusofthecoborrower'],
            ['name' => 'Highest education of the Co-Borrower', 'type' => 4, 'value' => '', 'key_name' => 'highesteducationofthecoborrower'],
            ['name' => 'Mobile number of the Co-Borrower', 'type' => 4, 'value' => '', 'key_name' => 'mobilenumberofthecoborrower'],
            ['name' => 'Email ID of the Co-Borrower', 'type' => 4, 'value' => '', 'key_name' => 'emailidofthecoborrower'],
            ['name' => 'Signature of the Co-Borrower', 'type' => 6, 'value' => '', 'key_name' => 'signatureofthecoborrower'],

            // guarantor details
            ['name' => 'Name of the Guarantor', 'type' => 1, 'value' => '', 'key_name' => 'nameoftheguarantor'],
            ['name' => 'Loan Application Number', 'type' => 1, 'value' => '', 'key_name' => 'loanapplicationnumber'],
            ['name' => 'Loan Account Number', 'type' => 1, 'value' => '', 'key_name' => 'loanaccountnumber'],

            // witness 1 details
            ['name' => 'Witness 1 Full name', 'type' => 1, 'value' => '', 'key_name' => 'witness1fullname'],
            ['name' => 'Witness 1 Street address', 'type' => 1, 'value' => '', 'key_name' => 'witness1streetaddress'],
            ['name' => 'Witness 1 City', 'type' => 1, 'value' => '', 'key_name' => 'witness1city'],
            ['name' => 'Witness 1 Pincode', 'type' => 1, 'value' => '', 'key_name' => 'witness1pincode'],
            ['name' => 'Witness 1 State', 'type' => 1, 'value' => '', 'key_name' => 'witness1state'],
            ['name' => 'Witness 1 Signature', 'type' => 6, 'value' => '', 'key_name' => 'witness1signature'],

            // witness 2 details
            ['name' => 'Witness 2 Full name', 'type' => 1, 'value' => '', 'key_name' => 'witness2fullname'],
            ['name' => 'Witness 2 Street address', 'type' => 1, 'value' => '', 'key_name' => 'witness2streetaddress'],
            ['name' => 'Witness 2 City', 'type' => 1, 'value' => '', 'key_name' => 'witness2city'],
            ['name' => 'Witness 2 Pincode', 'type' => 1, 'value' => '', 'key_name' => 'witness2pincode'],
            ['name' => 'Witness 2 State', 'type' => 1, 'value' => '', 'key_name' => 'witness2state'],
            ['name' => 'Witness 2 Signature', 'type' => 6, 'value' => '', 'key_name' => 'witness2signature'],

            // guarantor details
            ['name' => 'Guarantor Full name', 'type' => 1, 'value' => '', 'key_name' => 'guarantorfullname'],
            ['name' => 'Guarantor Street address', 'type' => 1, 'value' => '', 'key_name' => 'guarantorstreetaddress'],
            ['name' => 'Guarantor City', 'type' => 1, 'value' => '', 'key_name' => 'guarantorcity'],
            ['name' => 'Guarantor Pincode', 'type' => 1, 'value' => '', 'key_name' => 'guarantorpincode'],
            ['name' => 'Guarantor State', 'type' => 1, 'value' => '', 'key_name' => 'guarantorstate'],
            ['name' => 'Guarantor Signature', 'type' => 6, 'value' => '', 'key_name' => 'guarantorsignature'],

            // agreement details
            ['name' => 'Place of agreement', 'type' => 1, 'value' => '', 'key_name' => 'placeofagreement'],
            ['name' => 'Date of agreement', 'type' => 4, 'value' => '', 'key_name' => 'dateofagreement'],

            // key facts of the loan
            ['name' => 'Nature of Loan', 'type' => 1, 'value' => '', 'key_name' => $natureOfLoan],
            ['name' => 'Loan amount in digits', 'type' => 1, 'value' => '', 'key_name' => 'loanamountindigits'],
            ['name' => 'Loan amount in words', 'type' => 1, 'value' => '', 'key_name' => 'loanamountinwords'],
            ['name' => 'Purpose of Loan', 'type' => 1, 'value' => '', 'key_name' => 'purposeofloan'],
            ['name' => 'Repayment tenure', 'type' => 1, 'value' => '', 'key_name' => 'repaymenttenure'],
            ['name' => 'Rate of Interest', 'type' => 1, 'value' => '', 'key_name' => 'rateofinterest'],
            ['name' => 'Processing & Documentation charges', 'type' => 1, 'value' => '', 'key_name' => 'processingdocumentationcharges'],
            ['name' => 'Security & Margin', 'type' => 1, 'value' => '', 'key_name' => 'securitymargin'],
            ['name' => 'Guarantee', 'type' => 1, 'value' => '', 'key_name' => 'guarantee'],
            ['name' => 'Monthly instalments number', 'type' => 1, 'value' => '', 'key_name' => 'monthlyinstalmentsnumber'],
            ['name' => 'Monthly EMI in digits', 'type' => 1, 'value' => '', 'key_name' => 'monthlyemiindigits'],
            ['name' => 'Monthly EMI in words', 'type' => 1, 'value' => '', 'key_name' => 'monthlyemiinwords'],
            ['name' => 'Payment deduction from', 'type' => 8, 'value' => 'Deducted from the Borrower&apos;s salary by the Borrower&apos;s employer on monthly basis and credited into the Lender&apos;s bank Account, directly debited from the Borrower&apos;s bank Account and credited into lender&apos;s bank Account', 'key_name' => 'paymentdeductionfrom'],
            ['name' => 'Date of credit of EMI into Lender&apos;s Bank Account', 'type' => 8, 'value' => '5th of every month, 2nd of every month, Others', 'key_name' => 'dateofcreditofemiintolendersbankaccount'],
            ['name' => 'Other date of EMI credit', 'type' => 1, 'value' => '', 'key_name' => 'otherdateofemicredit'],
            ['name' => 'Penal Interest percentage', 'type' => 1, 'value' => '', 'key_name' => 'penalinterestpercentage'],
            ['name' => 'Savings/ Current account number of Borrower', 'type' => 1, 'value' => '', 'key_name' => 'savingscurrentaccountnumberofborrower'],
            ['name' => 'Beneficiary Name of Borrower', 'type' => 1, 'value' => '', 'key_name' => 'beneficiarynameofborrower'],
            ['name' => 'Bank Name of Borrower', 'type' => 1, 'value' => '', 'key_name' => 'banknameofborrower'],
            ['name' => 'Branch Name of Borrower', 'type' => 1, 'value' => '', 'key_name' => 'branchnameofborrower'],
            ['name' => 'IFSC code of Borrower', 'type' => 1, 'value' => '', 'key_name' => 'ifsccodeofborrower'],
            ['name' => 'Insurance of Borrower', 'type' => 10, 'value' => '', 'key_name' => 'insuranceofborrower'],
            ['name' => 'Documents to be attached with application for loan', 'type' => 8, 'value' => $loanApplicationDocumentsToAttach, 'key_name' => 'documentstobeattachedwithapplicationforloan'],
            ['name' => 'Other documents to be attached with application for loan', 'type' => 1, 'value' => $loanApplicationDocumentsToAttach, 'key_name' => 'otherdocumentstobeattachedwithapplicationforloan'],

            // Personal loan facility agreement dated
            ['name' => 'Personal loan facility agreement dated', 'type' => 4, 'value' => '', 'key_name' => 'personalloanfacilityagreementdated'],
            ['name' => 'Deed of Personal Guarantee date', 'type' => 4, 'value' => '', 'key_name' => 'deedofpersonalguaranteedate'],
            ['name' => 'Deed of Pledge of Moveable Properties (Shares, Bonds, Debentures, Mutual Funds) date', 'type' => 4, 'value' => '', 'key_name' => 'deedofpledgeofmoveablepropertiessharesbondsdebenturesmutualfundsdate'],
            ['name' => 'Deed of Mortgage of Inmoveable Properties (Land, House, Warehouse) date', 'type' => 4, 'value' => '', 'key_name' => 'deedofmortgageofinmoveablepropertieslandhousewarehousedate'],
            ['name' => 'Power of Attorney date', 'type' => 4, 'value' => '', 'key_name' => 'powerofattorneydate'],
            ['name' => 'Deed of Assignment (Insurance Policy, Fixed Deposit) date', 'type' => 4, 'value' => '', 'key_name' => 'deedofassignmentinsurance policyfixeddepositdate'],

            // DEMAND PROMISSORY NOTE
            ['name' => 'Demand Promissory Note Place', 'type' => 1, 'value' => '', 'key_name' => 'demandpromissorynoteplace'],
            ['name' => 'Demand Promissory Note Date', 'type' => 4, 'value' => '', 'key_name' => 'demandpromissorynotedate'],
            ['name' => 'Demand Promissory Note Amount', 'type' => 1, 'value' => '', 'key_name' => 'demandpromissorynoteamount'],

            // file uploads
            ['name' => 'Borrower&apos;s request to employer for EMI deduction from salary', 'type' => 6, 'value' => '', 'key_name' => 'borrowersrequesttoemployerforemideductionfromsalary'],

            // NACH declaration
            ['name' => 'NACH Declaration for and on be half of', 'type' => 1, 'value' => '', 'key_name' => 'nachdeclarationforandonbehalfof'],
            ['name' => 'NACH Declaration Name 1', 'type' => 1, 'value' => '', 'key_name' => 'nachdeclarationname1'],
            ['name' => 'NACH Declaration Signature 1', 'type' => 6, 'value' => '', 'key_name' => 'nachdeclarationsignature1'],
            ['name' => 'NACH Declaration Name 2', 'type' => 1, 'value' => '', 'key_name' => 'nachdeclarationname2'],
            ['name' => 'NACH Declaration Signature 2', 'type' => 6, 'value' => '', 'key_name' => 'nachdeclarationsignature2'],
            ['name' => 'NACH Declaration Name 3', 'type' => 1, 'value' => '', 'key_name' => 'nachdeclarationname3'],
            ['name' => 'NACH Declaration Signature 3', 'type' => 6, 'value' => '', 'key_name' => 'nachdeclarationsignature3'],
            ['name' => 'NACH Declaration Name 4', 'type' => 1, 'value' => '', 'key_name' => 'nachdeclarationname4'],
            ['name' => 'NACH Declaration Signature 4', 'type' => 6, 'value' => '', 'key_name' => 'nachdeclarationsignature4'],

            // MISCELLANEOUS DOCUMENTS upload
            ['name' => 'Miscellaneous documents upload', 'type' => 6, 'value' => '', 'key_name' => 'miscellaneousdocumentsupload'],
            // ['name' => 'CustomerID', 'type' => 1, 'value' => '', 'key_name' => 'customerid'],
        ];

        DB::table('fields')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
