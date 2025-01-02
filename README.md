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

After installing the package, you need to register the service provider and facade in your config/app.php file:

```php
'providers' => [
    // Other Service Providers

    InovantiBank\AdvancedQueryFilters\Providers\FilterServiceProvider::class,
],

'aliases' => [
    // Other Facades

    'Filters' => InovantiBank\AdvancedQueryFilters\Facades\Filters::class,
],
```

## Usage

### Basic Usage

You can use the provided filters to apply various types of filters to your Eloquent queries. Here is an example of how to use the `FilterService`:

```php
use Filters;

// Define the filters
$filters = [
    'name' => ['operator' => 'contains', 'string' => 'John'],
    'age' => ['operator' => 'greater_than', 'number' => 25],
    'created_at' => ['operator' => 'before', 'date' => '2022-01-01'],
];

// Apply the filters to a query
$query = User::query();
$results = Filters::applyFilters($query, $filters)->get();

// Get the applied filters
$appliedFilters = Filters::getAppliedFilters();

return response()->json([
    'filters' => $appliedFilters,
    'default_sort' => ['field' => 'created_at', 'direction' => 'desc'],
    'pagination' => ['limit' => 10, 'offset' => 0],
    'data' => $results,
]);
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

## Example Filters

### Date Filter

```php
$filters = [
    'created_at' => ['operator' => 'between', 'from' => '2022-01-01', 'to' => '2022-12-31'],
];
```

### Numeric Filter

```php
$filters = [
    'age' => ['operator' => '>', 'number' => 25],
];
```

### String Filter

```php
$filters = [
    'name' => ['operator' => 'like', 'string' => 'John'],
];
```

## Getting Filter Operator Translations

You can use the `FilterService` to get the translations of the available filter operators. This is useful for displaying friendly operator names to the end users on the frontend.

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
