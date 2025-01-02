<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NumericFilter;

class NumericFilterTest extends TestCase
{
    public function testApplyEquals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', '=', 10)
              ->once()
              ->andReturnSelf();

        $filter = new NumericFilter();
        $value = ['operator' => '=', 'number' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyGreaterThan()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', '>', 10)
              ->once()
              ->andReturnSelf();

        $filter = new NumericFilter();
        $value = ['operator' => '>', 'number' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
