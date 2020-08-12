<?php
namespace App\Http\Controllers\Admin\Services;

use App\Category;
use App\Http\Controllers\Admin\Modules\Cookie\JsonCookie;
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
        $haveFindId = false;
        $categoryModel = new Category();
        $categories = $categoryModel;
        if (isset($this->findId)) {
            $haveFindId = true;
            $categories = $categories->where('id', $this->findId);
        }
        if (isset($this->orderByWithSortName, $this->orderByWithOrder)) {
            $haveSort = true;
            $categories = $categories->orderBy($this->orderByWithSortName, $this->orderByWithOrder);
        }
        if (isset($this->skipRecordNumber) && isset($this->takeRecordsNumber)) {
            $haveLimit = true;            
            $categories = $categories->skip($this->skipRecordNumber)
                ->take($this->takeRecordsNumber);            
        }
        if ($haveLimit == false && $haveSort == false && $haveFindId == false) {
            $categories = $categories->select('*');
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
        $pageCookieValue = JsonCookie::getValueInJsonCookie('page', 'category');
        if ($pageCookieValue != null) {
            $currentPage = $pageCookieValue;
        }

        $searchCookieValue = JsonCookie::getValueInJsonCookie('search', 'category');
        if ($searchCookieValue != null) {
            $search = $searchCookieValue;
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
                
        JsonCookie::createJsonCookie('sort', 'category', $sortName);
        JsonCookie::createJsonCookie('order', 'category', $orderValue);

        return response()->json([
            'page' => $currentPage,
            'priorities' => $prioritiesJson,
            'categories' => $categoriesJson
        ]);
    }

    public function getOptimizeCategoryRecords()
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
        JsonCookie::createJsonCookie('search', 'category', $search);
        return redirect()->route('category.index');        
    }
}
