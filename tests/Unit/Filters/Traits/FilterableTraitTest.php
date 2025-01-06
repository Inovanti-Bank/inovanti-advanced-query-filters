<?php

namespace Tests\Unit\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\FilterableModel;

class FilterableTraitTest extends TestCase
{
    public function test_apply_generic_filter_with_operator_and_value()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('status', '=', 'active')
            ->once()
            ->andReturnSelf();

        $model = new FilterableModel;
        $filters = ['status' => ['operator' => '=', 'value' => 'active']];

        $result = $model->scopeFilter($query, $filters);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_apply_generic_filter_with_default_operator()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('status', '=', 'active')
            ->once()
            ->andReturnSelf();

        $model = new FilterableModel;
        $filters = ['status' => 'active'];

        $result = $model->scopeFilter($query, $filters);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
