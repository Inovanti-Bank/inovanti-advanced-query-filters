<?php

namespace Tests\Unit\Traits;

use Mockery;
use InvalidArgumentException;
use Tests\Mocks\SortableModel;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Builder;

class SortableTraitTest extends TestCase
{
    public function test_apply_sort_with_array()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('orderBy')
            ->with('name', 'asc')
            ->once()
            ->andReturnSelf();
        $query->shouldReceive('orderBy')
            ->with('age', 'desc')
            ->once()
            ->andReturnSelf();

        $model = new SortableModel;
        $sort = ['name' => 'asc', 'age' => 'desc'];

        $result = $model->scopeSort($query, $sort);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_sort_with_string()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('orderBy')
            ->with('name', 'asc')
            ->once()
            ->andReturnSelf();
        $query->shouldReceive('orderBy')
            ->with('age', 'desc')
            ->once()
            ->andReturnSelf();

        $model = new SortableModel;
        $sort = 'name,-age';

        $result = $model->scopeSort($query, $sort);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_invalid_sort_direction()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid sort direction: invalid. Allowed values are 'asc' or 'desc'.");

        $query = Mockery::mock(Builder::class);

        $model = new SortableModel;
        $sort = ['name' => 'invalid'];

        $model->scopeSort($query, $sort);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
