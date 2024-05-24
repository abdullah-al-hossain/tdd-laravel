<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $data = [
            'name' => "Abdullah",
            'email'=> "customer@example.com",
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        
        $user = $this->post(route('user.create'), $data);

        $user->assertCreated();
    }
}
