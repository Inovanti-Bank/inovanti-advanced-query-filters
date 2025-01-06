<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Exceptions\InvalidFilterQueryException;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NumericFilter;
use InovantiBank\AdvancedQueryFilters\Services\Filters\StringFilter;
use InovantiBank\AdvancedQueryFilters\Services\FilterService;
use Mockery;
use PHPUnit\Framework\TestCase;

class FilterServiceTest extends TestCase
{
    /**
     * Testa se os filtros são aplicados corretamente.
     */
    public function test_apply_filters()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('name', 'like', '%John%')
            ->once()
            ->andReturnSelf();

        $filterService = new FilterService([
            'name' => StringFilter::class,
        ]);

        $filters = [
            'name' => ['field' => 'name', 'operator' => 'like', 'string' => 'John'],
        ];

        $filterService->applyFilters($query, $filters);

        $appliedFilters = $filterService->getAppliedFilters();
        $this->assertCount(1, $appliedFilters);
        $this->assertEquals('name', $appliedFilters[0]['field']);
        $this->assertEquals('like', $appliedFilters[0]['operator']);
        $this->assertEquals([
            'field' => 'name',
            'operator' => 'like',
            'string' => 'John',
        ], $appliedFilters[0]['value']);
    }

    /**
     * Testa se uma exceção é lançada para filtros inválidos.
     */
    public function test_invalid_filter_throws_exception()
    {
        $this->expectException(InvalidFilterQueryException::class);
        $this->expectExceptionMessage('Requested filter(s) [invalid_field] are not allowed.');


        $query = Mockery::mock(Builder::class);

        $filterService = new FilterService([
            'name' => StringFilter::class,
        ]);

        $filters = [
            'invalid_field' => ['field' => 'invalid_field', 'operator' => '=', 'string' => 'John'],
        ];

        $filterService->applyFilters($query, $filters);
    }

    public function test_get_applied_filters()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('name', 'like', '%John%')
            ->once()
            ->andReturnSelf();

        $filterService = new FilterService([
            'name' => StringFilter::class,
        ]);

        $filters = [
            'name' => ['field' => 'name', 'operator' => 'like', 'string' => 'John'],
        ];

        $filterService->applyFilters($query, $filters);

        $appliedFilters = $filterService->getAppliedFilters();

        $this->assertCount(1, $appliedFilters);
        $this->assertEquals('name', $appliedFilters[0]['field']);
        $this->assertEquals('like', $appliedFilters[0]['operator']);
        $this->assertEquals([
            'field' => 'name',
            'operator' => 'like',
            'string' => 'John',
        ], $appliedFilters[0]['value']);
    }

    public function test_register_filter()
    {
        $filterService = new FilterService;

        $filterService->registerFilter('name', StringFilter::class);

        $filters = $filterService->getFilters();

        $this->assertArrayHasKey('name', $filters);
        $this->assertEquals(StringFilter::class, $filters['name']);
    }

    public function test_apply_multiple_filters()
    {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->with('name', 'like', '%John%')
            ->once()
            ->andReturnSelf();

        $query->shouldReceive('where')
            ->with('age', '>', 25)
            ->once()
            ->andReturnSelf();

        $filterService = new FilterService([
            'name' => StringFilter::class,
            'age' => NumericFilter::class,
        ]);

        $filters = [
            'name' => ['field' => 'name', 'operator' => 'like', 'string' => 'John'],
            'age' => ['field' => 'age', 'operator' => '>', 'number' => 25],
        ];

        $filterService->applyFilters($query, $filters);

        $appliedFilters = $filterService->getAppliedFilters();

        $this->assertCount(2, $appliedFilters);
        $this->assertEquals('name', $appliedFilters[0]['field']);
        $this->assertEquals('like', $appliedFilters[0]['operator']);
        $this->assertEquals([
            'field' => 'name',
            'operator' => 'like',
            'string' => 'John',
        ], $appliedFilters[0]['value']);

        $this->assertEquals('age', $appliedFilters[1]['field']);
        $this->assertEquals('>', $appliedFilters[1]['operator']);
        $this->assertEquals([
            'field' => 'age',
            'operator' => '>',
            'number' => 25,
        ], $appliedFilters[1]['value']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
