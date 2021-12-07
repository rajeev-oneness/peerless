<?php

use App\Models\Activity;
use App\Models\AgreementData;
use App\Models\AgreementRfq;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

// generate alpha numeric for usage
function generateUniqueAlphaNumeric($length = 8)
{
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $number = random_int(0, 36);
        $character = base_convert($number, 10, 36);
        $random_string .= $character;
    }
    return $random_string;
}

// limit words in view, no need to show full text
function words($string, $words = 100)
{
    return \Illuminate\Support\Str::limit($string, $words);
}

// random number generate
function randomGenerator()
{
    return uniqid() . '' . date('ymdhis') . '' . uniqid();
}

// empty string check
function emptyCheck($string, $date = false)
{
    if ($date) {
        return !empty($string) ? date('Y-m-d', strtotime($string)) : '0000-00-00';
    }
    return !empty($string) ? $string : '';
}

// file upload from controller function
function fileUpload($file, $folder = 'image')
{
    $random = randomGenerator();
    $file->move('upload/' . $folder . '/', $random . '.' . $file->getClientOriginalExtension());
    $fileurl = 'upload/' . $folder . '/' . $random . '.' . $file->getClientOriginalExtension();
    return $fileurl;
}

function checkStringFileAray($data)
{
    if ($data != '') {
        if (is_array($data)) {
            return ($data ? implode(',', $data) : '');
        } elseif (is_string($data)) {
            return $data;
        } else {
            return fileUpload($data, 'agreementUploads');
        }
    }

    return '';
}

