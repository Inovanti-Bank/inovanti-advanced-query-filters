<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\StringFilter;
use Illuminate\Database\Eloquent\Builder;

class StringFilterTest extends TestCase
{
    public function testApplyEquals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', '=', 'John')
              ->once()
              ->andReturnSelf();

        $filter = new StringFilter();
        $value = ['operator' => '=', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyContains()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', 'like', '%John%')
              ->once()
              ->andReturnSelf();

        $filter = new StringFilter();
        $value = ['operator' => 'like', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyNotLike()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', 'not like', '%John%')
              ->once()
              ->andReturnSelf();

        $filter = new StringFilter();
        $value = ['operator' => 'not like', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
