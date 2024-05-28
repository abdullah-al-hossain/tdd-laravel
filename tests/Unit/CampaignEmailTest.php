<?php

use App\Models\Campaign;
use App\Models\CampaignEmail;

test('campaign emails belongs to a campaign', function() {
    $campaignEmail = CampaignEmail::factory()
                            ->for(Campaign::factory(), 'campaign')
                            ->create();

   $this->assertInstanceOf(Campaign::class, $campaignEmail->campaign);
});

test('campaign email has many fields', function () {
    $campaignEmail = CampaignEmail::factory()->raw();

    $this->assertArrayHasKey('sent_at', $campaignEmail);
    $this->assertArrayHasKey('opened_at', $campaignEmail);
    $this->assertArrayHasKey('clicked_at', $campaignEmail);
    $this->assertArrayHasKey('unsubscribed_at', $campaignEmail);
    $this->assertArrayHasKey('bounced_at', $campaignEmail);
    $this->assertArrayHasKey('complained_at', $campaignEmail);
});