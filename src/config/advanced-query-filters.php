<?php

use InovantiBank\AdvancedQueryFilters\Enums\SortDirection;

return [
    'default_filter' => FilterOperatorEnum::EQUAL->value,
    'supported_filters' => [
        'string' => [
            FilterOperatorEnum::EQUAL->value,
            FilterOperatorEnum::LIKE->value,
            FilterOperatorEnum::NOT_LIKE->value,
        ],
        'numeric' => [
            FilterOperatorEnum::EQUAL->value,
            FilterOperatorEnum::GREATER_THAN->value,
            FilterOperatorEnum::LESS_THAN->value,
            FilterOperatorEnum::GREATER_THAN_OR_EQUAL->value,
            FilterOperatorEnum::LESS_THAN_OR_EQUAL->value,
            FilterOperatorEnum::NOT_EQUAL->value,
            FilterOperatorEnum::BETWEEN->value,
        ],
        'date' => [
            FilterOperatorEnum::LESS_THAN->value,
            FilterOperatorEnum::GREATER_THAN->value,
            FilterOperatorEnum::BETWEEN->value,
        ],
    ],
    'default_sort_direction' => SortDirection::ASCENDING->value,
    'supported_sort_directions' => [
        SortDirection::ASCENDING->value,
        SortDirection::DESCENDING->value,
    ],
];
