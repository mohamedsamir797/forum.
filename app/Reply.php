<?php

namespace App;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    protected $with = ['owner','favorites'];

    protected static function boot()
    {
      parent::boot();

        static::created(function ($reply){
            Activity::create([
                'user_id' => auth()->id() ,
                'type' => 'created_reply' ,
                'subject_id' => $reply->id ,
                'subject_type' => 'App\Reply'
            ]);
        });

        static::created(function ($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply){
            $reply->thread->decrement('replies_count');
        });
    }
        public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function favorites(){
        return $this->morphMany(Favorite::class,'favorited');
    }
    public function favotire(){
        if ( ! $this->favorites()->where(['user_id'=> auth()->id()])->exists()){
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function unfavotire(){

        return $this->favorites()->delete();

    }
    public function isFavotited (){
       return !! $this->favorites->where('user_id',auth()->id())->count();
    }
    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
    public function thread(){
        return $this->belongsTo(Thread::class);
    }
    public function path(){
        return $this->thread->path()."#reply-{$this->id}" ;
    }
}
