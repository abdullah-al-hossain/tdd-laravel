<?php

use App\Models\EmailList;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

test('logged in user can create a new list', function() {
    // Arrange

    // Act
    $this->postJson(route('api.email-lists.store'), [
        'name' => 'My List',
    ]);

    // Assert
    $this->assertDatabaseHas('email_lists', [
        'name' => 'My List',
        'user_id' => $this->user->id
    ]);
});

test("guests can't create a new list", function() {
    // Act
    $this->withExceptionHandling();
    
    $this->postJson(route('api.email-lists.store'), [
        'name' => 'My List',
    ])->assertUnauthorized();
});

test('new list requires name field', function() {

    $this->withExceptionHandling();

    $this->postJson(route('api.email-lists.store'), [
        'name' => '',
    ])->assertStatus(422);

});

test('user can list all the email lists', function() {

    $emailList = EmailList::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $response = $this->getJson(route('api.email-lists.index'));


    $response->assertJson([
        'data' => [
            [
                'id'   => $emailList->id,
                'name' => $emailList->name,
            ]
        ]
    ]);
});

test('user can update a single list', function() {

    $emailList = EmailList::factory()->for($this->user)->create();

    $response = $this->putJson(route('api.email-lists.update', $emailList->id), [
        'name' => 'Updated Name',
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('email_lists', [
        'id'   => $emailList->id,
        'name' => 'Updated Name',
    ]);
});

test("user can delete a list", function () {
    // Arrange

    $emailList = EmailList::factory()->create([
        'user_id' => $this->user->id,
    ]);

    // Act
    $response = $this->deleteJson(route('api.email-lists.destroy', $emailList->id));

    // Assert
    $response->assertOk();
    $this->assertDatabaseMissing('email_lists', [
        'id' => $emailList->id,
    ]);
});

test('user can get single email list that user has created', function () {
    // Arrage
    $list = EmailList::factory()->create([
        'user_id' => $this->user->id,
    ]);

    // Act
    $response = $this->getJson(route('api.email-lists.show', $list->id));
    // Assert
    $response->assertOk();
});