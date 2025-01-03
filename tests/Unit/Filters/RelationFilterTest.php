<?php

namespace Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\Filters\RelationFilter;
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
}
