<?php

// URL API LINE
// $API_URL = 'https://api.line.me/v2/bot/message';
// ใส่ Channel access token (long-lived)
$accessToken = 'BCOvf1t/i6Yw4Tuh5YL1ee0i9B5i63x57X62O4Bk3ZIO0SoW6Sp5pUGl7wZOypqYv7iywr1OGuf8z5tYmKzwBwoMz4UdwT/DMO1vxa2+mVqdGlFdoDkpnAqeRw8mTGNyy3PIbn3eH5+jIW4dinIFkgdB04t89/1O/w1cDnyilFU=';
// ใส่ Channel Secret
// $CHANNEL_SECRET = 'ad758cdb84873efe137e6d24b5712732';

$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";

//รับข้อความจากผู้ใช้
$message = $arrayJson['events'][0]['message']['text'];

if($message == "สวัสดี"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
    replyMsg($arrayHeader,$arrayPostData);
}
#ตัวอย่าง Message Type "Sticker"
else if($message == "ฝันดี"){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "sticker";
    $arrayPostData['messages'][0]['packageId'] = "2";
    $arrayPostData['messages'][0]['stickerId'] = "46";
    replyMsg($arrayHeader,$arrayPostData);
}