<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\BooleanFilter;
use Illuminate\Database\Eloquent\Builder;

class BooleanFilterTest extends TestCase
{
    public function testApplyEquals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', true)
              ->once()
              ->andReturnSelf();

        $filter = new BooleanFilter();
        $value = ['operator' => '=', 'boolean' => true];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
