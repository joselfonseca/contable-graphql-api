<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationSetUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_default_categories_on_user_creation()
    {
        $this->createClient();
        $this->graphQL('
            mutation {
                register(input: {
                    name: "Jose Fonseca",
                    email: "jose@example.com",
                    password: "123456789qq",
                    password_confirmation: "123456789qq"
                })
                {
                    status
                }
            }
        ');
        $user = User::first();
        $this->assertEquals(6, $user->categories->count());
    }
}
