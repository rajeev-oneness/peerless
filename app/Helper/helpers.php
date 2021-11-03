<?php

use App\Models\MailLog;
use Illuminate\Support\Facades\Mail;

function userTypeCheck($type)
{
    switch ($type) {
        case 'admin':
            return '<span class="badge badge-danger">ADMIN</span>';
            break;
        default:
            return '<span class="badge badge-success">USER</span>';
            break;
    }
}

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

function words($string, $words = 100)
{
	return \Illuminate\Support\Str::limit($string, $words);
}

function form3lements($name=null, $type, $value=null, $key_name=null)
{
    switch ($type) {
        case 'text':
            $response = '<input type="text" placeholder="'.$name.'" class="form-control form-control-sm w-50">';
            break;
        case 'email':
            $response = '<input type="email" placeholder="'.$name.'" class="form-control form-control-sm w-50">';
            break;
        case 'number':
            $response = '<input type="number" placeholder="'.$name.'" class="form-control form-control-sm w-50">';
            break;
        case 'date':
            $response = '<input type="date" placeholder="'.$name.'" class="form-control form-control-sm w-50">';
            break;
        case 'time':
            $response = '<input type="time" placeholder="'.$name.'" class="form-control form-control-sm w-50">';
            break;
        case 'file':
            $response = '<div class="custom-file custom-file-sm w-50"><input type="file" class="custom-file-input" id="customFile"><label class="custom-file-label" for="customFile">Choose '.$name.'</label></div>';
            break;
        case 'select':
            $expValue = explode(', ', $value);
            $option = '<option>Select '.$name.'</option>';
            foreach($expValue as $index => $val) {
                $option .= '<option value="'.$val.'">'.$val.'</option>';
            }
            $response = '<select class="form-control form-control-sm w-50">'.$option.'</select>';
            break;
        case 'checkbox':
            $expValue = explode(', ', $value);
            $option = '';
            foreach($expValue as $index => $val) {
                $option .= '<input class="form-check-input" type="checkbox" name="'.$key_name.'" id="'.$key_name.'-'.$index.'"> <label for="'.$key_name.'-'.$index.'" class="form-check-label mr-1">'.$val.'</label>';
            }
            $response = '<div class="form-check form-check-inline">'.$option.'</div>';
            break;
        case 'radio':
            $expValue = explode(', ', $value);
            $option = '';
            foreach($expValue as $index => $val) {
                $option .= '<input class="form-check-input" type="radio" name="'.$key_name.'" id="'.$key_name.'-'.$index.'"> <label for="'.$key_name.'-'.$index.'" class="form-check-label mr-1">'.$val.'</label>';
            }
            $response = '<div class="form-check form-check-inline">'.$option.'</div>';
            break;
        case 'textarea':
            $response = '<textarea placeholder="'.$name.'" class="form-control form-control-sm w-50" style="min-height:50px;max-height:100px"></textarea>';
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
