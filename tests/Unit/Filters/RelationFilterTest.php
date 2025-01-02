<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\RelationFilter;
use Illuminate\Database\Eloquent\Builder;

class RelationFilterTest extends TestCase
{
    public function testApplyEqual()
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

        $filter = new RelationFilter();
        $value = ['operator' => '=', 'value' => 'value'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }
}
