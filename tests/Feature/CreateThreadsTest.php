<?php

namespace Tests\Feature;

use App\Thread;
use Tests\DBTestCase;

class CreateThreadsTest extends DBTestCase
{
    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->post(route('threads.store'))
            ->assertRedirect('/login');

        $this->get(route('threads.create'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');
        $this->post(route('threads.store'), $thread->toArray());

        $createdThread = Thread::latest()->first();

        $this->get($createdThread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
