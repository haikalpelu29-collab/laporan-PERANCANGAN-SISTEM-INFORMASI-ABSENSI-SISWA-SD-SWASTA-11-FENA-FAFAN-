<?php
$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
	'secret' => '6Ld_FoYrAAAAAFMrSzYD34FRuP_uTueeGdl5khe-',
	'response' => $_POST['g-recaptcha-response'],
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$result = json_decode($response);
return $result->success;
