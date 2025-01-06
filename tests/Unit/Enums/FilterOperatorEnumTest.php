<?php

namespace Tests\Unit\Enums;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use PHPUnit\Framework\TestCase;

class FilterOperatorEnumTest extends TestCase
{
    public function test_get_translation()
    {
        $this->assertEquals('=', FilterOperatorEnum::EQUAL->getTranslation());
        $this->assertEquals('Contém', FilterOperatorEnum::LIKE->getTranslation());
        $this->assertEquals('Entre', FilterOperatorEnum::BETWEEN->getTranslation());
    }

    public function test_get_translations()
    {
        $translations = FilterOperatorEnum::getTranslations([
            FilterOperatorEnum::EQUAL,
            FilterOperatorEnum::BETWEEN,
        ]);

        $this->assertCount(2, $translations);
        $this->assertEquals('=', $translations[0]['operator']);
        $this->assertEquals('=', $translations[0]['translation']);
        $this->assertEquals('between', $translations[1]['operator']);
        $this->assertEquals('Entre', $translations[1]['translation']);
    }

    public function test_is_valid()
    {
        $this->assertTrue(FilterOperatorEnum::isValid('='));
        $this->assertTrue(FilterOperatorEnum::isValid('like'));
        $this->assertFalse(FilterOperatorEnum::isValid('invalid_operator'));
    }

    public function test_invalid_translation()
    {
        $this->expectException(\ValueError::class);
        FilterOperatorEnum::from('invalid_operator');
    }
}
