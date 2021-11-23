<?php

use App\Models\MailLog;
use App\Models\Activity;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\Mail;

// check user type
// function userTypeCheck($type)
// {
//     switch ($type) {
//         case 'admin':
//             return '<span class="badge badge-danger">ADMIN</span>';
//             break;
//         default:
//             return '<span class="badge badge-success">USER</span>';
//             break;
//     }
// }

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

// limit words
function words($string, $words = 100)
{
	return \Illuminate\Support\Str::limit($string, $words);
}

// random number generate
function randomGenerator()
{
    return uniqid().''.date('ymdhis').''.uniqid();
}

function emptyCheck($string,$date=false)
{
    if($date){
        return !empty($string) ? date('Y-m-d',strtotime($string)) : '0000-00-00';
    }
    return !empty($string) ? $string : '';
}

function fileUpload($file,$folder='image')
{
    $random = randomGenerator();
    $file->move('upload/'.$folder.'/',$random.'.'.$file->getClientOriginalExtension());
    $fileurl = 'upload/'.$folder.'/'.$random.'.'.$file->getClientOriginalExtension();
    return $fileurl;
}

function checkStringFileAray($data)
{
    if($data != '') {
        if(is_array($data)) {
            return ($data ? implode(',',$data) : '');
        } elseif(is_string($data)) {
            return $data;
        } else {
            return fileUpload($data,'agreementUploads');
        }
    }
    return '';
}

function form3lements($field_id, $name=null, $type, $value=null, $key_name=null, $width=100, $required='', $fieldValue='')
{
    switch ($type) {
        case 'text':
            $response = '<input type="text" placeholder="'.$name.'" class="form-control form-control-sm w-'.$width.'" name="field_name['.$key_name.']" '.$required.' value="'.$fieldValue.'"><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'email':
            $response = '<input type="email" placeholder="'.$name.'" class="form-control form-control-sm w-'.$width.'" name="field_name['.$key_name.']" '.$required.'><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'number':
            $response = '<input type="number" placeholder="'.$name.'" class="form-control form-control-sm w-'.$width.'" name="field_name['.$key_name.']" '.$required.'><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'date':
            $response = '<input type="date" placeholder="'.$name.'" class="form-control form-control-sm w-'.$width.'" name="field_name['.$key_name.']" '.$required.'><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'time':
            $response = '<input type="time" placeholder="'.$name.'" class="form-control form-control-sm w-'.$width.'" name="field_name['.$key_name.']" '.$required.'><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'file':
            $response = '<div class="custom-file custom-file-sm w-'.$width.'"><input type="file" class="custom-file-input" id="customFile" name="field_name['.$key_name.']" '.$required.'><label class="custom-file-label" for="customFile">Choose '.$name.'</label></div><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'select':
            $expValue = explode(', ', $value);
            $option = '<option value="" selected hidden>Select '.$name.'</option>';
            foreach($expValue as $index => $val) {
                $option .= '<option value="'.$val.'">'.$val.'</option>';
            }
            $response = '<select class="form-control form-control-sm w-'.$width.'" name="field_name['.$key_name.']" '.$required.'>'.$option.'</select><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'checkbox':
            $expValue = explode(', ', $value);
            $option = '';
            foreach($expValue as $index => $val) {
                $option .= '<div class="single-checkbox-holder"><input class="form-check-input" type="checkbox" name="field_name['.$key_name.'][]" id="'.$key_name.'-'.$index.'" value="'.$val.'" '.$required.'> <label for="'.$key_name.'-'.$index.'" class="form-check-label mr-1">'.$val.'</label></div>';
            }
            $response = '<div class="form-check">'.$option.'</div><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        case 'radio':
            $expValue = explode(', ', $value);
            $option = '';
            foreach($expValue as $index => $val) {
                $option .= '<input class="form-check-input" type="radio" name="field_name['.$key_name.']" id="'.$key_name.'-'.$index.'" value="'.$val.'" '.$required.'> <label for="'.$key_name.'-'.$index.'" class="form-check-label mr-1">'.$val.'</label><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            }
            $response = '<div class="form-check form-check-inline">'.$option.'</div>';
            break;
        case 'textarea':
            $response = '<textarea placeholder="'.$name.'" class="form-control form-control-sm w-'.$width.'" style="min-height:50px;max-height:100px" name="field_name['.$key_name.']" '.$required.'></textarea><input type="hidden" value="'.$field_id.'" name="field_id['.$field_id.']">';
            break;
        default:
            $response = '<input type="text">';
            break;
    }

    return $response;
}

function generateKeyForForm($string)
{
    $key = '';
    for($i= 0; $i < strlen($string); $i++){
        if(!preg_match('/[^A-Za-z]+/', $string[$i])) {
            $key .= strtolower($string[$i]);
        }
    }
    return $key;
}

function SendMail($data) {
    // mail log
    $newMail = new \App\Models\MailLog();
    $newMail->from = env('MAIL_FROM_ADDRESS');
    $newMail->to = $data['email'];
    $newMail->subject = $data['subject'];
    $newMail->blade_file = $data['blade_file'];
    $newMail->payload = json_encode($data);
    $newMail->save();

    // send mail
    Mail::send('mail/'.$data['blade_file'], $data, function ($message) use ($data) {
        $message->to($data['email'], $data['name'])
                ->subject($data['subject'])
                ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
    });
}

function createNotification($sender, $receiver, $type)
{
    switch ($type) {
        case 'user_registration':
            $title = 'Registration successfull';
            $message = 'Please check & update your profile as needed';
            $route = 'user.profile';
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

// activity log
function activityLog($data) {
    $activity = new Activity;
    $activity->user_id = auth()->user()->id;
    $activity->user_device = '';
    $activity->ip_address = '';
    $activity->latitude = '';
    $activity->longitude = '';
    $activity->type = $data['type'];
    $activity->title = $data['title'];
    $activity->description = $data['desc'];
    $activity->save();
}
