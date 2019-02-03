<?php

namespace Tests\Feature;

use App\Thread;
use Tests\DBTestCase;

class CreateThreadsTest extends DBTestCase
{
    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->post('/threads')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());

        $createdThread = Thread::latest()->first();

        $this->get($createdThread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
