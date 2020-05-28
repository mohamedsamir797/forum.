<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [];

    protected static function boot(){
        parent::boot();

//        static::created(function (Favorite $favorite){
//            Activity::create([
//                'user_id' => auth()->id() ,
//                'type' => 'created_Favorite' ,
//                'subject_id' => $favorite->id ,
//                'subject_type' => 'App\Favorite'
//            ]);
//        });
    }
    public function favorited(){
        return $this->morphTo();
    }
}
