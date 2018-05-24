<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    // public function question() {
    //     return $this->hasMany('App\Question');
    // }

    // public static function getQuestion($subject_id,$year_id) {
    // 	return Year::with('question')
    // 		->where('subject_id',$subject_id)
    // 		->where('year_id',$year_id)
    // 		->get();
    // }
}
