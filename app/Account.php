<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = ['user_id', 'name', 'balance'];

    protected $casts = [
        'id' => 'Int',
        'user_id' => 'Int',
        'balance' => 'Float'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeByLoggedInUser($query)
    {
        if(!request()->user()){
            return $query;
        }
        return $query->where('user_id', request()->user()->id);
    }
}
