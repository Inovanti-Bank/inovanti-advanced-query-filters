<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NumericFilter;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

class NumericFilterTest extends TestCase
{
    public function test_apply_equals()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('age', '=', 10)
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => '=', 'number' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_greater_than()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('age', '>', 10)
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => '>', 'number' => 10];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_between(): void
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereBetween')
            ->with('age', [10, 20])
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => 'between', 'min' => 10, 'max' => 20];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_missing_number_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing 'number' value for operator");

        $query = Mockery::mock(Builder::class);

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => '='];

        $filter->apply($query, $value);
    }

    public function test_apply_invalid_operator_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid operator for NumericFilter');

        $query = Mockery::mock(Builder::class);

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => 'invalid', 'number' => 10];

        $filter->apply($query, $value);
    }

    public function test_apply_in()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereIn')
            ->with('age', [20, 30, 40])
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => 'in', 'array' => [20, 30, 40]];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_is_null()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNull')
            ->with('age')
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => 'is null'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_is_not_null()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotNull')
            ->with('age')
            ->once()
            ->andReturnSelf();

        $filter = new NumericFilter;
        $value = ['field' => 'age', 'operator' => 'is not null'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
