<?php

use Inovanti\AdvancedQueryFilters\Enums\FilterOperator;
use Inovanti\AdvancedQueryFilters\Enums\SortDirection;

return [
    'default_filter' => FilterOperator::EQUAL->value,
    'supported_filters' => [
        'string' => [
            FilterOperator::EQUAL->value,
            FilterOperator::LIKE->value,
            FilterOperator::NOT_LIKE->value,
        ],
        'numeric' => [
            FilterOperator::EQUAL->value,
            FilterOperator::GREATER_THAN->value,
            FilterOperator::LESS_THAN->value,
            FilterOperator::GREATER_THAN_OR_EQUAL->value,
            FilterOperator::LESS_THAN_OR_EQUAL->value,
            FilterOperator::NOT_EQUAL->value,
            FilterOperator::BETWEEN->value,
        ],
        'date' => [
            FilterOperator::LESS_THAN->value,
            FilterOperator::GREATER_THAN->value,
            FilterOperator::BETWEEN->value,
        ],
    ],
    'default_sort_direction' => SortDirection::ASCENDING->value,
    'supported_sort_directions' => [
        SortDirection::ASCENDING->value,
        SortDirection::DESCENDING->value,
    ],
];
