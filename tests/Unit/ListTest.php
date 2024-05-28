<?php

use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\User;

test('list belongs to a user', function () {
    $user = User::factory()->create();
    $list = EmailList::factory()->create(['user_id' => $user->id]);

    $this->assertInstanceOf(User::class, $list->user);
});

test('when user is deleted then email list of that user also deleted', function() {
    $user = User::factory()->create();
    $list = EmailList::factory()->for($user)->create();

    $user->delete();

    $this->assertNull(EmailList::find($list->id)); 
    $this->assertDatabaseMissing('email_lists', [
        'id' => $list->id,
    ]);
});

it('has many campaigns', function() {
    $list = EmailList::factory()->has(Campaign::factory(), 'campaigns')->create();

    expect($list->campaigns->first())->toBeInstanceOf(Campaign::class);
});

it('has many subscriber', function() {
    $list = EmailList::factory()->has(Subscriber::factory(), 'subscribers')->create();

    expect($list->subscribers->first())->toBeInstanceOf(Subscriber::class);
});