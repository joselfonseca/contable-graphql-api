<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationSetUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_default_categories_on_user_creation()
    {
        $user = factory(User::class)->create();
        event(new Registered($user));
        $this->assertEquals(6, $user->categories->count());
        $this->assertEquals(1, $user->paymentMethods->count());
    }
}
