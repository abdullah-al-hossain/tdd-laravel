<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => "Abdullah",
            'email'=> "customer@example.com",
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    public function test_if_user_is_registering_successfully(): void
    {
        
        $user = $this->post(route('api.user.register'), $this->data);

        $user->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $this->data['email'],
            'name'  => $this->data['name'],
        ]);
    }

    public function test_password_field_is_bcrypted_and_confirmation_match()
    {
        //Arrange
        $this->withExceptionHandling();
        $this->data = [
            'name' => "Abdullah",
            'email'=> "customer@example.com",
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        //Act
        $this->postJson(route('api.user.register'), $this->data);

        //Assert
        $user = User::latest()->first();
        $this->assertEquals($this->data['password'], $this->data['password_confirmation']);
        $this->assertTrue(Hash::check($this->data['password'], $user->password));

    }

    public function test_while_registration_required_fields_are_required()
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
