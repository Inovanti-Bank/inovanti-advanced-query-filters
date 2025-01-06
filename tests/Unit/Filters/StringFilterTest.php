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
            ->with('name', '=', 'John')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => '=', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_contains()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('name', 'like', '%John%')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => 'like', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_not_like()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('name', 'not like', '%John%')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => 'not like', 'string' => 'John'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_in()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereIn')
            ->with('name', ['John', 'Doe'])
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => 'in', 'array' => ['John', 'Doe']];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_not_in()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotIn')
            ->with('name', ['John', 'Doe'])
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => 'not in', 'array' => ['John', 'Doe']];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_is_null()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNull')
            ->with('name')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => 'is null'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_is_not_null()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNotNull')
            ->with('name')
            ->once()
            ->andReturnSelf();

        $filter = new StringFilter;
        $value = ['field' => 'name', 'operator' => 'is not null'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
