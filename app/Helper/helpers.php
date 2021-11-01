<?php

function userTypeCheck($type) {
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