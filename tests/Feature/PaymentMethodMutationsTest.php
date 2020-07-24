<?php

namespace Tests\Feature;

use App\PaymentMethod;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentMethodMutationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_payment_method()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $response = $this->graphQL('mutation {
            createPaymentMethod(input: {
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
                'createPaymentMethod' => [
                    'name' => 'wallet',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name
                    ]
                ]
            ]
        ]);
        $this->assertDatabaseHas('payment_methods', [
            'name' => 'wallet',
            'user_id' => $user->id
        ]);
    }

    public function test_it_can_update_a_payment_method()
    {
        $user = factory(User::class)->create();
        $paymentMethod = factory(PaymentMethod::class)->create([
            'name' => 'Wallet',
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);
        $response = $this->graphQL('
            mutation {
                updatePaymentMethod(id: '.$paymentMethod->id.', input: {
                    name: "Savings"
                }) {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'updatePaymentMethod' => [
                    'id' => $paymentMethod->id,
                    'name' => 'Savings'
                ]
            ]
        ]);
        $this->assertDatabaseHas('payment_methods', [
            'user_id' => $user->id,
            'name' => 'Savings',
            'id' => $paymentMethod->id
        ]);
    }

    public function test_it_cant_update_a_payment_method_when_not_owner()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $paymentMethod = factory(PaymentMethod::class)->create([
            'name' => 'Wallet',
            'user_id' => $user->id
        ]);
        Passport::actingAs($user2);
        $response = $this->graphQL('
            mutation {
                updatePaymentMethod(id: '.$paymentMethod->id.', input: {
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
                    'message' => 'You are not authorized to access updatePaymentMethod'
                ]
            ]
        ]);
        $this->assertDatabaseMissing('payment_methods', [
            'user_id' => $user->id,
            'name' => 'Savings',
            'id' => $paymentMethod->id
        ]);
    }

    public function test_it_can_delete_a_payment_method()
    {
        $user = factory(User::class)->create();
        $paymentMethod = factory(PaymentMethod::class)->create([
            'name' => 'Wallet',
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);
        $response = $this->graphQL('
            mutation {
                deletePaymentMethod(id: '.$paymentMethod->id.') {
                    id
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'deletePaymentMethod' => [
                    'id' => $paymentMethod->id
                ]
            ]
        ]);
        $deletedPaymentMethod = $paymentMethod->fresh();
        $this->assertNotNull($deletedPaymentMethod->deleted_at);
    }
}
