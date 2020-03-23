<?php

namespace Tests\Feature;

use App\Account;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TransactionQueriesTest extends TestCase
{

    use RefreshDatabase;

    function test_it_queries_transactions()
    {
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        $transactions = factory(Transaction::class, 20)->create([
            'account_id' => $account->id
        ]);
        //execute
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                transactions(first: 20) {
                    data {
                        id
                        amount
                        account {
                            id
                        }
                        type
                    }
                    paginatorInfo {
                        currentPage
                    }
                }
            }
        ');
        //assert
        $response->assertJson([
            'data' => [
                'transactions' => [
                    'data' => [],
                    'paginatorInfo' => []
                ]
            ]
        ]);
    }

    function test_it_queries_logged_in_user_transactions()
    {
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        $transactions = factory(Transaction::class, 10)->create([
            'account_id' => $account->id
        ]);
        factory(Transaction::class, 30)->create();
        //execute
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                transactions(first: 20) {
                    data {
                        id
                        amount
                        account {
                            id
                        }
                        type
                    }
                    paginatorInfo {
                        currentPage
                        total
                    }
                }
            }
        ');
        //assert
        $response->assertJson([
            'data' => [
                'transactions' => [
                    'data' => [],
                    'paginatorInfo' => [
                        'total' => 10
                    ]
                ]
            ]
        ]);
    }

    function test_it_queries_a_transaction()
    {
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        $transactions = factory(Transaction::class, 10)->create([
            'account_id' => $account->id
        ]);
        $transaction = $transactions->shuffle()->first();
        //execute
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                transaction(id: '.$transaction->id.') {
                    id
                    amount
                    account {
                        id
                    }
                    type
                }
            }
        ');
        //assert
        $response->assertJson([
            'data' => [
                'transaction' => [
                    'id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'account' => [
                        'id' => $account->id
                    ],
                    'type' => "{$transaction->type}"
                ]
            ]
        ]);
    }

    function test_it_cant_query_a_transaction_where_not_owner()
    {
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id
        ]);
        factory(Transaction::class, 2)->create([
            'account_id' => $account->id
        ]);
        $transactions = factory(Transaction::class, 3)->create();
        $transaction = $transactions->shuffle()->first();
        //execute
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                transaction(id: '.$transaction->id.') {
                    id
                    amount
                    account {
                        id
                    }
                    type
                }
            }
        ');
        //assert
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access transaction'
                ]
            ]
        ]);
    }
}
