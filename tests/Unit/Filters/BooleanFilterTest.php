<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\BooleanFilter;
use Mockery;
use PHPUnit\Framework\TestCase;

class BooleanFilterTest extends TestCase
{
    public function test_apply_equals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('is_active', '=', true)
            ->once()
            ->andReturnSelf();

        $filter = new BooleanFilter;
        $value = ['field' => 'is_active', 'operator' => '=', 'boolean' => true];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_not_equals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('is_active', '<>', true)
            ->once()
            ->andReturnSelf();

        $filter = new BooleanFilter;
        $value = ['field' => 'is_active', 'operator' => '<>', 'boolean' => true];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
