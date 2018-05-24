<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use App;
use App\User;
use App\Location;


class IndividaulController extends Controller
{
     public function __construct(Request $request) {
        app()->setLocale($request->header('locale'));
        $this->locale = App::getLocale();
        $this->valid = User::where('access_token',$request->header('accesstoken'))->first();
    }
    public function updateLoctionIndividual(Request $request) {
        $location=json_decode(json_encode($request->all()));
        $validation = array(
            'location' =>'required|array'
        );
         $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()){
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            if(!empty($this->valid)){
                $user_id = $this->valid->id;
            } else {
                if ($this->locale=="ar") {
                    $response['message'] = trans('armessage.invalid_accessToken');
                    return Response::json($response,400);
                } else {
                    $response['message'] = trans('enmessage.invalid_accessToken');
                    return Response::json($response,400);
                }
            }
            for ($i=0; $i < count($location->location) ; $i++) { 
                $userLocation = new Location;
                $userLocation->latitude = $location->location[$i]->latitude;
                $userLocation->longitude = $location->location[$i]->longitude;
                $userLocation->description = $location->location[$i]->description;
                $userLocation->user_id = $this->valid->id;
                $userLocation->save();
            }
            if($userLocation) {
                $getuserLocation = Location::where('user_id',$this->valid->id)->get();
                if ($this->locale=="ar") {
                    $response['message'] = trans('armessage.update_loaction');
                    $response['Response'] = $getuserLocation;

                    return Response::json($response,200);
                } else {
                    $response['message'] = trans('enmessage.update_loaction');
                    $response['Response'] = $getuserLocation;

                    return Response::json($response,400);
                }
            } else {
                if ($this->locale=="ar") {
                    $response['message'] = trans('armessage.wrong');
                    return Response::json($response,400);
                } else {
                    $response['message'] = trans('enmessage.wrong');
                    return Response::json($response,400);
                }  
            }
        }
    }
}
