<?php
namespace App\Http\Controllers\Admin\Services;

use App\ProductStatus;

class ProductStatusService
{
    private function getProductStatuses()
    {
        $productStatuses = ProductStatus::select('*')->get();
        return $productStatuses;
    }

    public function getProductStatusesToArray()
    {
        $productStatuses = $this->getProductStatuses()->toArray();
        $newProductStatuses = [];
        foreach ($productStatuses as $productStatus) {
            $id = $productStatus['id'];
            $newProductStatuses[$id] = $productStatus;
        }
        return $newProductStatuses;
    }

    public function getProductStatusesToJson()
    {
        return $this->getProductStatuses()->toJson();
    }
}