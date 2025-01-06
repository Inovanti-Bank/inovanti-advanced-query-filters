<?php

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Enums\SortDirectionEnum;

return [
    'default_filter' => FilterOperatorEnum::EQUAL->value,

    'supported_filters' => [
        'string' => [
            FilterOperatorEnum::EQUAL->value,
            FilterOperatorEnum::LIKE->value,
            FilterOperatorEnum::NOT_LIKE->value,
            FilterOperatorEnum::IN->value,
            FilterOperatorEnum::NOT_IN->value,
            FilterOperatorEnum::IS_NULL->value,
            FilterOperatorEnum::IS_NOT_NULL->value,
        ],
        'numeric' => [
            FilterOperatorEnum::EQUAL->value,
            FilterOperatorEnum::GREATER_THAN->value,
            FilterOperatorEnum::LESS_THAN->value,
            FilterOperatorEnum::GREATER_THAN_OR_EQUAL->value,
            FilterOperatorEnum::LESS_THAN_OR_EQUAL->value,
            FilterOperatorEnum::NOT_EQUAL->value,
            FilterOperatorEnum::BETWEEN->value,
            FilterOperatorEnum::IN->value,
            FilterOperatorEnum::NOT_IN->value,
            FilterOperatorEnum::IS_NULL->value,
            FilterOperatorEnum::IS_NOT_NULL->value,
        ],
        'date' => [
            FilterOperatorEnum::LESS_THAN->value,
            FilterOperatorEnum::GREATER_THAN->value,
            FilterOperatorEnum::BETWEEN->value,
            FilterOperatorEnum::IS_NULL->value,
            FilterOperatorEnum::IS_NOT_NULL->value,
        ],
    ],

    'default_sort_direction' => SortDirectionEnum::ASCENDING->value,

    'supported_sort_directions' => SortDirectionEnum::availableDirections(),
];
