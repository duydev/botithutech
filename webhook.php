<?php

/*******************************
/* Trần Nhật Duy
/* duy@ithu.tech
/* 24/04/2016
/* Facebook Messenger Bot 
/*******************************

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

$guest = getGuestInfo();
/* END BASIC */

/* MAIN */
// Init Facebook Bot...
// subscribe();

// Init Welcome Message
//welcome();

// Ghi logs message
	_log('message',$sender." - ".$message);


autoReply();

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

function getGuestInfo($uid)
{
	global $sender;
	$url = "https://graph.facebook.com/v2.6/".$sender."?fields=first_name,last_name,profile_pic&access_token=".PAGE_ACCESS_TOKEN;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$data = curl_exec($ch);
	curl_close($ch);
	_log('trace',$data);
	$jsonData = json_decode($data, true);
	$info = array(
			'hoten' => $jsonData['last_name'].' '.$jsonData['first_name'],
			'avatar' => $jsonData['profile_pic']
		);
	return $info;
}

function getAnswer()
{
	global $message, $guest;
	if(preg_match('/(.*?)chào(.*?)/i', $message))
	{
		return "Xin chào bạn ".$guest['hoten'];
	}
	if(preg_match('/(.*?)tên gì(.*?)/i', $message))
	{
		return "Tên tui là Duy Bot. :D";
	}
	if(preg_match('/(.*?)mấy giờ rồi(.*?)/i', $message))
	{
		return "Bây giờ là ".date('h:m:s');
	}
	if(preg_match('/(.*?)(tôi|tui) là ai(.*?)/i', $message))
	{
		return "Bạn là ".guest['hoten']." chứ ai. :))";
	}
	if(preg_match('/(.*?)khùng(.*?)/i', $message))
	{
		return "Thì tui có nói tui bình thường đâu... :v";
	}
	if(preg_match('/(.*?)bao nhiêu tuổi(.*?)/i', $message))
	{
		return "Tui được ".(intval(date('Y')) - 1995)." cái xuân sanh rồi.";
	}
	return "Ờ...";
}

function autoReply()
{
	//reply(getAnswer());
	reply(chatSimsimi());
}

function _log($type, $data)
{
	$filename = $type."s.txt";
	file_put_contents($filename, date("d/M/y h:m:s")." - ".$data."\n", FILE_APPEND);
}

function chatSimsimi()
{
	global $message;
	$key = 'cd91050a-b416-4d63-a71d-f748345de1ee';
	$lang = 'vn';
	$rand = random_0_1();
	$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc='.$lang.'&ft='.$rand.'&text='.$message;

	$data = file_get_contents($url);
	$json = json_decode($data,true);
	if($json['result'] !== 100)
		return "Lỗi Simsimi API.";
	return $json['response'];
}


function random_0_1()
{   // auxiliary function
    // returns random number with flat distribution from 0 to 1
    return (float)rand()/(float)getrandmax();
}

echo "\nWorking!";
?>