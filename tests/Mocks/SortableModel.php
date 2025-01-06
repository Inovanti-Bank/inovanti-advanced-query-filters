<?php

namespace Tests\Mocks;

use Illuminate\Database\Eloquent\Model;
use InovantiBank\AdvancedQueryFilters\Services\Traits\SortableTrait;

class SortableModel extends Model
{
    use SortableTrait;
}
