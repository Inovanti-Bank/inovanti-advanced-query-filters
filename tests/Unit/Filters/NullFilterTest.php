<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NullFilter;
use Illuminate\Database\Eloquent\Builder;

class NullFilterTest extends TestCase
{
    public function testApplyNull()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNull')
              ->with('field')
              ->once()
              ->andReturnSelf();

        $filter = new NullFilter();
        $value = ['operator' => '=', 'boolean' => true];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyNotNull()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotNull')
              ->with('field')
              ->once()
              ->andReturnSelf();

        $filter = new NullFilter();
        $value = ['operator' => '=', 'boolean' => false];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
