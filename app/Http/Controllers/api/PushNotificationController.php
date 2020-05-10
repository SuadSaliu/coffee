<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
    public function send_notification_android($device_id, $android_ids, $message, $title) {
        $result = array();
        $payload = array();
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAA3KgUuXA:APA91bEfEs8UHGIzxVPPAxnNAAwaOIfHw82LTJ2PzNjh4P-kDJGUx5KAtqHmcNixyslW087G3dWfNVwMrfmvj9tHKmEoC5OB3NW6CZT_H4oGFv_QvTZWN9aEr2IfZ3QOixfTaF0VTac9';
        $result['title'] = $title;
        $result['body'] = $message;
        $fields = array(
            'to' => $android_ids,
            'data' => $result
        );
        $headers = array(
            'Authorization: key=' . $api_key,
            'Authorization: key=' . $api_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return (!empty($result)) ? false: true;
    }

    // IOS
    public function send_push_notification($deviceToken, $badges, $msg, $data) {
        $key = public_path() . '/pushcert12.pem';
        $url = "ssl://gateway.push.apple.com:2195";

        // $url = 'ssl://gateway.sandbox.push.apple.com:2195'; // for development

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $key);
        stream_context_set_option($ctx, 'ssl', 'passphrase', 'ThreatAlert');
        $fp = stream_socket_client($url, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        $message = $msg;
        $body['aps'] = array(
            'alert' => $message,
            'badge' => intval($badges) ,
            'sound' => 'default',
            'data' => ''
        );
        $payload = json_encode($body);
        $deviceToken = str_replace(' ', '', $deviceToken);
        
        try
            {
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload . chr(3) . pack('n', 4) . pack('N', $deviceToken) . chr(4) . pack('n', 4) . pack('N', time() + 86400) . chr(5) . pack('n', 1) . chr(10);
            $result = fwrite($fp, $msg, strlen($msg));
            $res = !$result ? 0 : 1;

            $retmsg = $res;
        }
        catch(Exception $eee)
        {
            $this->log('Message Push - ' . $eee);
        }

        fclose($fp);
        $retmsg = '<br />' . date("Y-m-d H:i:s") . ' Connection closed to APNS' . PHP_EOL;
    }

}