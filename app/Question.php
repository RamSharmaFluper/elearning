<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function answer() {
        return $this->hasMany('App\Answer');
    }

    public static function getQuestionAnswer() {
    	return Question::with('answer')->paginate(3);
    }

    public function comment() {
        return $this->hasMany('App\QuestionComment');
    }
    // public function like() {
    //     return $this->hasMany('App\QuestionComment');
    // }

}
