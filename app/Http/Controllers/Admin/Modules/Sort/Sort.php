<?php

namespace App\Http\Controllers\Admin\Modules\Sort;

class Sort
{
    private $sortName = 'id';

    private $orderValue = 'asc';

    public function __construct($sortName, $orderValue = 'asc')
    {
        $this->sortName = $sortName;
        $this->orderValue = $orderValue;
    }

    public function getSortName()
    {
        return $this->sortName;
    }

    public function getOrderValue()
    {   
        $orderValue = null;        
        if ($this->orderValue != 'desc' && $this->orderValue != 'asc') {
            $orderValue = 'asc';
        } else {
            $orderValue = $this->orderValue;
        }
        return $orderValue;
    }
}