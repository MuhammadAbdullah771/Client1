<?php

namespace Tests\Unit;

use App\Support\ContactMailConfig;
use PHPUnit\Framework\TestCase;

class ContactMailConfigTest extends TestCase
{
    public function test_it_selects_the_first_valid_recipient(): void
    {
        $this->assertSame(
            'jobs@example.com',
            ContactMailConfig::firstValidEmail(['', 'not-an-email', ' jobs@example.com '])
        );
    }

    public function test_it_returns_null_when_no_recipient_is_valid(): void
    {
        $this->assertNull(ContactMailConfig::firstValidEmail(['', 'not-an-email']));
    }
}
