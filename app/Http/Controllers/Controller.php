<?php

namespace App\Http\Controllers;
use Twilio\Rest\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

      public function twilio(){
     $AccountSid = "ACa7abe2bcdb7f222b008efb5b13e08b57";
        $AuthToken = "8f5d34721b80225dd1a285f2362d119c";
        $client = new Client($AccountSid, $AuthToken);
         $otp = rand(1000,10000);
        try{
            $sms = $client->account->messages->create(
               "+918826459472",
                array(
                    'from' => "+1305-842-2293", 
                    'body' => 'please enter this code to verify :'.$otp
                )
            );
        } catch(\Exception $e) {
         dd($e);
            return 0;
        }
        dd("vkljvgklcfl");
        return $otp;
    }
}
