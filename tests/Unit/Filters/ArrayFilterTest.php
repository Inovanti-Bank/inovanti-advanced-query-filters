<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\ArrayFilter;
use Mockery;
use PHPUnit\Framework\TestCase;

class ArrayFilterTest extends TestCase
{
    public function test_apply_in()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereIn')
            ->with('id', [1, 2, 3])
            ->once()
            ->andReturnSelf();

        $filter = new ArrayFilter;
        $value = ['field' => 'id', 'operator' => 'in', 'array' => [1, 2, 3]];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_not_in()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotIn')
            ->with('id', [1, 2, 3])
            ->once()
            ->andReturnSelf();

        $filter = new ArrayFilter;
        $value = ['field' => 'id', 'operator' => 'not in', 'array' => [1, 2, 3]];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
