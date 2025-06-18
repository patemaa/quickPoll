<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'polls_votes';

    protected $fillable = ['poll_id', 'option_id', 'ip_address'];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    public function options()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}
