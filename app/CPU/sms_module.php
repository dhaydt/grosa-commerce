<?php

namespace App\CPU;

use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Config;
use Nexmo\Laravel\Facade\Nexmo;
use Twilio\Rest\Client;

class SMS_module
{
    public static function send($receiver, $otp)
    {
        $config = self::get_settings('twilio_sms');
        if (isset($config) && $config['status'] == 1) {
            $response = self::twilio($receiver, $otp);

            return $response;
        }

        $config = self::get_settings('nexmo_sms');
        if (isset($config) && $config['status'] == 1) {
            $response = self::nexmo($receiver, $otp);

            return $response;
        }

        $config = self::get_settings('2factor_sms');
        if (isset($config) && $config['status'] == 1) {
            $response = self::two_factor($receiver, $otp);

            return $response;
        }

        $config = self::get_settings('msg91_sms');
        if (isset($config) && $config['status'] == 1) {
            $response = self::msg_91($receiver, $otp);

            return $response;
        }

        $config = self::get_settings('releans_sms');
        if (isset($config) && $config['status'] == 1) {
            $response = self::releans($receiver, $otp);

            return $response;
        }

        return 'not_found';
    }

    // zenziva
    public static function twilio($receiver, $otp)
    {
        $config = self::get_settings('twilio_sms');
        $response = 'error';
        if (isset($config) && $config['status'] == 1) {
            $userkey = $config['sid'];
            $passkey = $config['messaging_service_sid'];
            // $telepon = '+62'.(int) $receiver;
            $telepon = '+62'.(int) $receiver;
            $message = str_split($otp);
            $convert = [];

            $angka = ['{=kosong=}', '{=satu=}', '{=dua=}', '{=tiga=}', '{=empat=}', '{=lima=}', '{=enam=}', '{=tujuh=}', '{=delapan=}', '{=sembilan=}'];

            foreach ($message as $m => $val) {
                array_push($convert, $angka[$val]);
            }

            $n = $convert[0];
            $n1 = $convert[1];
            $n2 = $convert[2];
            $n3 = $convert[3];
            $convert = '{grosa}'.$n.$n1.$n2.$n3;
            // dd($convert);

            $url = 'https://gsm.zenziva.net/api/sendsms/';
            // dd(json_encode($message));
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $url);
            curl_setopt($curlHandle, CURLOPT_HEADER, 0);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
            curl_setopt($curlHandle, CURLOPT_POST, 1);
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, [
                'userkey' => $userkey,
                'passkey' => $passkey,
                'nohp' => $telepon,
                'pesan' => $convert,
            ]);
            $results = json_decode(curl_exec($curlHandle), true);
            curl_close($curlHandle);
        }

        return $response;
    }

    // twilio
    // public static function twilio($receiver, $otp)
    // {
    //     $config = self::get_settings('twilio_sms');
    //     $response = 'error';
    //     if (isset($config) && $config['status'] == 1) {
    //         $message = str_replace("#OTP#", $otp, $config['otp_template']);
    //         $sid = $config['sid'];
    //         $token = $config['token'];
    //         try {
    //             $twilio = new Client($sid, $token);
    //             $twilio->messages
    //                 ->create($receiver, // to
    //                     array(
    //                         "messagingServiceSid" => $config['messaging_service_sid'],
    //                         "body" => $message
    //                     )
    //                 );
    //             $response = 'success';
    //         } catch (\Exception $exception) {
    //             $response = 'error';
    //         }
    //     }
    //     return $response;
    // }

    public static function nexmo($receiver, $otp)
    {
        $sms_nexmo = self::get_settings('nexmo_sms');
        $response = 'error';
        if (isset($sms_nexmo) && $sms_nexmo['status'] == 1) {
            $message = str_replace('#OTP#', $otp, $sms_nexmo['otp_template']);
            try {
                $config = [
                    'api_key' => $sms_nexmo['api_key'],
                    'api_secret' => $sms_nexmo['api_secret'],
                    'signature_secret' => '',
                    'private_key' => '',
                    'application_id' => '',
                    'app' => ['name' => '', 'version' => ''],
                    'http_client' => '',
                ];
                Config::set('nexmo', $config);
                Nexmo::message()->send([
                    'to' => $receiver,
                    'from' => $sms_nexmo['from'],
                    'text' => $message,
                ]);
                $response = 'success';
            } catch (\Exception $exception) {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function two_factor($receiver, $otp)
    {
        $config = self::get_settings('2factor_sms');
        $response = 'error';
        if (isset($config) && $config['status'] == 1) {
            $api_key = $config['api_key'];
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://2factor.in/API/V1/'.$api_key.'/SMS/'.$receiver.'/'.$otp.'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if (!$err) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function msg_91($receiver, $otp)
    {
        $config = self::get_settings('msg91_sms');
        $response = 'error';
        if (isset($config) && $config['status'] == 1) {
            $receiver = str_replace('+', '', $receiver);
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.msg91.com/api/v5/otp?template_id='.$config['template_id'].'&mobile='.$receiver.'&authkey='.$config['authkey'].'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => "{\"OTP\":\"$otp\"}",
                CURLOPT_HTTPHEADER => [
                    'content-type: application/json',
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if (!$err) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function releans($receiver, $otp)
    {
        $config = self::get_settings('releans_sms');
        $response = 'error';
        if (isset($config) && $config['status'] == 1) {
            $curl = curl_init();
            $from = $config['from'];
            $to = $receiver;
            $message = str_replace('#OTP#', $otp, $config['otp_template']);

            try {
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://api.releans.com/v2/message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => "sender=$from&mobile=$to&content=$message",
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer '.$config['api_key'],
                    ],
                ]);
                $response = curl_exec($curl);
                curl_close($curl);
                $response = 'success';
            } catch (\Exception $exception) {
                $response = 'error';
            }
        }

        return $response;
    }

    public static function get_settings($name)
    {
        $config = null;
        $data = BusinessSetting::where(['type' => $name])->first();
        if (isset($data)) {
            $config = json_decode($data['value'], true);
            if (is_null($config)) {
                $config = $data['value'];
            }
        }

        return $config;
    }
}
