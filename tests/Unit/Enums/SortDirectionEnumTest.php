<?php

namespace Tests\Unit\Enums;

use InovantiBank\AdvancedQueryFilters\Enums\SortDirectionEnum;
use PHPUnit\Framework\TestCase;

class SortDirectionEnumTest extends TestCase
{
    public function test_is_valid()
    {
        $this->assertTrue(SortDirectionEnum::isValid('asc'));
        $this->assertTrue(SortDirectionEnum::isValid('desc'));
        $this->assertFalse(SortDirectionEnum::isValid('invalid'));
        $this->assertFalse(SortDirectionEnum::isValid('ASCENDING'));
    }

    public function test_available_directions()
    {
        $directions = SortDirectionEnum::availableDirections();

        $this->assertCount(2, $directions);
        $this->assertContains('asc', $directions);
        $this->assertContains('desc', $directions);
    }
}
