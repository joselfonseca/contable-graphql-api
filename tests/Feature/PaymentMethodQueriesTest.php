<?php

namespace Tests\Feature;

use App\PaymentMethod;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentMethodQueriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_queries_payment_methods()
    {
        $user = factory(User::class)->create();
        factory(PaymentMethod::class, 3)->create([
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                paymentMethods {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'paymentMethods' => []
            ]
        ]);
    }

    public function test_it_queries_a_payment_method()
    {
        $user = factory(User::class)->create();
        $paymentMethods = factory(PaymentMethod::class, 3)->create([
            'user_id' => $user->id
        ]);
        Passport::actingAs($user);
        $paymentMethod = $paymentMethods->shuffle()->first();
        $response = $this->graphQL('
            query {
                paymentMethod(id: '.$paymentMethod->id.') {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'paymentMethod' => [
                    'id' => $paymentMethod->id,
                    'name' => $paymentMethod->name
                ]
            ]
        ]);
    }

    public function test_it_cant_query_a_payment_method_not_owned()
    {
        $user = factory(User::class)->create();
        factory(PaymentMethod::class, 3)->create([
            'user_id' => $user->id
        ]);
        $paymentMethod = factory(PaymentMethod::class)->create();
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                paymentMethod(id: '.$paymentMethod->id.') {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access paymentMethod'
                ]
            ]
        ]);
    }
}
