<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $fillable = ['account_id', 'description', 'amount', 'type'];

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

}
