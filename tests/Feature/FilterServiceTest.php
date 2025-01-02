<?php

namespace Tests\Feature;

use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Services\FilterService;
use InovantiBank\AdvancedQueryFilters\Services\Filters\StringFilter;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NumericFilter;
use InovantiBank\AdvancedQueryFilters\Exceptions\InvalidFilterQueryException;

class FilterServiceTest extends TestCase
{
    public function testApplyFilters()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', 'like', '%John%')
              ->once()
              ->andReturnSelf();

        $filterService = new FilterService([
            'name' => StringFilter::class,
        ]);

        $filters = [
            'name' => ['operator' => 'like', 'string' => 'John'],
        ];

        $filterService->applyFilters($query, $filters);

        $appliedFilters = $filterService->getAppliedFilters();
        $this->assertCount(1, $appliedFilters);
        $this->assertEquals('name', $appliedFilters[0]['field']);
        $this->assertEquals('like', $appliedFilters[0]['operator']);
        $this->assertEquals(['operator' => 'like', 'string' => 'John'], $appliedFilters[0]['value']);
    }

    public function testInvalidFilterThrowsException()
    {
        $this->expectException(InvalidFilterQueryException::class);

        $query = Mockery::mock(Builder::class);

        $filterService = new FilterService([
            'name' => \InovantiBank\AdvancedQueryFilters\Services\Filters\StringFilter::class,
        ]);

        $filters = [
            'invalid_field' => ['operator' => '=', 'string' => 'John'],
        ];

        $filterService->applyFilters($query, $filters);
    }

    public function testGetAppliedFilters()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', 'like', '%John%')
              ->once()
              ->andReturnSelf();

        $filterService = new FilterService([
            'name' => StringFilter::class,
        ]);

        $filters = [
            'name' => ['operator' => 'like', 'string' => 'John'],
        ];

        $filterService->applyFilters($query, $filters);

        $appliedFilters = $filterService->getAppliedFilters();

        $this->assertCount(1, $appliedFilters);
        $this->assertEquals('name', $appliedFilters[0]['field']);
        $this->assertEquals('like', $appliedFilters[0]['operator']);
        $this->assertEquals(['operator' => 'like', 'string' => 'John'], $appliedFilters[0]['value']);
    }

    public function testRegisterFilter()
    {
        $filterService = new FilterService();

        $filterService->registerFilter('name', StringFilter::class);

        $filters = $filterService->getFilters();

        $this->assertArrayHasKey('name', $filters);
        $this->assertEquals(StringFilter::class, $filters['name']);
    }

    public function testApplyMultipleFilters()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
              ->with('field', 'like', '%John%')
              ->once()
              ->andReturnSelf();

        $query->shouldReceive('where')
              ->with('field', '>', 25)
              ->once()
              ->andReturnSelf();

        $filterService = new FilterService([
            'name' => StringFilter::class,
            'age' => NumericFilter::class,
        ]);

        $filters = [
            'name' => ['operator' => 'like', 'string' => 'John'],
            'age' => ['operator' => '>', 'number' => 25],
        ];

        $filterService->applyFilters($query, $filters);

        $appliedFilters = $filterService->getAppliedFilters();

        $this->assertCount(2, $appliedFilters);
        $this->assertEquals('name', $appliedFilters[0]['field']);
        $this->assertEquals('like', $appliedFilters[0]['operator']);
        $this->assertEquals(['operator' => 'like', 'string' => 'John'], $appliedFilters[0]['value']);

        $this->assertEquals('age', $appliedFilters[1]['field']);
        $this->assertEquals('>', $appliedFilters[1]['operator']);
        $this->assertEquals(['operator' => '>', 'number' => 25], $appliedFilters[1]['value']);
    }
}