// form elements check & show values
/*** fields blade & admin.borrower.fields blade ***/
// parameters fields id, field name - placeholder, field type - text/email, value - select/radio, 
function form3lements($field_id, $name, $type, $value=null, $key_name, $required=null, $borrowerId=null, $form_type=null)
{
    $respValue = '';
    $disabledField = '';
    if (!empty($borrowerId)) {
        // in case of adding agreement data, auto-fill borrower details starts
        if (isset($form_type) == 'create') {
            // fetching borrower details
            $borrower = \App\Models\Borrower::findOrFail($borrowerId);
            switch($key_name){
                // borrower id
                case 'customerid' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->id;
                    break;
                // borrower name prefix
                case 'prefixoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->name_prefix;
                    break;
                // borrower full name
                case 'nameoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->full_name;
                    break;
                // borrower date of birth
                case 'dateofbirthoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->date_of_birth;
                    break;
                // borrower email id
                case 'emailidoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->email;
                    break;
                // borrower mobile number
                case 'mobilenumberoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->mobile;
                    break;
                // borrower pan card number
                case 'pancardnumberoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->pan_card_number;
                    break;
                // borrower occupation
                case 'occupationoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->occupation;
                    break;
                // borrower marital status
                case 'maritalstatusoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->marital_status;
                    break;
                // borrower street address
                case 'streetaddressoftheborrower' :
                    $disabledField = 'disabled';
                    $respValue = $borrower->street_address;
                    break;
                default :
                    $disabledField = '';
                    $respValue = '';
                    break;
            }
        }
        // in case of adding agreement data, auto-fill borrower details ends

        $rfq = AgreementRfq::select('id')->where('borrower_id', $borrowerId)->first();

        if ($rfq) {
            $agreementData = AgreementData::where('rfq_id', $rfq->id)->where('field_name', $key_name)->first();
            if ($agreementData) $respValue = $agreementData->field_value;

            $disabledField = 'disabled';
        }
    }

    // adding extra text after fields
    $extraPostField = '';
    $extraPreField = '';
    if ($key_name == 'loanamountindigits') $extraPreField = '<span class="post-text">Rs.</span>';
    if ($key_name == 'processingchargeinpercentage') $extraPostField = '<span class="post-text">+ Taxes</span>';
    if ($key_name == 'documentationfee') {
        $extraPreField = '<span class="post-text">Rs.</span>';
        $extraPostField = '<span class="post-text">+ Taxes</span>';
    }

    // working with required/ optional fields
    if ($key_name == 'otherdateofemicredit') $required = '';
    if ($key_name == 'demandpromissorynoteforcoborrowerdate') $required = '';
    if ($key_name == 'continuingsecurityletterdate2') $required = '';
    if ($key_name == 'otherdocumentstobeattachedwithapplicationforloan') $required = '';
    // if ($key_name == 'otherdateofemicredit' && $key_name = 'demandpromissorynoteforcoborrowerdate' && $key_name = 'continuingsecurityletterdate2') {
    //     $required = '';
    // }

    switch ($type) {
        case 'text':
            $response = $extraPreField.'<input type="text" placeholder="' . $name . '" class="form-control form-control-sm" name="field_name[' . $key_name . ']" ' . $required . ' value="' . $respValue . '" '.$disabledField.' ><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">'.$extraPostField;
            break;
        case 'email':
            $response = $extraPreField.'<input type="email" placeholder="' . $name . '" class="form-control form-control-sm" name="field_name[' . $key_name . ']" ' . $required . ' value="' . $respValue . '" '.$disabledField.'><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">'.$extraPostField;
            break;
        case 'number':
            $response = $extraPreField.'<input type="number" placeholder="' . $name . '" class="form-control form-control-sm" name="field_name[' . $key_name . ']" ' . $required . ' value="' . $respValue . '" '.$disabledField.'><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">'.$extraPostField;
            break;
        case 'date':
            $response = $extraPreField.'<input type="date" placeholder="' . $name . '" class="form-control form-control-sm" name="field_name[' . $key_name . ']" ' . $required . ' value="' . $respValue . '" '.$disabledField.'><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">'.$extraPostField;
            break;
        case 'time':
            $response = $extraPreField.'<input type="time" placeholder="' . $name . '" class="form-control form-control-sm" name="field_name[' . $key_name . ']" ' . $required . ' value="' . $respValue . '" '.$disabledField.'><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">'.$extraPostField;
            break;
        case 'file':
            $response = '<div class="custom-file custom-file-sm"><input type="file" class="custom-file-input" id="customFile" name="field_name[' . $key_name . ']" ' . $required . ' '.$disabledField.'><label class="custom-file-label" for="customFile">Choose ' . $name . '</label></div><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">';
            break;
        case 'select':
            $expValue = explode(', ', $value);
            $option = '<option value="" selected hidden>Select ' . $name . '</option>';
            foreach ($expValue as $index => $val) {
                $selected = '';
                if (strtolower($respValue) == strtolower($val)) $selected = 'selected';

                $option .= '<option value="' . $val . '" ' . $selected . '>' . $val . '</option>';
            }
            $response = '<select class="form-control form-control-sm" name="field_name[' . $key_name . ']" ' . $required . ' '.$disabledField.'>' . $option . '</select><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">';
            break;
        case 'checkbox':
            $expValue = explode(', ', $value);
            $checkedValues = explode(',', strtolower($respValue));
            $option = '';
            foreach ($expValue as $index => $val) {
                $checked = '';
                if(in_array(strtolower($val),$checkedValues)) {$checked = 'checked';}

                $option .= '<div class="single-checkbox-holder"><input class="form-check-input" type="checkbox" name="field_name[' . $key_name . '][]" id="' . $key_name . '-' . $index . '" value="' . $val . '" '.$checked.' '.$disabledField.'> <label for="' . $key_name . '-' . $index . '" class="form-check-label mr-1">' . $val.' </label></div>';
            }
            $response = '<div class="form-check">' . $option . '</div><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">';
            break;
        case 'radio':
            $expValue = explode(', ', $value);
            $option = '';
            foreach ($expValue as $index => $val) {
                $checked = '';
                if ($respValue == $val) $checked = 'checked';
                $option .= '<input class="form-check-input" type="radio" name="field_name[' . $key_name . ']" id="' . $key_name . '-' . $index . '" value="' . $val . '" ' . $required . ' ' . $checked . ' '.$disabledField.'> <label for="' . $key_name . '-' . $index . '" class="form-check-label mr-1">' . $val . '</label><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">';
            }
            $response = '<div class="form-check form-check-inline">' . $option . '</div>';
            break;
        case 'textarea':
            $response = '<textarea placeholder="' . $name . '" class="form-control form-control-sm" style="min-height:50px;max-height:100px" name="field_name[' . $key_name . ']" ' . $required . ' '.$disabledField.'>' . $respValue . '</textarea><input type="hidden" value="' . $field_id . '" name="field_id[' . $field_id . ']">';
            break;
        default:
            $response = '<input type="text">';
            break;
    }

    return $response;
}

