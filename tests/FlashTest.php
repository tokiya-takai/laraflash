<?php

declare(strict_types=1);

namespace Tokiya\Laraflash\Tests;

use Tests\TestCase;

class FlashTest extends TestCase
{
    /** @test */
    public function it_can_set_a_flash_message()
    {
        flash('Flash message');

        $this->assertTrue('Flash message' === flash()->getMessage());
    }

    /** @test */
    public function it_can_set_a_message_with_level()
    {
        flash('Success Flash Message')->success();

        $this->assertTrue('Success Flash Message' === flash()->getMessage());
    }

    /** @test */
    public function it_can_set_a_flash_message_by_level_method()
    {
        flash()->success('Flash message');

        $this->assertTrue('Flash message' === flash()->getMessage());
    }

    /** @test */
    public function it_can_set_a_customize_error_key()
    {
        flash()->customizeErrorKey('danger');

        $this->assertTrue('danger' === flash()->getErrorKey());
    }

    /** @test */
    public function it_can_change_a_default_message()
    {
        flash()->setDefaultSuccessMessage('Changed success message.')->success();

        $this->assertTrue('Changed success message.' === flash()->getMessage());
    }

    /** @test */
    public function it_can_call_at_any_level()
    {
        flash('Primary message.')->primary();

        $this->assertTrue('Primary message.' === flash()->getMessage());
        $this->assertTrue('primary' === flash()->getLevel());
    }
}
