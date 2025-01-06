<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\RelationFilter;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

class RelationFilterTest extends TestCase
{
    public function test_apply_equal()
    {

        $query = Mockery::mock(Builder::class);

        $query->shouldReceive('whereHas')
            ->with('relationName', Mockery::on(function ($closure) {
                $subQuery = Mockery::mock(Builder::class);
                $subQuery->shouldReceive('where')
                    ->with('related_field', '=', 'value')
                    ->once()
                    ->andReturnSelf();

                $closure($subQuery);

                return true;
            }))
            ->once()
            ->andReturnSelf();

        $filter = new RelationFilter;
        $value = [
            'relation' => 'relationName',
            'field' => 'field_name',
            'operator' => '=',
            'relatedColumn' => 'related_field',
            'value' => 'value',
        ];

        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_greater_than()
    {
        $query = Mockery::mock(Builder::class);

        $query->shouldReceive('whereHas')
            ->with('relationName', Mockery::on(function ($closure) {
                $subQuery = Mockery::mock(Builder::class);
                $subQuery->shouldReceive('where')
                    ->with('related_field', '>', 10)
                    ->once()
                    ->andReturnSelf();

                $closure($subQuery);

                return true;
            }))
            ->once()
            ->andReturnSelf();

        $filter = new RelationFilter;
        $value = [
            'relation' => 'relationName',
            'field' => 'field_name',
            'operator' => '>',
            'relatedColumn' => 'related_field',
            'value' => 10,
        ];

        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_missing_relation_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing 'relation' value for RelationFilter");

        $query = Mockery::mock(Builder::class);

        $filter = new RelationFilter;
        $value = [
            'field' => 'field_name',
            'operator' => '=',
            'relatedColumn' => 'related_field',
            'value' => 10,
        ];

        $filter->apply($query, $value);
    }

    public function test_apply_invalid_operator_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid operator for RelationFilter');

        $query = Mockery::mock(Builder::class);

        $filter = new RelationFilter;
        $value = [
            'relation' => 'relationName',
            'field' => 'field_name',
            'operator' => 'invalid',
            'relatedColumn' => 'related_field',
            'value' => 'value',
        ];

        $filter->apply($query, $value);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