// generate key name from field name
function generateKeyForForm(string $string)
{
    $key = '';
    for ($i = 0; $i < strlen($string); $i++) {
        if (!preg_match('/[^A-Za-z]+/', $string[$i])) {
            $key .= strtolower($string[$i]);
        }
    }
    return $key;
}

// send mail helper
function SendMail($data)
{
    // mail log
    $newMail = new \App\Models\MailLog();
    $newMail->from = env('MAIL_FROM_ADDRESS');
    $newMail->to = $data['email'];
    $newMail->subject = $data['subject'];
    $newMail->blade_file = $data['blade_file'];
    $newMail->payload = json_encode($data);
    $newMail->save();

    // send mail
    Mail::send('mail/' . $data['blade_file'], $data, function ($message) use ($data) {
        $message->to($data['email'], $data['name'])
            ->subject($data['subject'])
            ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
    });
}

// notification create helper
function createNotification(int $sender, int $receiver, string $type, string $message = null, string $route = null)
{
    switch ($type) {
        case 'user_registration':
            $title = 'Registration successfull';
            $message = 'Please check & update your profile as needed';
            $route = 'user.profile';
            break;
        case 'new_borrower':
            $title = 'New borrower created';
            $message = $message;
            $route = 'user.borrower.list';
            break;
        case 'agreement_data_upload':
            $title = 'Agreement data uploaded';
            $message = $message;
            $route = $route;
            break;
        default:
            $title = '';
            $message = '';
            $route = '';
            break;
    }

    $notification = new App\Models\Notification;
    $notification->sender_id = $sender;
    $notification->receiver_id = $receiver;
    $notification->type = $type;
    $notification->title = $title;
    $notification->message = $message;
    $notification->route = $route;
    $notification->save();
}

// activity log helper
function activityLog(array $data)
{
    $activity = new Activity;
    $activity->user_id = auth()->user()->id;
    $activity->user_device = '';
    $activity->ip_address = Request::ip();
    $activity->latitude = '';
    $activity->longitude = '';
    $activity->type = $data['type'];
    $activity->title = $data['title'];
    $activity->description = $data['desc'];
    $activity->save();
}

// check if agreement related document is uploaded or not
function documentSrc(int $agreement_document_id, int $borrower_id, string $type)
{
    $image = asset('admin/static-required/blank.png');
    $detailsShow = '<label for="file_' . $agreement_document_id . '" class="btn btn-xs btn-primary" id="image__preview_label' . $agreement_document_id . '">Browse <i class="fas fa-camera"></i></label>';

    $document = \App\Models\AgreementDocumentUpload::where('agreement_document_id', $agreement_document_id)->where('borrower_id', $borrower_id)->where('status', 1)->latest()->first();
    if ($document) {
        $image = asset($document->file_path);

        $verifyShow = '<a href="javascript: void(0)" class="btn btn-xs btn-success mb-2" title="Document verified" onclick="viewUploadedDocument(' . $document->id . ')" id="verifyDocToggle' . $document->id . '"> <i class="fas fa-clipboard-check"></i> </a>';
        if ($document->verify == 0) {
            $verifyShow = '<a href="javascript: void(0)" class="btn btn-xs btn-danger mb-2" title="Document unverified" onclick="viewUploadedDocument(' . $document->id . ')" id="verifyDocToggle' . $document->id . '"> <i class="fas fa-question-circle"></i> </a>';
        }

        $detailsShow = '<a href="javascript: void(0)" class="btn btn-xs btn-primary mb-2" onclick="viewUploadedDocument(' . $document->id . ')"><i class="fas fa-eye"></i></a> <label for="file_' . $agreement_document_id . '" class="btn btn-xs btn-dark" id="image__preview_label' . $agreement_document_id . '">Browse <i class="fas fa-camera"></i></label> ' . $verifyShow;
    }

    if ($type == 'image') {
        return $image;
    } else {
        return $detailsShow;
    }
}
