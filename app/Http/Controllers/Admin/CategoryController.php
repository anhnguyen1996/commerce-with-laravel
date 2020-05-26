<?php
namespace App\Http\Controllers\Admin;

use Exception;
use App\Category;
use App\Priority;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Modules\Pagination\Pagination;
use App\Http\Controllers\Admin\Modules\Sort\Sort;
use App\Http\Controllers\Admin\Services\CategoryService;
use App\Http\Controllers\Admin\Services\PriorityService;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $page
     * current page to display list records
     * @param string $searchName
     * search records with name value
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {
        $sortName = 'id';
        if (isset($_COOKIE['sort'])) {
            $sortName = $_COOKIE['sort'];
        }

        $orderValue = 'asc';
        if (isset($_COOKIE['order'])) {
            $orderValue = $_COOKIE['order'];
        }

        //To display lastest ID for user, so we should order by DESC with field ID 
        if ($sortName == 'id') {
            $orderValue = 'desc';
        }

        $search = null;

        if (isset($_COOKIE['search'])) {
            $search = $_COOKIE['search'];
        }

        $totalCategoryRecord = 0;
        if ($search == null) {
            $totalCategoryRecord = Category::count();
        } else {
            $totalCategoryRecord = Category::where('describes', 'like', "%$search%")->count();
        }
        $currentPage = $page;
        $pagination = Pagination::getPagination($currentPage, $totalCategoryRecord, 'admin/category');
        $pagination->setTotalRecordsPerPage(10);
        $pagination->save();

        $sortModule = new Sort($sortName, $orderValue);

        $categoryService = new CategoryService();
        if ($search != null) {
            $categoryService->setFindDescribes($search);
        }
        $categoryService->setOrder($sortModule->getSortName(), $sortModule->getOrderValue());
        $categoryService->setLimit($pagination->getStartRecordNumber(), $pagination->getTotalRecordsPerPage());
        $categories = $categoryService->getCategoriesToArray();

        $prioritiesService = new PriorityService();
        $priorities = $prioritiesService->getPriorityRecord();
        
        $contents = view('admin.category.list')->with([
            'search' => $search,            
            'categories' => $categories,
            'priorities' => $priorities,
            'pagination' => $pagination
        ]);

        $cookie = Cookie::make('page', $page, 3000);

        return response($contents)->withCookie($cookie);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prioritiesService  = new PriorityService();
        $priorities = $prioritiesService->getPriorityRecord();

        $categoryService = new CategoryService();
        $parentCategories = $categoryService->getParentCategoryRecords();                               
        $content = view('admin.category.create')->with([            
            'priorities' => $priorities,
            'parentCategories' => $parentCategories
        ]);

        return response($content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'unique:categories,name'
        ], [
            'category_name.unique' => 'Tên đường dẫn danh mục: ' . $request->category_name . ' đã tồn tại'
        ]);
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }
 
        $categoryModel = new Category();        
        $categoryModel->name = $request->category_name;
        $categoryModel->describes = $request->category_describes;
        $categoryModel->priority_id = $request->category_priority;
        $categoryModel->parent_id = $request->parent_category;
        $categoryService = new CategoryService();
        $categoryModel->parent_level = $categoryService->getParentLevel($request->parent_category);
        $categoryModel->visible = $request->category_visible;       
        if ($categoryModel->save()) {
            return redirect()->route('category.index');
        } else {
            return redirect()->route('category.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $priorities = Priority::all()->toArray();
        
        $editCategory = Category::find($id)->toArray();

        $categoryService =  new CategoryService();
        $parentCategories = $categoryService->getParentCategoryRecords();        

        $content = view('admin.category.edit')->with([            
            'priorities' => $priorities,
            'editCategory' => $editCategory,
            'parentCategories' => $parentCategories
        ]);

        return response($content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $updateCategory = Category::find($id);
        if ($updateCategory->name != $request->category_name) {
            $validator = Validator::make($request->all(), [
                'category_name' => 'unique:categories,name'
            ], [
                'category_name.unique' => 'Tên đường dẫn danh mục: ' . $request->category_name . ' đã tồn tại'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
        }
        $updateCategory->name = $request->category_name;
        $updateCategory->describes = $request->category_describes;
        $updateCategory->priority_id = $request->category_priority;        
        $updateCategory->visible = $request->category_visible;  
        $updateCategory->parent_id = $request->parent_category;
        if ($updateCategory->save()) {
            return redirect()->route('category.index');
        } else {
            return redirect()->route('category.edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCategory = Category::where('id', $id);
        if ($deleteCategory->delete()) {
            return redirect()->route('category.index');
        } else {
            throw new Exception('delete category error');
            return redirect()->route('category.index')->with(['error' => 'delete category error']);
        }
    }
}
