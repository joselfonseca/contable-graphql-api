<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryQueriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_queries_categories()
    {
        $user = factory(User::class)->create();
        factory(Category::class, 3)->create([
            'user_id' => $user
        ]);
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                categories{
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'categories' => []
            ]
        ]);
    }

    public function test_it_queries_an_account()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class, 3)->create([
            'user_id' => $user
        ]);
        Passport::actingAs($user);
        $category = $category->shuffle()->first();
        $response = $this->graphQL('
            query {
                category(id: '.$category->id.') {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ]
        ]);
    }

    public function test_it_cant_query_an_account_not_owned()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        Passport::actingAs($user);
        $response = $this->graphQL('
            query {
                category(id: '.$category->id.') {
                    id
                    name
                }
            }
        ');
        $response->assertJson([
            'errors' => [
                [
                    'message' => 'You are not authorized to access category'
                ]
            ]
        ]);
    }
}
