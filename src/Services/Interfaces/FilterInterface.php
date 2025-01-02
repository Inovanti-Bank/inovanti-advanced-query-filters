<?php

namespace Inovanti\AdvancedQueryFilters\Services\Interfaces; 

interface FilterInterface 
{ 
    public function apply($query, $value);
}
