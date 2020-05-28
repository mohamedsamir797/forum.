<?php

namespace App\Filters ;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters {

    protected $filters = ['by','popular','unanswered'];
    /**
     * @param $builder
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->first();
        return $this->builder->where('user_id', $user->id);
    }
    protected function popular(){
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','desc');
    }
    protected function unanswered(){
        return $this->builder->where('replies_count',0);
    }
}
