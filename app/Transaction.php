<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['account_id', 'category_id', 'description', 'amount', 'type'];

    protected $casts = [
        'id' => 'Int',
        'account_id' => 'Int',
        'category_id' => 'Int',
        'amount' => 'Float'
    ];

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
        return $query->whereHas('account', function ($query) {
            $query->where('user_id', request()->user()->id);
        });
    }
}
