<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_user_can_login_with_email_and_pwd(): void
    {
        //Arrange
        $user = User::create([
            'name'     => "Abdullah",
            'email'    => "hello@example.com",
            'password' => 'password',
        ]);

        $data = [
            'email'    => $user->email,
            'password' => 'password'
        ];
        
        //Act
        $response = $this->postJson(route('api.user.login'), $data);
        
        //Assert
        $this->assertArrayHasKey('token', $response->json());
    }
}
