# Inovanti Advanced Query Filters

[![Latest Stable Version](https://poser.pugx.org/inovanti-bank/inovanti-advanced-query-filters/v)](//packagist.org/packages/inovanti-bank/inovanti-advanced-query-filters)
[![Total Downloads](https://poser.pugx.org/inovanti-bank/inovanti-advanced-query-filters/downloads)](//packagist.org/packages/inovanti-bank/inovanti-advanced-query-filters)
[![License](https://poser.pugx.org/inovanti-bank/inovanti-advanced-query-filters/license)](//packagist.org/packages/inovanti-bank/inovanti-advanced-query-filters)

Inovanti Advanced Query Filters is a Laravel package that provides an easy and flexible way to apply advanced query filters to your Eloquent queries. It supports various types of filters including date, numeric, string, array, boolean, range, and relation filters.

## Installation

To install the package, you can use Composer:

```bash
composer require inovanti-bank/inovanti-advanced-query-filters
```

## Usage

### Basic Usage

You can use the provided filters to apply various types of filters to your Eloquent queries. Here is an example of how to use the `FilterService`:

```php
try {
    $results = User::query()->get();

    return response()->json([
        'filters' => request()->get('filters', []),
        'default_sort' => ['field' => 'created_at', 'direction' => 'desc'],
        'pagination' => ['limit' => 10, 'offset' => 0],
        'data' => $results,
    ]);
    } catch (Exception $e) {
    return response()->json(['error' => $e->getMessage()], 400);
}
```

## Configuring Filters in Models

You can configure the filters directly in your Eloquent models. This way, the filters will always be available whenever a query is executed on the model.

### Example

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InovantiBank\AdvancedQueryFilters\Services\FilterService;
use InovantiBank\AdvancedQueryFilters\Services\Filters\StringFilter;
use InovantiBank\AdvancedQueryFilters\Services\Filters\NumericFilter;
use InovantiBank\AdvancedQueryFilters\Services\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Exception;

class User extends Model
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('filters', function (Builder $query) {

            $filters = request()->get('filters', []);

            if (empty($filters) && request()->isJson()) {
                $filters = request()->input('filters', []);
            }

            if (! empty($filters)) {

                $formattedFilters = [];
                foreach ($filters as $filter) {
                    $formattedFilters[$filter['field']] = $filter;
                }

                $filterService = new FilterService([
                    'name' => StringFilter::class,
                    'age' => NumericFilter::class,
                    'status' => ArrayFilter::class,
                    'email' => StringFilter::class,
                    'created_at' => DateFilter::class,
                ]);

                if (request()->has('filters')) {
                    try {
                        $filterService->applyFilters($query, $formattedFilters);
                    } catch (Exception $e) {
                        Log::error('Erro ao aplicar filtros: '.$e->getMessage());
                    }
                }
            }
        });
    }
}
```

## Example JSON for Filters

Here are examples of the JSON structure that the frontend should send in the body of the request to apply the filters correctly:

### Date Filter

```json
{
  "filters": [
    {
      "field": "created_at",
      "operator": "between",
      "from": "2022-01-01",
      "to": "2022-12-31"
    },
    {
      "field": "created_at",
      "operator": "<",
      "date": "2022-01-01"
    }
  ]
}
```

### Numeric Filter

```json
{
  "filters": [
    {
      "field": "age",
      "operator": ">",
      "number": 25
    },
    {
      "field": "salary",
      "operator": "between",
      "from": 30000,
      "to": 60000
    }
  ]
}
```

### String Filter

```json
{
  "filters": [
    {
      "field": "name",
      "operator": "like",
      "string": "John"
    },
    {
      "field": "email",
      "operator": "not like",
      "string": "@example.com"
    }
  ]
}
```

### Array Filter

```json
{
  "filters": [
    {
      "field": "status",
      "operator": "in",
      "array": ["active", "pending"]
    },
    {
      "field": "tags",
      "operator": "not_in",
      "array": ["spam", "banned"]
    }
  ]
}
```

### Boolean Filter

```json
{
  "filters": [
    {
      "field": "is_active",
      "operator": "=",
      "boolean": true
    },
    {
      "field": "is_verified",
      "operator": "!=",
      "boolean": false
    }
  ]
}
```

### Null Filter

```json
{
  "filters": [
    {
      "field": "deleted_at",
      "operator": "is_null"
    },
    {
      "field": "deleted_at",
      "operator": "is_not_null"
    }
  ]
}
```

### Range Filter

```json
{
  "filters": [
    {
      "field": "price",
      "operator": "between",
      "min": 100,
      "max": 500
    }
  ]
}
```

### Relation Filter

```json
{
  "filters": [
    {
      "relation": "orders",
      "field": "orders_total",
      "operator": ">",
      "relatedColumn": "total",
      "value": 100
    }
  ]
}
```

## Available Filters

The package supports the following types of filters:

- **DateFilter**: Filters based on dates.
- **NumericFilter**: Filters based on numeric values.
- **StringFilter**: Filters based on string values.
- **ArrayFilter**: Filters based on arrays.
- **BooleanFilter**: Filters based on boolean values.
- **NullFilter**: Filters based on null values.
- **RangeFilter**: Filters based on numeric ranges.
- **RelationFilter**: Filters based on relationships between models.

## Getting Filter Operator Translations

You can use the FilterService to get the translations of the available filter operators. This is useful for displaying friendly operator names to the end users on the frontend.

### Example

```php
use Filters;

$translations = Filters::getFilterOperatorsTranslations();

return response()->json($translations);
```

### Custom Filters

You can also create custom filters by implementing the FilterInterface. Here is an example:

```php
namespace App\Filters;

use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CustomFilter implements FilterInterface
{
    public function apply(Builder $query, $value)
    {
        // Custom filter logic
    }
}
```

## Registering Custom Filters

```php
Filters::registerFilter('custom_field', \App\Filters\CustomFilter::class);
```

_All types of operators are available in `FilterOperatorEnum`_

```php
case DYNAMIC = '';
case EQUAL = '=';
case LESS_THAN = '<';
case GREATER_THAN = '>';
case LESS_THAN_OR_EQUAL = '<=';
case GREATER_THAN_OR_EQUAL = '>=';
case NOT_EQUAL = '<>';
case LIKE = 'like';
case NOT_LIKE = 'not like';
case IN = 'in';
case NOT_IN = 'not in';
case BETWEEN = 'between';
```

## Registering Custom Filters

Once you have created a custom filter, you can register it with the `FilterService`:

```php
Filters::registerFilter('custom_field', \App\Filters\CustomFilter::class);
```

## Testing

The package comes with unit and feature tests to ensure everything works as expected. You can run the tests using PHPUnit:

```bash
vendor/bin/phpunit
```

### To run unit tests:

```bash
vendor/bin/phpunit tests/Unit
```

### To run feature tests:

```bash
vendor/bin/phpunit tests/Feature
```

## Contribution

Feel free to contribute to this package by submitting pull requests or opening issues. We appreciate your feedback and help in improving the package.

- Fork the repository.
- Create a new branch.
- Submit a pull request.

## License

This package is open-source software licensed under the [MIT license](https://github.com/Inovanti-Bank/rsa-validator/tree/production?tab=MIT-1-ov-file).

---

Thank you for using Inovanti Advanced Query Filters! If you have any questions or need further assistance, please don't hesitate to reach out.
