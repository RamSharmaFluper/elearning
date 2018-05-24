<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionComment extends Model
{
    public function user() {
        return $this->belongsTo(User::class)->select('id','first_name');
    }
    // public function userWithQuestion() {
    //     return $this->belongsTo(User::class);
    // }

    public function like() {
        return $this->hasMany('App\CommentLike','comment_id')->where('like_status',1);
    }
     public function dislike() {
        return $this->hasMany('App\CommentLike','comment_id')->where('like_status',0);
    }

    public static function getAllData(){
    	$data = Self::with(['user' => function($query) {
            			$query->select('first_name','id','last_name');
            		}])->withCount('like')->withCount('dislike')->get();
    	return $data;
    }
}

