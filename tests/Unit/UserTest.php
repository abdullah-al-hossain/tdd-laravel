<?php

use App\Models\EmailList;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_many_lists()
    {
        $user = User::factory()->create();

        EmailList::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(EmailList::class, $user->lists->first());
        expect($user->lists)->toHaveCount(3);
    }
}