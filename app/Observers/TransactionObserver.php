<?php

namespace App\Observers;

use App\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        $account = $transaction->account;
        if ($transaction->type === "INCOME") {
            $account->balance = $account->balance + $transaction->amount;
            return $account->save();
        }
        $account->balance = $account->balance - $transaction->amount;
        return $account->save();
    }
}
