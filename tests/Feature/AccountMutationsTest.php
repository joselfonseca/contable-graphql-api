<?php

namespace Tests\Feature;

use App\Account;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AccountMutationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_account()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $response = $this->graphQL('mutation {
            createAccount(input: {
                name: "wallet"
            }) {
                name
                user {
                    id
                    name
                }
            }
        }');
        $response->assertJson([
            'data' => [
                'createAccount' => [
                    'name' => 'wallet',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name
                    ]
                ]
            ]
        ]);
        $this->assertDatabaseHas('accounts', [
            'name' => 'wallet',
            'user_id' => $user->id
        ]);
    }

    public function test_it_can_update_an_account()
    {
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'name' => 'Wallet',
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);
        $response = $this->graphQL('
            mutation {
                updateAccount(id: '.$account->id.', input: {
                    name: "Savings"
                }) {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'updateAccount' => [
                    'id' => $account->id,
                    'name' => 'Savings'
                ]
            ]
        ]);
        $this->assertDatabaseHas('accounts', [
            'user_id' => $user->id,
            'name' => 'Savings',
            'id' => $account->id
        ]);
    }

    public function test_it_cant_update_an_account_when_not_owner()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'name' => 'Wallet',
            'user_id' => $user->id
        ]);
        Passport::actingAs($user2);
        $response = $this->graphQL('
            mutation {
                updateAccount(id: '.$account->id.', input: {
                    name: "Savings"
                }) {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access updateAccount'
                ]
            ]
        ]);
        $this->assertDatabaseMissing('accounts', [
            'user_id' => $user->id,
            'name' => 'Savings',
            'id' => $account->id
        ]);
    }

    public function test_it_can_delete_an_account()
    {
        $user = factory(User::class)->create();
        $account = factory(Account::class)->create([
            'name' => 'Wallet',
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);
        $response = $this->graphQL('
            mutation {
                deleteAccount(id: '.$account->id.') {
                    id
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'deleteAccount' => [
                    'id' => $account->id
                ]
            ]
        ]);
        $deletedAccount = $account->fresh();
        $this->assertNotNull($deletedAccount->deleted_at);
    }
}
