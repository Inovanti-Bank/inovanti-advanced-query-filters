<?php

namespace Tests\Unit\Filters;

use Mockery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\ArrayFilter;

class ArrayFilterTest extends TestCase
{
    /**
     * Testa se o operador "in" é aplicado corretamente ao query builder.
     */
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

    /**
     * Testa se o operador "not in" é aplicado corretamente ao query builder.
     */
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

    public function test_apply_missing_array_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing or invalid 'array' value for ArrayFilter");

        $query = Mockery::mock(Builder::class);

        $filter = new ArrayFilter;
        $value = ['field' => 'id', 'operator' => 'in'];

        $filter->apply($query, $value);
    }

    public function test_apply_invalid_operator_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid operator for ArrayFilter');

        $query = Mockery::mock(Builder::class);

        $filter = new ArrayFilter;
        $value = ['field' => 'id', 'operator' => 'invalid_operator', 'array' => [1, 2, 3]];

        $filter->apply($query, $value);
    }
}
