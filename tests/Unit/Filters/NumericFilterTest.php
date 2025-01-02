<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NumericFilter;
use Mockery;
use PHPUnit\Framework\TestCase;

class NumericFilterTest extends TestCase
{
    public function test_apply_equals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('field', '=', 10)
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['operator' => '=', 'number' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_greater_than()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('field', '>', 10)
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['operator' => '>', 'number' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
