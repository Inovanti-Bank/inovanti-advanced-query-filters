<?php

namespace Tests\Mocks;

use Illuminate\Database\Eloquent\Model;
use InovantiBank\AdvancedQueryFilters\Services\Traits\FilterableTrait;

class FilterableModel extends Model
{
    use FilterableTrait;
}
