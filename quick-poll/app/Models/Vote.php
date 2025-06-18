<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'polls_votes';

    protected $fillable = [
        'ipAddress',
    ];
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
