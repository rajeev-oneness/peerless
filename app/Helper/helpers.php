<?php

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
            $response = '<div class="custom-file w-50"><input type="file" class="custom-file-input" id="customFile"><label class="custom-file-label custom-file-label-sm" for="customFile">Browse '.$name.'</label></div>';
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