<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\RangeFilter;
use Mockery;
use PHPUnit\Framework\TestCase;

class RangeFilterTest extends TestCase
{
    public function test_apply_between()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereBetween')
            ->with('payment', [10, 20])
            ->once()
            ->andReturnSelf();

        $filter = new RangeFilter;
        $value = ['field' => 'payment', 'operator' => 'between', 'min' => 10, 'max' => 20];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_greater_than_or_equal()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('payment', '>=', 10)
            ->once()
            ->andReturnSelf();

        $filter = new RangeFilter;
        $value = ['field' => 'payment', 'operator' => '>=', 'min' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_less_than_or_equal()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('payment', '<=', 20)
            ->once()
            ->andReturnSelf();

        $filter = new RangeFilter;
        $value = ['field' => 'payment', 'operator' => '<=', 'max' => 20];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
