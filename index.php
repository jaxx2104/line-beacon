<?php
require("vendor/autoload.php");

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;

// 設定
$token = file_get_contents("token.txt");

// インスタンス
$httpClient = new CurlHTTPClient($token);
$bot = new LINEBot($httpClient, ['channelSecret' => $token]);

// webhook
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);

// 不正なリクエスト
if (empty($jsonObj)) {
    var_dump("request to line-beacon");
    return;
}

// リクエスト処理
foreach ($jsonObj->events as $event) {
    if('message' == $event->type){
        // debug
        //file_put_contents("message.json", json_encode($event));
        $text = $event->message->text;

        if (preg_match("/休み/", $text)) {
            $text = "[欠勤]どうぞお大事に";
        }

        if (preg_match("/予定/", $text)) {
            $text = "[予定]11時から会議だよ";
        }

        if (preg_match("/帰/", $text)) {
            $text = "[退社]お疲れ様!!";
        }
        $response = $bot->replyText($event->replyToken, $text);

    } else if('beacon' == $event->type) {
        // debug
        file_put_contents("beacon.json", json_encode($event));
        $text = '[出社]おはよう(ビーコン接近)';
        $response = $bot->replyText($event->replyToken, $text);

    }
}
