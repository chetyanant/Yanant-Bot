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

if (!is_null($request_array['events'])) {

	// Loop through each event
	foreach ($request_array['events'] as $request_array) {
    
        // Line API send a lot of event type, we interested in message only.
		if ($request_array['type'] == 'message') {

            switch($request_array['message']['type']) {
                
                case 'text':
                    // Get replyToken
                    $replyToken = $request_array['replyToken'];
   
                    // Reply message
                    $respMessage = ''. $request_array['message']['text'];
                    /*
                    $userText = ''. $event['message']['text'];
                    switch($userText){
                        case 'กำหนดสอบ':
                            $respMessage = 'กำหนดสอบธรรมสนามหลวง คลิ๊ก >>
                            http://www.gongtham.net/web/news.php';
                        break;

                        case 'ใบคำร้อง':
                            $respMessage = 'ดาวน์โหลดใบคำร้อง คลิ๊ก >>
                            http://www.gongtham.net/web/downloads.php?cat_id=5&download_id=80';
                        break;

                    }
                    */
                    if($request_array['message']['text'] == "กำหนดสอบ"){
                        $respMessage = "กำหนดสอบธรรมสนามหลวง คลิ๊ก >>
                        http://www.gongtham.net/web/news.php";

                    }elseif($request_array['message']['text'] == "ขอใบประกาศ"){
                        $respMessage = "ดาวน์โหลดใบคำร้อง คลิ๊ก >>
                        http://www.gongtham.net/web/downloads.php?cat_id=5&download_id=80";

                    }elseif($request_array['message']['text'] == ""){
                        $respMessage = ''. $request_array['message']['text'];
                    }else{
                        $respMessage = 'ติดต่อเจ้าหน้าที่ โทร. ...';
                    }
                                
                    $httpClient = new CurlHTTPClient($channel_token);
                    $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
        
                    $textMessageBuilder = new TextMessageBuilder($respMessage);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
                    
                    break;
            }
		}
	}
}

echo "Hello LINEBot";