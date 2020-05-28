<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations ;

class ThreadTest extends TestCase
{
    use DatabaseMigrations ;

    protected $thread ;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();

    }
    public function test_a_thread_can_make_string_path(){
        $thread = create(Thread::class);
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}",$thread->path());
    }

    public function test_a_thread_has_replies()
    {

        $this->assertInstanceOf('Illuminate\Database\Eloquent\collection',$this->thread->replies);
    }
    public function test_a_thread_has_creator(){
        $this->assertInstanceOf(User::class,$this->thread->creator);
    }
    public function test_thread_can_add_reply(){
        $this->thread->addReply([
            'body' => 'foober',
            'user_id' => 1
        ]);
        $this->assertCount(1,$this->thread->replies);
    }
    public function test_thread_belongs_to_channel(){
        $thread = create(Thread::class);
        $this->assertInstanceOf(Channel::class,$thread->channel);
    }
}
