<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use App;
use App\User;

class EmployerController extends Controller
{
	var $accessToken;
	var $locale;

    public function __construct(Request $request) {
        app()->setLocale($request->header('locale'));
    	$this->locale = App::getLocale();
        $this->valid = User::where('access_token',$request->header('accesstoken'))->first();

    }

    public function employerProfile(Request $request) {
        //dd($request->all());
    	$validation = array(
            'first_name' => 'required',
            'last_name'  => 'required',
            'country'    => 'required',
            'city'       => 'required',
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()){
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {

        	if(!empty($this->valid)){
        		$user_id = $this->valid->id;
                dd($user_id);
        	} else {
        		if ($this->locale=="ar") {
                    $response['message'] = trans('armessage.invalid_accessToken');
                    return Response::json($response,400);
                } else {
                    $response['message'] = trans('enmessage.invalid_accessToken');
                    return Response::json($response,400);
                }
        	
        	}
        	if(!empty($request->image)) {
        		$image_url = time().$request->image->getClientOriginalName();
        		$destination = public_path('/employerProfile');
        		$upload = $request->image->move($destination,'/employerProfile/'.$image_url);
        	} else {
        		$image_url = null;
        	}

        	$update = User::find($user_id);
        	$update->first_name = $request->first_name;
        	$update->last_name = $request->last_name;
        	$update->country = $request->country;
        	$update->city = $request->city;
        	$update->image ='employerProfile/'.$image_url;

        	$update->save();
        	if (!empty($update->id)) { 
                    $getUser = User::where('id',$user_id)->first();

        		if ($this->locale=="ar") {
                    $response['message'] = trans('armessage.upadte_profile');
                    $response['Response'] = $getUser;

                    return Response::json($response,200);
                } else {
                    $response['message'] = trans('enmessage.upadte_profile');
                    $response['Response'] = $getUser;

                    return Response::json($response,200);
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
    public function updateEmpLocation(Request $request) {
        $validation = array(
            'latitude'    => 'required',
            'longitude' => 'required'
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
            $update = User::find($user_id);
            $update->latitude = $request->latitude;
            $update->longitude = $request->longitude;
            $update->save();

            if (!empty($update->id)) { 
                if ($this->locale=="ar") {
                    $response['message'] = trans('armessage.update_loaction');
                    return Response::json($response,200);
                } else {
                    $response['message'] = trans('enmessage.update_loaction');
                    return Response::json($response,200);
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
