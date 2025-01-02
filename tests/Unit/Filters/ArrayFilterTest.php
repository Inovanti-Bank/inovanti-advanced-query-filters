<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\ArrayFilter;
use Illuminate\Database\Eloquent\Builder;

class ArrayFilterTest extends TestCase
{
    public function testApplyIn()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereIn')
              ->with('field', [1, 2, 3])
              ->once()
              ->andReturnSelf();

        $filter = new ArrayFilter();
        $value = ['operator' => 'in', 'array' => [1, 2, 3]];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyNotIn()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotIn')
              ->with('field', [1, 2, 3])
              ->once()
              ->andReturnSelf();

        $filter = new ArrayFilter();
        $value = ['operator' => 'not in', 'array' => [1, 2, 3]];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
