<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $guarded = [];

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_answer', 'answer_id', 'user_id');
    }
}
