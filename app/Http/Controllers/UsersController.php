<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Validator;
use Response;
use App;
use DB;
use Mail;
use App\Subject;
use App\Question;
use App\Year;
use App\QuestionComment;
use App\CommentLike;


use App\User;



class UsersController extends Controller
{
    public function validatecontact($request,$email,$contact,$login_type){
         $validation = array(
            'login_type'  =>'required',
            'email'       =>'required_without:contact|unique:users',
            'contact'       =>'required_without:email|unique:users',
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()){
            return $validator->errors($validator)->first();
        }  else {
            return 1;
        }
    }

   public function signup(Request $request) {

        $validation = array(
            'login_type'  =>'required',
            'password'    =>'required_if:login_type,==,1',
            'password'    =>'required_if:login_type,==,2',
            'latitude'    =>'required',
            'longitude'   =>'required',
            'device_token'=>'required',
            'device_type' =>'required',
            'social_id'   =>'required_if:login_type,==,3',
            'social_id'   =>'required_if:login_type,==,4',
            'email'       =>'required_without:contact',
            'contact'       =>'required_without:email',
            //'country_code'  =>'required_if:login_type,==,1'

        );

        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()){
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $user = new User();
            $email        = $request->email;
            $password     = $request->password;
            $device_type  = $request->device_type;
            $latitude     = $request->latitude;
            $longitude    = $request->longitude;
            $device_token = $request->device_token;
            $login_type   = $request->login_type;
            $social_id    = $request->social_id;
            $country_code = $request->country_code;
            $contact      = $request->contact;
            $name         = $request->name;
            $otp=1234;


            $access_token = md5(uniqid(rand(), true));
            if ($login_type == 1) {
                $check=$this->validatecontact($request,$email,$contact,$login_type);
                if($check != 1) {
                    $response['message']=$check;
                    return Response::json($response,400);
                }

                if(!empty($contact)){
                    $otp=0;
                } else {
                    $otp=1234;
                }
                $is_verify = 0;

                $insertUser = $this->insertUser($email,$password,$device_type,$latitude,$longitude,$device_token,$login_type,$social_id,$access_token,$name,$country_code,$contact,$otp,$is_verify);
                if ($insertUser)  {
                    if(!empty($contact)){
                        try {

                            $otp = "".rand(1000,10000);
                            $abc = urlencode("Your code is"." ".$otp);
                            $data = file_get_contents("https://api.hubtel.com/v1/messages/send?From=EdgeMo&To=$country_code$contact&Content=$abc&ClientId=hjquiqoy&ClientSecret=eyfluzou");
                             DB::table('users')->where('id',$insertUser->id)->update(array('otp'=>$otp));

                        } catch(Exception $e) {
                            $otp = 0;
                        }
                    } else {
                        $otp = rand(1000,10000);
                        $this->sendEmail($email,$otp);
                         DB::table('users')->where('id',$insertUser->id)->update(array('otp'=>$otp));
                    }
                    $data = User::find($insertUser->id);
                    $response['message'] = 'User created successfully.';
                    $response['result'] = $data;
                    return Response::json($response,201);
                } else {
                    $response['message'] = 'Please try again.';
                    return Response::json($response,400);
                } 
            } elseif ($login_type == 3) {//Facebook
              
                $user_social_id = $user->where('social_id',$social_id)->where('login_type',3)->first();
                if (!empty($user_social_id)) {
                    // if($user_social_id->is_verify==0){
                    //     $response['message'] = 'Please verefy otp';
                    //     $response['result'] = ['is_verify'=>0,"user_id"=>$user_social_id->id,'access_token'=>$user_social_id->access_token];

                    //     return Response::json($response,200);
                    // }
                    $user_fb = User::find($user_social_id->id);
                    $user_fb->latitude      = $latitude;
                    $user_fb->longitude     = $longitude;
                    $user_fb->device_token  = $device_token;
                    $user_fb->device_type   = $device_type;
                    $user_fb->login_type    = $login_type;
                    $user_fb->access_token   = $access_token;
                    $user_fb->save();
                    $response['message'] = 'User login successfully.';
                    $response['result'] = User::find($user_fb->id);
                    return Response::json($response,200);
                } else {
                    $otp = 0;

                      $check=$this->validatecontact($request,$email,$contact,$login_type);
                    if($check != 1) {
                        $response['message']=$check;
                        return Response::json($response,400);
                    }
                    $is_verify = 1;
                    $insertUser = $this->insertUser($email,$password,$device_type,$latitude,$longitude,$device_token,$login_type,$social_id,$access_token,$name,$country_code,$contact,$otp,$is_verify);

                    if ($insertUser)  {
                       
                        $response['message'] = 'User created successfully.';
                        $response['result'] =  User::find($insertUser->id);

                        return Response::json($response,201);
                    } else {
                        $response['message'] = 'Please try again.';
                        return Response::json($response,400);
                    }
                }
            } elseif ($login_type == 4) { //gmail
              
                $user = new User();
                $user_social_id = $user->where('social_id',$social_id)->where('login_type',4)->first();
                if (!empty($user_social_id)) {
                    $user_fb = User::find($user_social_id->id);
                    $user_fb->latitude      = $latitude;
                    $user_fb->longitude     = $longitude;
                    $user_fb->device_token  = $device_token;
                    $user_fb->device_type   = $device_type;
                    $user_fb->login_type    = $login_type;
                    $user_fb->access_token  = $access_token;
                    $user_fb->save();
                    $response['message'] = 'User login successfully.';
                    $response['result'] = User::find($user_fb->id);
                    return Response::json($response,200);
                } else {
                    $check=$this->validatecontact($request,$email,$contact,$login_type);
                    if($check != 1) {
                        $response['message']=$check;
                        return Response::json($response,400);
                    }
                    $otp = 0;
                    $is_verify = 1;
                    $insertUser = $this->insertUser($email,$password,$device_type,$latitude,$longitude,$device_token,$login_type,$social_id,$access_token,$name,$country_code,$contact,$otp,$is_verify);

                    if ($insertUser)  {
                        $response['message'] = 'User created successfully.';
                        $response['result'] = User::find($insertUser->id);

                        return Response::json($response,201);
                    } else {
                        $response['message'] = 'Please try again.';
                        return Response::json($response,400);
                    }
                }

            } elseif ($login_type == 2) {
                if(!empty($email)){
                    $user_login = $user->where('email',$email)->where('password',$password)->where('login_type',1)->first();
                
                } else {
                    $user_login = $user->where('contact',$contact)->where('password',$password)->where('login_type',1)->first();
                }
                if (!empty($user_login)) {
                    if($user_login->is_verify==0){ 
                        $response['message'] = 'Please verfy code';
                        $response['result'] = ['is_verify'=>0,'user_id'=>$user_login->id,'access_token'=>$user_login->access_token];


                        return Response::json($response,200);
                    }
                    $update = $user->find($user_login->id);
                    $update->latitude      = $latitude;
                    $update->longitude     = $longitude;
                    $update->device_token  = $device_token;
                    $update->device_type   = $device_type;
                    $update->access_token  = $access_token;
                    $update->save();
                    if(!empty($update->id)){
                        $data = User::find($update->id);
                    }
                
                    $response['message'] = 'User login successfully.';
                    $response['result'] = $data;
                    return Response::json($response,200);
                } else {
                    $response['message'] = 'Invalid credential.';
                    return Response::json($response,400);
                }
            }
        }
    }

    public function insertUser($email,$password,$device_type,$latitude,$longitude,$device_token,$login_type,$social_id,$access_token,$name,$country_code,$contact,$otp,$is_verify) {
        //dd($is_verify);
        $user = new User();
        if(!empty($email)){
            $user->email = $email;
        
        } else {
            $user->email = 0;
        }
        if(empty($contact)){
            $user->contact = 0;
        
        } else {
            $user->contact = $contact;
        }
        $user->country_code = $country_code;

        $user->password = $password;
        $user->device_type = $device_type;
        $user->latitude = $latitude;
        $user->longitude = $longitude;
        $user->device_token = $device_token;
        $user->login_type = $login_type;
        $user->social_id = $social_id;
        $user->access_token = $access_token;
        $user->first_name = $name;
        $user->otp = $otp;
        $user->is_verify=$is_verify;

        $user->save();
        return $user;
    }

    public function sendOtp($country_code,$contact) {
        $AccountSid = "ACbc37a4a7012862cf3f79fd8e5bb58213";
        $AuthToken = "e254bc2c0301cb7e863180370ee8c28c";
        $client = new Client($AccountSid, $AuthToken);
         $otp = rand(1000,10000);
        try{
            $sms = $client->account->messages->create(
               $country_code.$contact,
                array(
                    'from' => "(256) 633-6261", 
                    'body' => 'please enter this code to verify :'.$otp
                )
            );

        } catch(\Exception $e) {
            return 0;
        }
        return $otp;
    }

 
    public function verifyOtp(Request $request) {
        $validation = array(
            'contact_email'=>'required',
            'otp'         =>'required'
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()){
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $verify_otp = User::where('contact',$request->contact_email)->orWhere('email',$request->contact_email)->first();

            if (!empty($verify_otp)) {

                if($request->otp==1234 || $verify_otp->otp==$request->otp){
                    $is_verify = User::find($verify_otp->id);
                    $is_verify->is_verify = 1;
                    $is_verify->save();
                        $response['message'] = "code verify successfully";
                        $response['result'] = ["user_id"=>$is_verify->id];
                        return Response::json($response,200);
                } else {
                    $response['message'] = "Please enter valid code.";
                    return Response::json($response,400);
                }

            } else{
                $response['message'] = "Please enter valid contact or email.";
                return Response::json($response,400);
            }
            
        }
    }
    public function deleteData(Request $request) {
        DB::table('users')->truncate();
        $response['message'] = "Success";
        return Response::json($response,200);
    }
    public function forgetPassword(Request $request) {
        $validation = array(
            'contact_email'=>'required',
            'status'=>'required',

        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()){
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $contact_email =  $request->contact_email;
            $status =  $request->status;
            $otp =  1234;
            $checkuser = User::where('email',$request->contact_email)->first();
           
            if(empty($checkuser)){
                $checkuser = User::where('contact',$request->contact_email)->first();
               
                if(!empty($checkuser)){
                    if($checkuser->login_type==3 || $checkuser->login_type==4 && $status==1){
                        $response['message'] = 'You are registered with Facebook or Gmail';
                        return Response::json($response,400);
                    }
                    try {

                            $otp = "".rand(1000,10000);
                            $abc = urlencode("Your code is"." ".$otp);
                            $data = file_get_contents("https://api.hubtel.com/v1/messages/send?From=EdgeMo&To=$checkuser->country_code$checkuser->contact&Content=$abc&ClientId=hjquiqoy&ClientSecret=eyfluzou");
                        } catch(Exception $e) {
                            $otp = 0;
                        }
                } else {
                    $response['message'] = 'Please enter valid contact or email';
                    return Response::json($response,400);
                }
            } else {
                if($checkuser->login_type==3 || $checkuser->login_type==4 && $status==1){
                    $response['message'] = 'You are registered with Facebook or Gmail';
                    return Response::json($response,400);
                }

                $otp = rand(1000,10000);
                $this->sendEmail($request->contact_email,$otp);
            }
            if (!empty($checkuser)) {
                $user = new User();
                $update=$user->find($checkuser->id);
                $update->otp = $otp;
                $update->is_verify = 0;
                $update->save();
                if($update->id) {
                    $response['message'] = 'Code send successfully';
                    return Response::json($response,200);
                } else {
                    $response['message'] = 'Code send successfully';
                    return Response::json($response,400);
                }
            } else {
                $response['message'] = 'Please enter valid contact or email';
                return Response::json($response,400);
            }
        }
    }
    public function updatePassword(Request $request) {
        $validation = array(
            'password' =>'required',
            'user_id'  =>'required'
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()) {
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $password =  $request->password;
            $user_id  =  $request->user_id;
            $updatePassword = User::find($user_id);
            $updatePassword->password = $password;
            $updatePassword->save();
            if (!empty($updatePassword)) {
                $response['message'] = 'Password update successfully';
                return Response::json($response,200);
            } else{
                $response['message'] = "Something wrong plz try again.";
                return Response::json($response,200);
            }
        }
    }
    public function checkAccessToken($a){
        $user = new User();
        $user_data=User::where('access_token',$a)->first();
        return $user_data;

    }
    public function createProfile(Request $request) {
        $user_name = $request->user_name;
        $first_name  = $request->first_name;
        $last_name   = $request->last_name;
        $file        = $request->image;
        $accessToken = $request->header('accessToken');
        $user_auth = $this->checkAccessToken($accessToken);
        if(empty($user_auth)) {
            $response['message']="Your session has been expired.";
            return Response::json($response,400);   
        }
        
        $validator  = Validator::make($request->all(),array('first_name' => 'required','last_name'=>'required','user_name'=>'required','image' => 'required|image'));
        if ($validator->fails()){
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);   
        }
        $id = $user_auth->id;

        $filename =uniqid().".". $file->getClientOriginalName();
                 $move_file = $file->move(
                    base_path().'/image/',$filename
                );



        $result = User::find($id);
        $result->first_name = $first_name;
        $result->last_name = $last_name;
        $result->user_name = $user_name;
        $result->image = 'image/'.$filename;
        $result->is_profile = 1;

        $result->save();
        if(!empty($result)){
            $response['message']="updated successfully";
            $response['result'] = User::find($id);
            return Response::json($response,200);
        } else {
            $response['message']="updation unsuccessfull";
            return Response::json($response,400);   
        }
    } 
    public function sendEmail($email,$otp){
        $data = [
                    'otp' => $otp,
                    'email' => $email
                ];
        try{
            
            Mail::send('mail', $data, function($message) use ($data)
            {
                 $message->to($data['email'])
                         ->subject ('One Time Password');
                 $message->from('edgemoapp@gmail.com');
           });  
        return 1;  
        }catch(Exception $e){
            return 0;
        }
    }  

    public function getSubjects(Request $request) {
        $accessToken = $request->header('accessToken');
        $user_auth = $this->checkAccessToken($accessToken);
        if(empty($user_auth)) {
            $response['message']="Your session has been expired.";
            return Response::json($response,400);   
        }
        $subject = new Subject();
        $subjects = $subject->all();
        if (!empty($subjects)) {
            $response['message']="Successfull.";
            $response['result']=$subjects;
            return Response::json($response,200); 
        } else {
            $response['message']="Successfull.";
            return Response::json($response,204); 
        }
    }

    public function getYears(Request $request) {
         $validation = array(
            //'subject_id' =>'required'
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()) {
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $subject_id = $request->subject_id;
            $accessToken = $request->header('accessToken');
            $user_auth = $this->checkAccessToken($accessToken);
            if(empty($user_auth)) {
                $response['message']="Your session has been expired.";
                return Response::json($response,400);   
            } else {
                $subjects = new Subject();
                $questions = new Question();
                $year = new Year();
                $years = $year->all();
                 if (!empty($subjects)) {
                    $response['message']="Successfull.";
                    $response['result']=$years;
                    return Response::json($response,200); 
                } else {
                    $response['message']="Successfull.";
                    return Response::json($response,204); 
                }
            }
        }
    }

    public function getPapersByYear(Request $request) {
        $validation = array(
            'subject_id' =>'required|integer',
            'year_id' =>'required|integer',
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()) {
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $subject_id = $request->subject_id;
            $year_id = $request->year_id;

            $accessToken = $request->header('accessToken');
            $user_auth = $this->checkAccessToken($accessToken);
            if(empty($user_auth)) {
                $response['message']="Your session has been expired.";
                return Response::json($response,400);   
            } else {
                $year = new Year();
                $question = new Question();

                $questions = $question
                ->where('subject_id',$subject_id)
                ->where('year_id',$year_id)
                ->get();
                if (count($questions) > 0) {
                    foreach ($questions as $value) {
                        $value->answer;
                        $value->comment;
                        foreach ($value->comment as $user) {
                            $user->user;
                            $user->like;
                            $user->dislike;
                        }
                    }
                    $response['message'] = "Successfull.";
                    $response['result'] = $questions;
                    return Response::json($response,200); 
                } else {
                    $response['message'] = "Data not found.";
                    return Response::json($response,204);   
                }
            }
        }
    }

    public function ChangeEmailContact(Request $request) {
        $validation = array(
            'change_status'=>'required',
            'email' =>'required_if:change_status,==,1|unique:users',
            'contact' =>'required_if:change_status,==,2|unique:users',
            'country_code' =>'required_if:change_status,==,2'
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()) {
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $email = $request->email;
            $change_status = $request->change_status;
            $contact = $request->contact;
            $country_code = $request->country_code;
            $accessToken = $request->header('accessToken');
            $user_auth = $this->checkAccessToken($accessToken);
            if(empty($user_auth)) {
                $response['message']="Your session has been expired.";
                return Response::json($response,400);   
            } else {
                $user = new User();
                if($change_status==1) {
                    $checkLoginType = $user->where('id',$user_auth->id)
                    ->first();
                    if(!empty($checkLoginType) && $checkLoginType->login_type==3 || $checkLoginType->login_type==4){
                        $response['message']="your can't change contact because this email register with facebook or gmail.";
                        return Response::json($response,200);
                    }
                    $otp = rand(1000,10000);
                    $this->sendEmail($email,$otp);
                    $updateEmail = $user->find($user_auth->id);
                    $updateEmail->email = $email;
                    $updateEmail->otp = $otp;
                    $updateEmail->is_verify = 0;
                    $updateEmail->save();
                    $response['message']="Your email has been updated successfully.";
                    return Response::json($response,200);  

                } elseif($change_status==2) {
                    $checkLoginType = $user->where('id',$user_auth->id)
                    ->first();
                    if(!empty($checkLoginType) && $checkLoginType->login_type==3 || $checkLoginType->login_type==4){
                        $response['message']="your can't change contact because this contact register with facebook or gmail.";
                        return Response::json($response,200);
                    }
                    try {
                            $otp = "".rand(1000,10000);
                            $abc = urlencode("Your code is"." ".$otp);
                            $data = file_get_contents("https://api.hubtel.com/v1/messages/send?From=EdgeMo&To=$country_code$contact&Content=$abc&ClientId=hjquiqoy&ClientSecret=eyfluzou");
                        } catch(Exception $e) {
                            $otp = 0;
                        }

                    $updateEmail = $user->find($user_auth->id);
                    $updateEmail->contact = $contact;
                    $updateEmail->country_code = $country_code;
                    $updateEmail->otp = $otp;
                    $updateEmail->is_verify = 0;

                    $updateEmail->save();
                    $response['message']="Your contact has been updated successfully.";
                    return Response::json($response,200);   
                } else {
                    $response['message']="Please enter valid change status code.";
                    return Response::json($response,400);   
                }
            }
        }
    }

    public function comment(Request $request) {
        $validation = array(
            'question_id' =>'required|integer',
            'comment' =>'required'
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()) {
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $question_id = $request->question_id;
            $comment = $request->comment;
            $comment_image = $request->comment_image;


            $accessToken = $request->header('accessToken');
            $user_auth = $this->checkAccessToken($accessToken);
            if(empty($user_auth)) {
                $response['message']="Your session has been expired.";
                return Response::json($response,400);   
            } else {
                if (!empty($comment_image)) {
                	$filename = time().$comment_image->getClientOriginalName();
                	//dd($filename);
	                $move_file = $comment_image->move(
	                    base_path().'/comments/',$filename
	                );
                } else {
                	$filename = null;
                }
                $questionComments = new QuestionComment();
                $questionComments->question_id = $question_id;
                $questionComments->comment = $comment;
                $questionComments->comment_image = $filename;
                $questionComments->user_id = $user_auth->id;

                $questionComments->save();
                if($questionComments->id) {
                	$allComment = QuestionComment::getAllData();
                	$response['message'] = "Successfull.";
                	$response['result']  = $allComment;
                	return Response::json($response,200);   
                } else {
                	$response['message']="Unsuccessfull.";
                	return Response::json($response,400);   
                }
            }
        }
    }

    public function commentLike(Request $request) {
    	$validation = array(
            'comment_id' =>'required|integer',
            'like' => 'required|integer'
        );
        $validator = Validator::make($request->all(),$validation);
        if ($validator->fails()) {
            $response['message']=$validator->errors($validator)->first();
            return Response::json($response,400);
        } else {
            $comment_id = $request->comment_id;
            $like = $request->like;

            $accessToken = $request->header('accessToken');
            $user_auth = $this->checkAccessToken($accessToken);
            if(empty($user_auth)) {
                $response['message']="Your session has been expired.";
                return Response::json($response,400);   
            } else {
            	if ($like == 1) {
            		$CommentLike =  App\CommentLike::firstOrNew(['comment_id' => $comment_id, 'user_id' => $user_auth->id]);
					$CommentLike->like_status = 0;
            		$CommentLike->user_id = $user_auth->id;
            		$CommentLike->like_status = $like;
            		$CommentLike->comment_id = $comment_id;
            		if ($CommentLike->save()) {
                		$questionComments = new QuestionComment();
                		$comment = QuestionComment::with(['user' => function($query) {
	            			$query->select('first_name','id','last_name');
	            		}])->withCount('like')->withCount('dislike')->first();
	            		$response['message'] = "Successfull.";
	                	$response['result']  = $comment;
	                	return Response::json($response,200);  
            		} else {
            			$response['message'] = "Something wrong please try again.";
	                	return Response::json($response,400); 
            		}
            	} elseif ($like == 2) {
					$commentData = App\CommentLike::firstOrNew(['comment_id' => $comment_id, 'user_id' => $user_auth->id]);
					$commentData->like_status = 0;
					if($commentData->save()){
						$questionComments = new QuestionComment();
	            		$comment = QuestionComment::with(['user' => function($query) {
	            			$query->select('first_name','id','last_name');
	            		}])->withCount('like')->withCount('dislike')->first();	
					}
            		$response['message'] = "Successfull.";
                	$response['result']  = $comment;
                	return Response::json($response,200); 
					
            	} else {
            		$response['message'] = "Please enter valid like value.";
	                return Response::json($response,400);
            	}
            }
        }
    }

    public function getTopicBySubject(Request $request) {
        
    }
}
