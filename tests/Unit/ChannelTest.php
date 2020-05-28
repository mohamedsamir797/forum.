<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations ;
    public function test_channel_consist_of_threads()
    {

       $channel = create(Channel::class);
        $thread = create(Thread::class,['channel_id'=> $channel->id]);

       $this->assertTrue($channel->threads->contains($thread));
    }
}
