<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_if_user_is_registering_successfully(): void
    {
        $data = [
            'name' => "Abdullah",
            'email'=> "customer@example.com",
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        
        $user = $this->post(route('api.user.register'), $data);

        $user->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);
    }

    public function test_password_field_is_bcrypted_and_confirmation_match()
    {
        //Arrange
        $this->withExceptionHandling();
        $data = [
            'name' => "Abdullah",
            'email'=> "customer@example.com",
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        //Act
        $this->postJson(route('api.user.register'), $data);

        //Assert
        $user = User::latest()->first();
        $this->assertEquals($data['password'], $data['password_confirmation']);
        $this->assertTrue(Hash::check($data['password'], $user->password));


    }

    public function test_while_registration_email_field_is_required()
    {
        //Arrange 
        $this->withExceptionHandling();
        
        //Act
        $response = $this->postJson(route('api.user.register'), []);
        
        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email', 'name', 'password']);
    }
}
