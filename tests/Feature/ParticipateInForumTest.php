<?php

namespace Tests\Feature;

use Tests\DBTestCase;

class ParticipateInForum extends DBTestCase
{
    /** @test */
    public function an_unauthenticated_user_may_not_participate_in_forum_threads()
    {
        $this->post(route('replies.store', ['channel' => 'admin', 'thread' => 1]), [])
            ->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        parent::signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post(
            route('replies.store', ['channel' => $thread->channel, 'thread' => $thread->id]), $reply->toArray()
        );

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_has_a_body()
    {
        parent::signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post(
            route('replies.store', ['channel' => $thread->channel, 'thread' => $thread->id]), $reply->toArray()
        )->assertSessionHasErrors('body');
    }

}
