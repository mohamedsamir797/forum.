<?php


namespace Tests\Feature;

use App\Favorite;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations ;
    public function test_guests_cant_favorite_any_thing(){
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }
    public function test_a_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->post('replies/'.$reply->id.'/favorites');

        $this->assertCount(1,$reply->favorites);
    }
    public function test_a_authenticated_user_may_favorite_reply_once(){
        $this->signIn();
        $reply = create(Reply::class);

        try{
            $this->post('replies/'.$reply->id.'/favorites');
            $this->post('replies/'.$reply->id.'/favorites');
        }catch (\Exception $e){
            $this->fail('Did not expect insert el same record');
        }


        $this->assertCount(1,$reply->favorites);
    }
}
