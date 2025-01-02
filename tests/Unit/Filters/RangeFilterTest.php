<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\RangeFilter;
use Illuminate\Database\Eloquent\Builder;

class RangeFilterTest extends TestCase
{
    public function testApplyBetween()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereBetween')
              ->with('field', [10, 20])
              ->once()
              ->andReturnSelf();

        $filter = new RangeFilter();
        $value = ['operator' => 'between', 'min' => 10, 'max' => 20];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyGreaterThanOrEqual()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', '>=', 10)
              ->once()
              ->andReturnSelf();

        $filter = new RangeFilter();
        $value = ['operator' => '>=', 'min' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyLessThanOrEqual()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', '<=', 20)
              ->once()
              ->andReturnSelf();

        $filter = new RangeFilter();
        $value = ['operator' => '<=', 'max' => 20];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
