<?php

// URL API LINE
$API_URL = 'https://api.line.me/v2/bot/message';
// ใส่ Channel access token (long-lived)
$ACCESS_TOKEN = 'BCOvf1t/i6Yw4Tuh5YL1ee0i9B5i63x57X62O4Bk3ZIO0SoW6Sp5pUGl7wZOypqYv7iywr1OGuf8z5tYmKzwBwoMz4UdwT/DMO1vxa2+mVqdGlFdoDkpnAqeRw8mTGNyy3PIbn3eH5+jIW4dinIFkgdB04t89/1O/w1cDnyilFU=';
// ใส่ Channel Secret
$CHANNEL_SECRET = 'ad758cdb84873efe137e6d24b5712732';

// Set HEADER
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
// Get request content
$request = file_get_contents('php://input');
// Decode JSON to Array
$request_array = json_decode($request, true);

function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

if ( sizeof($request_array['events'])) {

   // Loop through each event
   foreach ($request_array['events'] as $event) {

    // Line API send a lot of event type, we interested in message only.
	if ($event['type'] == 'message') {
        switch($event['message']['type']) { 
            case 'text':
                // Get replyToken
                $replyToken = $event['replyToken'];
                // Reply message
                $respMessage = ''. $event['message']['text'];

                if($event['message']['text'] == "กำหนดสอบ"){
                    $respMessage = "กำหนดสอบธรรมสนามหลวง คลิ๊ก >>
                    http://www.gongtham.net/web/news.php";

                }
	  
                $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
                $send_result = send_reply_message($API_URL.'/reply',      $POST_HEADER, $post_body);
                echo "Result: ".$send_result."\r\n";
    }
}
echo "OK";