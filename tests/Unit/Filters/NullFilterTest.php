<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NullFilter;
use Mockery;
use PHPUnit\Framework\TestCase;

class NullFilterTest extends TestCase
{
    public function test_apply_null()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNull')
            ->with('field')
            ->once()
            ->andReturnSelf();

        $filter = new NullFilter;
        $value = ['operator' => '=', 'boolean' => true];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_not_null()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotNull')
            ->with('field')
            ->once()
            ->andReturnSelf();

        $filter = new NullFilter;
        $value = ['operator' => '=', 'boolean' => false];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
