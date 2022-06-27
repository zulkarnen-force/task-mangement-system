<?php

namespace App\TaskNodeFilter\Filter;

interface Filter 
{
    public static function apply($builder, $value);
}

?>