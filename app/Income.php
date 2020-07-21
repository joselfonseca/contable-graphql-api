<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'account_id',
        'date',
        'amount',
        'description'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeByLoggedInUser($query)
    {
        if (! request()->user()) {
            return $query;
        }
        return $query->where('user_id', request()->user()->id);
    }
}
