<?php
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

foreach ($json_object->events as $event) {
    if('message' == $event->type){
        file_put_contents("message.json", json_encode($event));
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

        api_post_request($event->replyToken, $text);
    }else if('beacon' == $event->type){
        file_put_contents("beacon.json", json_encode($event));
        api_post_request($event->replyToken, '[出社]おはよう(ビーコン接近)');
    }
}


function api_post_request($token, $message) {
    $url = 'https://api.line.me/v2/bot/message/reply';
    $channel_access_token = 'hYdyTTEekncXevDUTHxckKjdwUNnPIejxpRdpmhLNZ5GuGpCh/APpvFUi3816bHp8c9e7+qd62JzZb+1OZYjucMwKBLqcCmMD6EsL5ST5MwXB/OULBIser2Hy6OUH5x+Q3YobyyjY1I0i2WaHP8ffQdB04t89/1O/w1cDnyilFU=';
    $headers = array(
        'Content-Type: application/json',
        "Authorization: Bearer {$channel_access_token}"
    );
    $post = array(
        'replyToken' => $token,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $message
            )
        )
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);
}