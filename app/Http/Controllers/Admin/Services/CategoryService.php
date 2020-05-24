<?php

namespace App\Http\Controllers\Admin\Services;

use App\Category;
use App\Http\Controllers\Admin\Modules\Pagination\Pagination;
use App\Priority;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CategoryService extends ServiceAbstract
{
    private function getCategory()
    {
        $categories = null;
        $haveSort = false;
        $haveLimit = false;
        $categoryModel = new Category();
        if (isset($this->orderByWithSortName, $this->orderByWithOrder)) {
            $haveSort = true;
            $categories = $categoryModel->orderBy($this->orderByWithSortName, $this->orderByWithOrder);
        }
        if (isset($this->skipRecordNumber) && isset($this->takeRecordsNumber)) {
            $haveLimit = true;
            if ($haveSort == true) {
                $categories = $categories->skip($this->skipRecordNumber)
                    ->take($this->takeRecordsNumber);
            } else {
                $categories = $categoryModel->skip($this->skipRecordNumber)
                    ->take($this->takeRecordsNumber);
            }
        }

        if ($haveLimit == false && $haveSort == false) {
            $categories = $categoryModel->select('*');
        }
        return $categories->get();
    }

    public function getCategoryToArray()
    {
        return $this->getCategory()->toArray();
    }

    public function getCategoryToJson()
    {
        return $this->getCategory()->toJson();
    }

    private function getCategories()
    {
        $query = "SELECT c1.id, c1.describes, c1.name , c1.parent_id, c2.describes as parent_describes FROM categories c1 LEFT JOIN categories c2 ON c1.parent_id = c2.id";
        $categories = DB::table('categories as c1');
        if (isset($this->findId)) {
            $categories = $categories->where('c1.id', $this->findId);
        }
        if(isset($this->findDescribes)) {
            $categories = $categories->where('c1.describes', 'like', "%$this->findDescribes%");
        }        
        $categories = $categories->leftJoin('categories as c2', 'c1.parent_id', '=', 'c2.id')
            ->select(['c1.*', 'c2.describes as parent_describes']);
        if (isset($this->orderByWithSortName, $this->orderByWithOrder)) {
            $categories = $categories->orderBy($this->orderByWithSortName, $this->orderByWithOrder);
        }
        if (isset($this->skipRecordNumber) && isset($this->takeRecordsNumber)) {
            $categories = $categories
                ->skip($this->skipRecordNumber)
                ->take($this->takeRecordsNumber);
        }        
        $categories = $categories->get();
                
        return $categories;
    }

    public function getCategoriesToArray()
    {
        return $this->getCategories()->toArray();
    }

    public function getCategoriesToJson()
    {
        return $this->getCategories()->toJson();
    }

    /**
     * This method is used to get Json from Ajax request when user change Sort Options on UI 
     * @param string $sort
     * field name in your database in order to sort records 
     * @param string $order
     * order value to sort records
     * @return \Illuminate\Http\Response
     */
    public function getSortList($sort = 'id', $order = 'asc', $search = null)
    {
        $sortName = $sort;
        $orderValue = $order;

        //To display lastest ID for user, so we should order by desc with field ID 
        if ($sort == 'id') {
            $order = 'desc';
        }

        $currentPage = 1;
        if (isset($_COOKIE['page'])) {
            $currentPage = $_COOKIE['page'];
        }

        if (isset($_COOKIE['search'])) {
            $search = $_COOKIE['search'];
        }

        $totalCategoryRecord = Category::count();
        $pagination = Pagination::getPagination($currentPage, $totalCategoryRecord, 'admin/category');
        $pagination->setTotalRecordsPerPage(10);
        $pagination->save();

        $categoryService = new CategoryService();
        if ($search != null) {
            $categoryService->setFindDescribes($search);
        }
        $categoryService->setOrder($sortName, $orderValue);
        $categoryService->setLimit($pagination->getStartRecordNumber(), $pagination->getTotalRecordsPerPage());
        $categoriesJson = $categoryService->getCategoriesToJson();
        $prioritiesJson = Priority::all()->toJson();
        
        $sortCookie = Cookie::make('sort', $sortName, 3000);
        $orderCookie = Cookie::make('order', $orderValue, 3000);

        return response()->json([
            'page' => $currentPage,
            'priorities' => $prioritiesJson,
            'categories' => $categoriesJson
        ])->cookie($sortCookie)->cookie($orderCookie);
    }

    public function getParentCategoryRecords()
    {
        $categories = Category::select('id', 'describes', 'name')->get()->toArray();
        $newCategories = [];
        foreach ($categories as $key => $value) {
            $newCategories[$value['id']] = $value;
        }
        return $newCategories;
    }

    public function getParentLevel($parentId)
    {
        $level = 0;
        if ($parentId == 0) {
            $level = 0;
        } else {
            $category = Category::select('parent_level')->where('id', $parentId)->get()->toArray();            
            $level = $category[0]['parent_level'];
            $level++;
        }
        return $level;
    }

    public function search($search = "")
    {        
        $searchCookie = Cookie::make('search', $search, 3000);
        return redirect()->route('category.index')->cookie($searchCookie);        
    }
}
