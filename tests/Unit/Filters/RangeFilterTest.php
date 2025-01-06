<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\RangeFilter;
use InvalidArgumentException;
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

    public function test_apply_missing_min_or_max_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing 'min' or 'max' value for 'between' operator");

        $query = Mockery::mock(Builder::class);

        $filter = new RangeFilter;
        $value = ['field' => 'payment', 'operator' => 'between'];

        $filter->apply($query, $value);
    }

    public function test_apply_invalid_operator_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid operator for RangeFilter');

        $query = Mockery::mock(Builder::class);

        $filter = new RangeFilter;
        $value = ['field' => 'payment', 'operator' => 'invalid_operator', 'min' => 10];

        $filter->apply($query, $value);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
