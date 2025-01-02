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
            ->with('relation', Mockery::on(function ($callback) {
                $relatedQuery = Mockery::mock(Builder::class);
                $relatedQuery->shouldReceive('where')
                    ->with('related_field', '=', 'value')
                    ->once()
                    ->andReturnSelf();
                $callback($relatedQuery);

                return true;
            }))
            ->once()
            ->andReturnSelf();

        $filter = new RelationFilter;
        $value = ['operator' => '=', 'value' => 'value'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
