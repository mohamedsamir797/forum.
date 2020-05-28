<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations ;

class ParticipateFormTest extends TestCase
{
    use DatabaseMigrations ;

    public function test_unauthenticated_user_may_not_add_replies(){
        $this->withExceptionHandling()
             ->post('threads/some-channel/1/replies',[])
             ->assertRedirect('/login');
    }
    public function test_an_authenticated_user_may_participatre_in_form_user(){
        $this->be($user = factory(User::class)->create());
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();
        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())
             ->assertSee($reply->body);
    }
    public function test_a_reply_requires_a_body(){
        $this->withExceptionHandling()->signIn();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class,['body'=>null])->make();
        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');

    }

}
