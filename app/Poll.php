<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function pollOptions() {
        return $this->hasMany(PollOption::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
