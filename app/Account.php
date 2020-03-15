<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = ['user_id', 'name', 'balance'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
