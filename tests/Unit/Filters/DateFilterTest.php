<?php

namespace Tests\Unit\Filters;

use Mockery;
use PHPUnit\Framework\TestCase;
use InovantiBank\AdvancedQueryFilters\Services\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class DateFilterTest extends TestCase
{
    public function testApplyEquals()
    {
        $query = Mockery::mock(Builder::class);
        $carbonDate = Carbon::parse('2022-01-01');

        $query->shouldReceive('whereDate')
              ->with('field', $carbonDate->toDateString())
              ->once()
              ->andReturnSelf();

        $filter = new DateFilter();
        $value = ['operator' => '=', 'date' => '2022-01-01'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyBefore()
    {
        $query = Mockery::mock(Builder::class);
        $carbonDate = Carbon::parse('2022-01-01');

        $query->shouldReceive('whereDate')
              ->with('field', '<', $carbonDate->toDateString())
              ->once()
              ->andReturnSelf();

        $filter = new DateFilter();
        $value = ['operator' => '<', 'date' => '2022-01-01'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplyBetween()
    {
        $query = Mockery::mock(Builder::class);
        $carbonDateFrom = Carbon::parse('2022-01-01');
        $carbonDateTo = Carbon::parse('2022-12-31');

        $query->shouldReceive('whereBetween')
              ->with('field', [$carbonDateFrom->toDateString(), $carbonDateTo->toDateString()])
              ->once()
              ->andReturnSelf();

        $filter = new DateFilter();
        $value = ['operator' => 'between', 'from' => '2022-01-01', 'to' => '2022-12-31'];
        $result = $filter->apply($query, $value);

        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
