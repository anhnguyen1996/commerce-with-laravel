<?php

namespace App\Http\Controllers\Admin\Services;

use App\Category;
use App\Http\Controllers\Admin\Modules\Cookie\JsonCookie;
use App\Http\Controllers\Admin\Modules\Pagination\Pagination;
use App\Priority;
use App\Product;
use App\ProductImage;
use App\ProductImageType;
use App\ProductStatus;
use Illuminate\Support\Facades\Cookie;
use Exception;

class ProductService  extends ServiceAbstract
{
    private function getProducts()
    {
        $products = null;
        $haveSort = false;
        $haveLimit = false;
        $haveFindId = false;
        $haveFindName = false;
        $productModel = new Product();
        $products = $productModel;
        if (isset($this->findId)) {
            $haveFindId = true;
            $products = $products->where('id', $this->findId);
        }
        if(isset($this->findName)) {
            $haveFindName = true;            
            $products = $products->where('name', 'like' ,"%$this->findName%");
        }
        if (isset($this->orderByWithSortName, $this->orderByWithOrder)) {
            $haveSort = true;
            $products = $products->orderBy($this->orderByWithSortName, $this->orderByWithOrder);
        }
        if (isset($this->skipRecordNumber) && isset($this->takeRecordsNumber)) {
            $haveLimit = true;
            $products = $products->skip($this->skipRecordNumber)
                ->take($this->takeRecordsNumber);
        }
        if ($haveLimit == false && $haveSort == false && $haveFindId == false && $haveFindName == false) {
            $products = $products->select('*');
        }
        return $products->get();
    }

    public function getProductsToArray()
    {
        return $this->getProducts()->toArray();
    }

    public function getProductsToJson()
    {
        return $this->getProducts()->toJson();
    }

    /**
     * @param int $productId
     * @param string $productImageTypeName
     * This parameter is name field of product_image_types table in Database 
     * Example: 'main' or 'sub'
     * @return array
     */
    public function getImage($productId, $productImageTypeName = 'main')
    {

        $images = null;
        try {
            $productImageType = ProductImageType::select('id')->where('name', $productImageTypeName)->get();                        
            if ($productImageType->count() > 0) {
                $productImageTypeId = $productImageType[0]['id'];                
                $productImage = ProductImage::select('*')->where('product_id', $productId)->where('product_image_type_id', $productImageTypeId)->get()->toArray();  
                $countProductImage = count($productImage);
                if ($countProductImage > 0) {                    
                    if ($productImageTypeName == 'main') {                        
                        $images = $productImage[0];
                    } else if($productImageTypeName == 'sub') {
                        $images = $productImage;
                    }
                }
            }         
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }              
        return $images;
    }

    public function getSortList($sort = 'id', $order = 'asc', $search = null)
    {
        $sortName = $sort;        
        $orderValue = $order;

        if ($sort == 'id') {
            $order = 'desc';
        }

        $currentPage = 1;
        $pageCookieValue = JsonCookie::getValueInJsonCookie('page', 'product');
        if ($pageCookieValue != null) {
            $currentPage = $pageCookieValue;
        }

        $searchCookieValue = JsonCookie::getValueInJsonCookie('search', 'product');
        if ($searchCookieValue != null) {
            $search = $searchCookieValue;
        }

        $totalProductRecords = Product::count();        
        $pagination = Pagination::getPagination($currentPage, $totalProductRecords, 'admin/product');
        $pagination->setTotalRecordsPerPage(10);
        $pagination->save();

        if ($search != null) {
            $this->setFindName($search);
        }       
        $this->setOrder($sortName, $orderValue);
        $this->setLimit($pagination->getStartRecordNumber(), $pagination->getTotalRecordsPerPage());
        $productJson = $this->getProductsToJson();        

        $categoryJson = Category::select('id', 'name', 'describes')->get()->toJson();
        $productStatusJson = ProductStatus::select('id', 'name', 'describes')->get()->toJson();
        $priorityJson = Priority::select('id', 'name', 'describes')->get()->toJson();      
        
        JsonCookie::createJsonCookie('sort', 'product', $sortName);
        JsonCookie::createJsonCookie('order', 'product', $orderValue);
        
        return response()->json([
            'products' => $productJson,
            'categories' => $categoryJson,
            'statuses' => $productStatusJson,
            'priorities' => $priorityJson,
            'page' => $currentPage
        ]);
    }

    public function search($search = "")
    {        
        JsonCookie::createJsonCookie('search', 'product', $search);
        return redirect()->route('product.index');        
    }
}
