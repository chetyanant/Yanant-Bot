<?php
require_once('./nextflow-reserve/vendor/autoload.php');

// Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

// ใส่ Channel access token (long-lived)
$ACCESS_TOKEN = 'BCOvf1t/i6Yw4Tuh5YL1ee0i9B5i63x57X62O4Bk3ZIO0SoW6Sp5pUGl7wZOypqYv7iywr1OGuf8z5tYmKzwBwoMz4UdwT/DMO1vxa2+mVqdGlFdoDkpnAqeRw8mTGNyy3PIbn3eH5+jIW4dinIFkgdB04t89/1O/w1cDnyilFU=';
// ใส่ Channel Secret
$CHANNEL_SECRET = 'ad758cdb84873efe137e6d24b5712732';

// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	// Loop through each event
	foreach ($events['events'] as $event) {
    
        // Line API send a lot of event type, we interested in message only.
		if ($event['type'] == 'message') {

            switch($event['message']['type']) {
                
                case 'text':
                    // Get replyToken
                    $replyToken = $event['replyToken'];
   
                    // Reply message
                    $respMessage = ''. $event['message']['text'];
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
                    if($event['message']['text'] == "กำหนดสอบ"){
                        $respMessage = "กำหนดสอบธรรมสนามหลวง คลิ๊ก >>
                        http://www.gongtham.net/web/news.php";

                    }elseif($event['message']['text'] == "ขอใบประกาศ"){
                        $respMessage = "ดาวน์โหลดใบคำร้อง คลิ๊ก >>
                        http://www.gongtham.net/web/downloads.php?cat_id=5&download_id=80";

                    }elseif($event['message']['text'] == ""){
                        $respMessage = ''. $event['message']['text'];
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