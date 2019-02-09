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

        $response = $this->post(route('threads.store'), $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post(route('threads.store'), $thread->toArray());
    }

}
