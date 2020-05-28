<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations ;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    public function test_a_user_can_browse_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);

    }
    public function test_a_user_can_open_single_thread(){

        $this->get($this->thread->path())
              ->assertSee($this->thread->title);
    }
    public function test_a_user_can_read_associated_replies_of_thread(){

        $reply = factory(Reply::class)->create(['thread_id'=>$this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
    public function test_user_can_filter_threads_according_to_a_channel(){
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class,['channel_id'=>$channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
    public function test_a_user_can_filter_threads_by_username(){
        $this->signIn(create(User::class,['name'=>'mohamed']));

        $threadBymohamed = create(Thread::class,['user_id' => auth()->id()]);
        $threadNotBymohamed = create(Thread::class);
        $this->get('threads?by=mohamed')
            ->assertSee($threadBymohamed->title)
            ->assertDontSee($threadNotBymohamed->title);
    }

    function test_a_user_can_filter_threads_by_popularity(){

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        // When I filter all threads by popularity
        $response = $this->getJson('/threads?popular=1')->json();

        // Then they should be returned from most replies to least
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));

    }


}
