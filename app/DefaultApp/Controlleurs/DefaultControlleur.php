<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 29/03/2018
 * Time: 22:30
 */

namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\DefaultApp;
use app\DefaultApp\Models\TestModel;
use systeme\Controlleur\Controlleur;

class DefaultControlleur extends Controlleur
{
    public function index()
    {
        $variable['titre'] = "Acceuil";
        return $this->render("default/index", $variable);
    }


    public function send()
    {
       /* header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");*/


        $keyfile=dirname(__FILE__)."/AuthKey_G35QFH6LW7.p8";  // Your p8 Key file
        $keyid = 'G35QFH6LW7';                            // Your Key ID
        $teamid = 'S8BF837QRX';                           // Your Team ID (see Developer Portal)
        $bundleid = 'net.solutionip.Alerte509';                // Your Bundle ID
        $url = 'https://api.development.push.apple.com';  // development url, or use http://api.push.apple.com for production environment
        $token = '63b5edf77efacb50d4dbdde6c9c4a16c484a03a01ae4e1185a6021a5db20424c';              // Device Token


        $body['aps'] = array('category'=>'debitOverdraftNotification','alert' =>array('title'=>'Alerte509','body'=>"test",'image'=>'http://app.gpetech.net/public/img/apple-icon.png'),'sound' => 'default');
        $message = json_encode($body);

        //$message = '{"aps":{"alert":"Hi there!","sound":"default"}}';
        $key = openssl_pkey_get_private('file://' . $keyfile);

        $header = ['alg' => 'ES256', 'kid' => $keyid];
        $claims = ['iss' => $teamid, 'iat' => time()];

        $header_encoded =DefaultApp::base64($header);
        $claims_encoded = DefaultApp::base64($claims);

        $signature = '';
        openssl_sign($header_encoded . '.' . $claims_encoded, $signature, $key, 'sha256');
        $jwt = $header_encoded . '.' . $claims_encoded . '.' . base64_encode($signature);

        // only needed for PHP prior to 5.5.24
        if (!defined('CURL_HTTP_VERSION_2_0')) {
            define('CURL_HTTP_VERSION_2_0', 3);
        }

        $http2ch = curl_init();
        curl_setopt($http2ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($http2ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($http2ch, array(
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_URL => "$url/3/device/$token",
            CURLOPT_PORT => 443,
            CURLOPT_HTTPHEADER => array(
                "apns-topic: {$bundleid}",
                "authorization: bearer $jwt"
            ),
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $message,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HEADER => 1,
        ));

        $result = curl_exec($http2ch);
        if ($result === FALSE) {
            throw new \Exception("Curl failed: " . curl_error($http2ch));
        }

        $status = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);

        echo $status;
    }

}