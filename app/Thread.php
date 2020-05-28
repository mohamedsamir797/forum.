<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected $guarded = [];
    protected $with = ['creator','channel'];
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('replyCount',function ($builder){
            $builder->withCount('replies');
        });

        static::created(function ($thread){
           Activity::create([
               'user_id' => auth()->id() ,
               'type' => 'created_thread' ,
                'subject_id' => $thread->id ,
                'subject_type' => 'App\Thread'
           ]);
        });

    }


    public function path(){
        return  "/threads/{$this->channel->slug}/{$this->id}" ;
    }
    public function replies(){
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');

    }
    public function creator(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function addReply($reply){

       $reply =  $this->replies()->create($reply);

       foreach ( $this->subscriptions as $subscription)
           if ($subscription->user_id != $reply->user_id) {
               $subscription->user->notify(new ThreadWasUpdated($this, $reply));
           }
       return $reply ;
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }
    public function scopeFilter($query , $filters){
      return $filters->apply($query);
    }

    public function subscribe($userId = null){
      $this->subscriptions()->create([
          'user_id' => $userId ?: auth()->id()
      ]);

      return $this ;
    }

    public function subscriptions(){
       return $this->hasMany(ThreadSupscription::class);
    }
    public function isSuscribed (){
        return !! $this->subscriptions->where('user_id',auth()->id())->count();
    }
}
