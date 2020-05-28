<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations ;

class ReplyTest extends TestCase
{
    use DatabaseMigrations ;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_owner()
    {
       $reply = factory(Reply::class)->create();
       $this->assertInstanceOf(User::class,$reply->owner);
    }
}
