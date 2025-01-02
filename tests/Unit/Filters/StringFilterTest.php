<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\StringFilter;
use Mockery;
use PHPUnit\Framework\TestCase;

class StringFilterTest extends TestCase
{
    public function test_apply_equals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('field', '=', 'John')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['operator' => '=', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_contains()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('field', 'like', '%John%')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['operator' => 'like', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_not_like()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('field', 'not like', '%John%')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['operator' => 'not like', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
