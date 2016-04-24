<?php

/* GLOBAL */
define('PAGE_ACCESS_TOKEN', 'CAAPkT5ZApWjMBAKCtMvPowjKMJ4ZBOC6NXIZBx1MA4bM88pozrsgiXsYJKYCLKVpJdZBz0efZBEc4MCkNN6ldc6E55b3vK6BZAfQDk6vgPPIm43oInwomEZCRpdxd6NtD2b8aNlGXNZAFDbxYqtvXBZAxwn4rFNmm1QYTXKMZBITZByqGTOUPAkY1Sm7JfYLQCAQZCppSxWzdRS7nwZDZD');

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'r8P>0(GxC\pzm8VAoj9g4YNBjh_NIh@dGGqjxABT8+6i>(bX#yn5Bt[r5wc7Gvax') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

// Get Guest Common Info
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

// Ghi logs
	_log('log',$sender." - ".$message);

// Init Facebook Bot...
subscribe();

echo reply("Xin chào bạn");

function subscribe()
{
	$url = "https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=".PAGE_ACCESS_TOKEN;

	echo sendRequest($url, '');

	// $ch = curl_init($url);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, '');
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// $data = curl_exec($ch);
	// echo $data;
	//var_dump(json_decode($result, true));
}

function sendRequest($url, $data = '')
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$data = curl_exec($ch);
	curl_close($ch);
	_log('error',$data);
	return $data;
}

function reply($mes)
{
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.PAGE_ACCESS_TOKEN;

	//The JSON data.
	$jsonData = '{
	    "recipient":{
	        "id":"'.$sender.'"
	    }, 
	    "message":{
	        "text":"Kỳ lạ thật"
	    }
	}';

	return sendRequest($url, $jsonData);
}

/*
function welcome(){
	$url = "https://graph.facebook.com/v2.6/327850837269511/thread_settings?access_token=".$p_token;

	$jsonData = '{
	    "recipient":{
	        "id":"'.$sender.'"
	    }, 
	    "message":{
	        "text":"Xin chào bạn!"
	    }
	}';

	sendRequest($url, $jsonData);
}

function getAnswer()
{
	$ans = "";
}

function getGuestInfo($uid)
{
	$url = "https://graph.facebook.com/v2.6/" + $uid + "?fields=first_name,last_name,profile_pic&access_token=".$p_token;

}
*/

function _log($type, $data)
{
	$filename = $type."s.txt";
	file_put_contents($filename, date("d/M/y h:m:s").$data."\n", FILE_APPEND);
}

?>