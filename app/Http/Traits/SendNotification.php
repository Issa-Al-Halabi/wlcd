<?php

namespace App\Http\Traits;

trait SendNotification
{

    public function send_notification($device_token, $title, $body)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $SERVER_API_KEY = 'AAAA5V8ucPA:APA91bExq4dR3etNNGakbSX4OWplIF0czdxFFwmCk16FeoAxvtLkVAId2lF-BHU_wqBeZMJXV0fpER7Q964i1MW3KHUawkcO1GFKHl0xT0YTxwZ9voTNGDHp-AhbykYAkChwfmsDiDQE';
        $data = [
            'to' => $device_token, //$FcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ]
        ];
        $headers = [
            'Authorization:key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $encodedData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
