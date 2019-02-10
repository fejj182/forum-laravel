<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function path()
    {
        return route('channels.show', ["channel" => $this->slug]);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
