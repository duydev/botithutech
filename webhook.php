<?php

/* GLOBAL */
define('PAGE_ACCESS_TOKEN', 'CAAPkT5ZApWjMBAKCtMvPowjKMJ4ZBOC6NXIZBx1MA4bM88pozrsgiXsYJKYCLKVpJdZBz0efZBEc4MCkNN6ldc6E55b3vK6BZAfQDk6vgPPIm43oInwomEZCRpdxd6NtD2b8aNlGXNZAFDbxYqtvXBZAxwn4rFNmm1QYTXKMZBITZByqGTOUPAkY1Sm7JfYLQCAQZCppSxWzdRS7nwZDZD');

define('PAGE_ID', '327850837269511');


$welcome_text = "Chào mừng bạn đến với trang của tui!\nBạn tìm tui có gì hông? :3";

/* END GLOBAL */

/* BASIC */
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'r8P>0(GxC\pzm8VAoj9g4YNBjh_NIh@dGGqjxABT8+6i>(bX#yn5Bt[r5wc7Gvax') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

// Get Guest Common Info
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
/* END BASIC */

/* MAIN */
// Ghi logs
	_log('messages',$sender." - ".$message);

// Init Facebook Bot...
// subscribe();

welcome();

/* END MAIN */

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
	_log('trace',$data);
	return $data;
}

// For Reply function
function _sendRequest($url, $data = '')
{
	global $input;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	if(!empty($input['entry'][0]['messaging'][0]['message'])){
		$data = curl_exec($ch);
	}
	curl_close($ch);
	_log('trace',$data);
	return $data;
}

function reply($mes)
{
	global $sender;
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.PAGE_ACCESS_TOKEN;

	//The JSON data.
	$jsonData = '{
	    "recipient":{
	        "id":"'.$sender.'"
	    }, 
	    "message":{
	        "text":"'.$mes.'"
	    }
	}';

	_sendRequest($url, $jsonData);
}


function welcome(){
	global $welcome_text;

	$url = "https://graph.facebook.com/v2.6/".PAGE_ID."/thread_settings?access_token=".PAGE_ACCESS_TOKEN;

	$jsonData = '{
	  "setting_type":"call_to_actions",
	  "thread_state":"new_thread",
	  "call_to_actions":[
	    {
	      "message":{
	        "text":"'.$welcome_text.'"
	      }
	    }
	  ]
	}';

	echo sendRequest($url, $jsonData);
}

/*
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
	file_put_contents($filename, date("d/M/y h:m:s")." - ".$data."\n", FILE_APPEND);
}


echo "\nWorking!";
?>