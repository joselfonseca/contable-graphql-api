<?php

namespace Tests\Feature;

use App\Account;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TranactionTest extends TestCase
{
    use RefreshDatabase;

    function test_it_creates_transaction_and_updates_balance()
    {
        // prepare
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $user->id,
            'balance' => 0
        ]);
        Passport::actingAs($user);
        //execute
        $response = $this->graphQL('
            mutation {
                createTransaction(input: {
                    account_id: '.$account->id.',
                    type: INCOME,
                    description: "Income",
                    amount: 100
                }) {
                    description
                    type
                    amount
                    account {
                        id
                        name
                        balance
                    }
                }
            }
        ');
        //assert
        $response->assertJson([
            'data' => [
                'createTransaction' => [
                    'description' => "Income",
                    'type' => 'INCOME',
                    'amount' => 100.0,
                    'account' => [
                        'id' => $account->id,
                        'name' => $account->name,
                        'balance' => 100.0
                    ]
                ]
            ]
        ]);
    }
}
