<?php

namespace App;

class CalculateAccountBalance
{
    public $old_transaction;

    public function setOldTransaction(Transaction $transaction)
    {
        $this->old_transaction = $transaction;
    }

    public function calculateNewAccountBalance($transaction)
    {
        $account = $transaction->account;
        if ($transaction->type === 'INCOME') {
            $account->balance = $account->balance + $transaction->amount;
            return $account->save();
        }
        $account->balance = $account->balance - $transaction->amount;
        return $account->save();
    }

    public function setAccountBalanceFromOldTransaction(Transaction $transaction) : Account
    {
        $account = $transaction->account;
        if ($this->old_transaction->type === 'INCOME') {
            $account->balance = $account->balance - $this->old_transaction->amount;
            return $account;
        }
        $account->balance = $account->balance + $this->old_transaction->amount;
        return $account;
    }
}
