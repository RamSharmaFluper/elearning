<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\News;
use App\Education;
use App\Year;
use App\Exam;
use App\Subject;
use App\SubjectTopic;
use App\TopicSections;
use App\TopicSubSections;
use App\Question;
use App\Answer;

use DB;
use Validator;

class AdminController extends Controller
{
    public function login(Request $request) {
        return view('admin/login');
    }
    public function logout(Request $request){
        session()->flush('id');
        return redirect('login');
    }
    public function signin(Request $request) {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remb;
        $validation = array(
            'email'=>'required',
            'password'=>'required',
        );
        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect('login')
            ->withErrors($validator)
            ->withInput();
        }else{  
            $admin = new Admin();
            $data=$admin->where('email',$email)->where('password',$password)->first();
            if(!empty($data)){
                session()->put('id',$data->id);
                if (!empty($remember)) {
                    $d = setcookie("email",$request->input('email'), time() + (86400 * 30), "/");
                    setcookie("password",$request->input('password'), time() + (86400 * 30), "/");
                } else {
                    unset($_COOKIE['email']);
                    unset($_COOKIE['password']);
                    $d = setcookie("email",null, -1, "/");
                    setcookie("password",null, -1, "/");
                }
                return redirect('profile');

            } else {
                return redirect('login');
                
            }
        }
    }
    public function getAdmindDta($id){
        $admin = new Admin();
        $data = $admin->find($id);
        return $data;
    }
    public function profile(Request $request) {
        if(!empty(session()->get('id'))){
            $admin =  $this->getAdmindDta(session()->get('id'));
            return view('admin/profile',compact('admin'));
        } else {
            return redirect('login');
        }
    }
    public function users(Request $request) {
        if(!empty(session()->get('id'))){
            $admin =  $this->getAdmindDta(session()->get('id'));
            $usersdata = User::all();
            return view('admin/accountMgt',compact('usersdata','admin'));
        } else  {
            return redirect('login');
        }
    }
    public function block($id) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $userdata = $user->find($id);

            $userdata->is_block = 1;
            $userdata->save();
            if($userdata->id) {
                return redirect('users');
            } else {
                dd("something wrong");
            }
        } else  {
            return redirect('login');
        }
    }
    public function unblock($id) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $userdata = $user->find($id);

            $userdata->is_block = 0;
            $userdata->save();
            if($userdata->id) {
                return redirect('users');
            } else {
                dd("something wrong");
            }
        } else  {
            return redirect('login');
        }
    }
    public function news(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $getnews = DB::table('news')
                     ->select('users.name','news.*','news_category.name as categoryName')
                     ->join('users','news.user_id','users.id')
                     ->join('news_category','news.category_id','news_category.id')->get();
            //dd($getnews);


            return view('admin/news',compact('getnews'));
        } else  {
            return redirect('login');
        }
    }
    public function editProfile(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));

            return view('admin/edit-profile',compact('admin'));

        } else  {
            return redirect('login');
        }
    }
    public function updateProfile(Request $request){
        $contact=$request->phone;
        $location=$request->location;
        $address=$request->address;
        $image=$request->image;
        $name=$request->name;
        $session_id=session()->get('id');
        if(empty($session_id)){
            return redirect('login');
        }else{
            if(!empty($image)){
                $path = $_FILES['image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext == "jpeg" || $ext == "png"){
                    $imagename =time().".". $image->getClientOriginalName();
                    $move_file = $image->move(
                        base_path().'/adminProfile/', $imagename
                    );
                }else{
                    $session = session()->flash('image',"please upload only image");
                    return redirect('editProfile');
                }
                
            }else{
                $adminImage=DB::table('admins')->where('id',$session_id)->first();
                if(!empty($adminImage)){
                    $imagename=$adminImage->image;
                }else{
                    $imagename=null;
                }
            }
            $admin=new admin();
            $update=DB::table('admins')->where('id',$session_id)
            ->update(['contact'=>$contact,'location'=>$location,'address'=>$address,'image'=>$imagename,'name'=>$name]);
            if($update){
                $session = session()->flash('profile','Profile update successfully');
                return redirect('profile');
            }else{
                return redirect('editProfile');
            }

        }
    }
    public function changePassword(Request $request){
        if(empty(session()->get('id'))){
            $admin = new admin();
            return redirect('login');
        }else{
            $admin =  $this->getAdmindDta(session()->get('id'));
            return view('admin/changePassword',compact('admin'));
        }
    }
    public function updatePassword(Request $request){
        $id=session()->get('id');
        $oldPassword=$request->oldPassword;
        $password=$request->password;
        $confirm=$request->confirmPassword;
        $validation = array(
            'oldPassword'=>'required',
            'password'=>'required|min:8',
            'confirmPassword'=>'required|same:password'
        );
        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect('change-password')
            ->withErrors($validator)
            ->withInput();
        }else{  
            $admin = new admin();

            $id=session()->get('id');
            $admindata = $admin->where('id',$id)->first();
            if(!($oldPassword==$admindata->password)){
                $session = session()->flash('confermPassword','Old Password Not valid');
                return redirect('changePassword');
            }else{
                if($password==$admindata->password){
                    $session = session()->flash('same','This password already exist');
                    return redirect('changePassword');
                }else{
                    $updateProfile=$admin
                    ->where('id',$id)->update(['password'=>$password]);
                $session = session()->flash('profile','Password update successfully');

                    return redirect('profile');
                }
            }
        }
    }
    public function questionMgt(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $years = Year::all();
               $exam = new Exam;
            $exams = $exam->all();
            return view('admin/question-mgt',compact('admin','years','exams'));

        } else  {
            return redirect('login');
        }
    }

    public function selectClassEditPart(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $educations = Education::all();

            return view('admin/edit-part1',compact('admin','educations'));

        } else  {
            return redirect('login');
        }
    }
    public function editYear(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $years = Year::all();
            
            return view('admin/editYear',compact('admin','years'));

        } else  {
            return redirect('login');
        }
    }
    public function editExam(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $exam = new Exam;
            $exams = $exam->all();
            $admin =  $this->getAdmindDta(session()->get('id'));
            return view('admin/edit-exam',compact('admin','exams'));

        } else  {
            return redirect('login');
        }
    }
    public function editVisiblity(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            return view('admin/edit-visiblity',compact('admin'));

        } else  {
            return redirect('login');
        }
    }
    public function addEducations(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;


        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = Education::where('id',$eduId[$i])->update(array('education'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {
               $edu = new Education();

                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    //return $educations[$k];
                    if(!empty($educations[$k])){
                        // $edu->education = $educations[$k];
                        // $edu->save();
                       $insert=DB::table('education')->insert(array('education' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
            //return 
            $edu = new Education();
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('education')->insert(array('education' => $educations[$j]));

                    // $edu->education = $educations[$j];
                    // $edu->save();
                }
            }
        }
    }
    public function deleteEducations(Request $request) {
        if(!empty(session()->get('id'))){

            $edu = new Education();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }

    public function education(Request $requst) {
        if(!empty(session()->get('id'))) {
            $education = Education::all();
            return $education;
        } else  {
            return 204;
        }
    }
    public function deleteYear(Request $request) {
        if(!empty(session()->get('id'))){
            $edu = new Year();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }
    public function addYear(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;

        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = Year::where('id',$eduId[$i])->update(array('year'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {

                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    if(!empty($educations[$k])){
                       
                       $insert=DB::table('years')->insert(array('year' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
          
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('years')->insert(array('year' => $educations[$j]));

                }
            }
        }
    }
    public function deleteExam(Request $request) {
        if(!empty(session()->get('id'))){
            $edu = new Exam();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }
    public function addExam(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;

        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = Exam::where('id',$eduId[$i])->update(array('exam'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {
                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    if(!empty($educations[$k])){
                       
                       $insert=DB::table('exams')->insert(array('exam' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('exams')->insert(array('exam' => $educations[$j]));

                }
            }
        }
    }
    public function showQuestionCategory(Request $request) {
        $admin =  $this->getAdmindDta(session()->get('id'));
        $subjects = Subject::all();
        $topics = SubjectTopic::all();
        $topicSections = TopicSections::all();
        $topicSubSections = TopicSubSections::all();
        return view('admin/addQuestion-category',compact('admin','subjects','topics','topicSections','topicSubSections'));
    }
    public function questionType(Request $request) {
        $admin =  $this->getAdmindDta(session()->get('id'));

        return view('admin/question-type',compact('admin'));
    }
    public function editSubject(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $subjects = Subject::all();
            
            return view('admin/edit-subject',compact('admin','subjects'));

        } else  {
            return redirect('login');
        }
    }
    public function editTopic(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $topics = SubjectTopic::all();
            
            return view('admin/edit-topic',compact('admin','topics'));

        } else  {
            return redirect('login');
        }
    }
    public function editTopicSection(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $topicSections = TopicSections::all();
            
            return view('admin/edit-topic-section',compact('admin','topicSections'));

        } else  {
            return redirect('login');
        }
    }
    public function editTopicSubSection(Request $request) {
        if(!empty(session()->get('id'))){
            $user = new User();
            $admin =  $this->getAdmindDta(session()->get('id'));
            $topicSubSections = TopicSubSections::all();
            
            return view('admin/edit-topic-sub-sections',compact('admin','topicSubSections'));

        } else  {
            return redirect('login');
        }
    }
    public function deleteSubject(Request $request) {
        if(!empty(session()->get('id'))){
            $edu = new Subject();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }
    public function addSubject(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;

        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = Subject::where('id',$eduId[$i])->update(array('subject'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {
                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    if(!empty($educations[$k])){
                       
                       $insert=DB::table('subjects')->insert(array('subject' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('subjects')->insert(array('subject' => $educations[$j]));

                }
            }
        }
    }
    public function deleteTopic(Request $request) {
        if(!empty(session()->get('id'))){
            $edu = new SubjectTopic();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }
    public function addTopic(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;

        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = SubjectTopic::where('id',$eduId[$i])->update(array('subject'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {
                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    if(!empty($educations[$k])){
                       
                       $insert=DB::table('subject_topics')->insert(array('subject' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('subject_topics')->insert(array('subject' => $educations[$j]));

                }
            }
        }
    }

    public function deleteTopicSection(Request $request) {
        if(!empty(session()->get('id'))){
            $edu = new TopicSections();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }
    public function addTopicSection(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;

        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = TopicSections::where('id',$eduId[$i])->update(array('subject'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {
                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    if(!empty($educations[$k])){
                       
                       $insert=DB::table('topic_sections')->insert(array('subject' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('topic_sections')->insert(array('subject' => $educations[$j]));

                }
            }
        }
    }
    public function deleteTopicSubSection(Request $request) {
        if(!empty(session()->get('id'))){
            $edu = new TopicSubSections();
             $edu->where('id',$request->eduId)->delete();
             return 1;
        } else  {
            return redirect('login');

        }
    }
    public function addTopicSubSection(Request $request) {
        $educations = $request->educations;
        $eduId = $request->eduId;

        if(!empty($eduId)) {
            for ($i=0; $i < count($eduId); $i++) { 
                if(!empty($educations[$i])){

                    $updateEduction = TopicSubSections::where('id',$eduId[$i])->update(array('subject'=>$educations[$i]));
                }
            }
            if (count($eduId) < count($educations)) {
                $startPoint = count($educations)-count($eduId);
                for($k=count($eduId); $k < count($educations); $k++) {
                    if(!empty($educations[$k])){
                       
                       $insert=DB::table('topic_sub_sections')->insert(array('subject' => $educations[$k]));
                    }
                }
            }
        } elseif(empty($eduId) || !empty($education)) {
            for ($j = 0; $j < count($educations); $j++) { 
                if(!empty($educations[$k])){
                    $insert=DB::table('topic_sub_sections')->insert(array('subject' => $educations[$j]));

                }
            }
        }
    }
    public function questionList(Request $request) {
        $admin =  $this->getAdmindDta(session()->get('id'));
        $questions = Question::getQuestionAnswer();
        $get_right = Answer::select('question_id')->where('answer_status',1)->get();
        //dd($get_right);
        $correct = array();
        if (count($get_right)>0){
            foreach ($get_right as $key => $value) {
                # code...
                $correct[++$key]=$value->question_id;
            }
        } else {
            $correct=array('0'=>0);
        }
        //dd($correct);
        // $a=array("a"=>"5","b"=>5,"c"=>"5");
        // echo array_search(10,$a,true);die;
       
        return view('admin/question-list',compact('admin','questions','correct'));
    }
    public function correctAnswer($question_id) {
        if(!empty(session()->get('id'))){
            $admin =  $this->getAdmindDta(session()->get('id'));
            $answer = Answer::where('question_id',$question_id)->get();
           return view('admin/correct-answer',compact('admin','answer'));

        } else  {
            return redirect('login');

        }
    }

    public function deleteQuestion($question_id) {
         if(!empty(session()->get('id'))){
            $answer = Answer::where('question_id',$question_id)->delete();
            $answer = Question::where('id',$question_id)->delete();
            return redirect('question-list');
        } else  {
            return redirect('login');

        }
    }

}
