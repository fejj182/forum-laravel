<?php

namespace Tests\Feature;

use Tests\DBTestCase;

class ParticipateInForum extends DBTestCase
{
    /** @test */
    public function an_unauthenticated_user_may_not_participate_in_forum_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('threads/1/replies', []);
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        parent::signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
