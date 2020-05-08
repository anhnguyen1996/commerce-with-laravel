<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Category;
use App\Priority;
use App\Http\Controllers\Admin\Header\Breadcrumb;
use App\Http\Controllers\Admin\Header\HeaderPanel;
use App\Http\Controllers\ReturnData;
use App\Http\Controllers\Admin\Pagination\Pagination;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *     
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1, $searchName = null)
    {
        /**
         * @var \App\Category $categoryModel
         */

        $orderByWithSortName = 'id';
        $orderByWithSortValue = 'desc';
        if (isset($_COOKIE['sort'])) {
            $orderByWithSortName = $_COOKIE['sort'];
            $map = ['name' => 'describes', 'link' => 'name', 'id' => 'id'];
            $orderByWithSortName = $map[$orderByWithSortName];
            $orderByWithSortValue = 'asc';
        }

        $priorities = Priority::select('*')->get()->toArray();
        $newPriorities = [];
        foreach ($priorities as $priority) {
            $id = $priority['id'];
            $newPriorities[$id] = $priority;
        }

        $totalCategoryRecord = Category::count();        
        $currentPage = $page;
        $pagination = new Pagination($currentPage, $totalCategoryRecord, 'admin/category');
        $pagination->setTotalRecordsPerPage(5);
        $pagination->save();

        $categories = Category::skip($pagination->getStartRecordNumber())
            ->take($pagination->getTotalRecordsPerPage())->orderBy($orderByWithSortName, $orderByWithSortValue)->get()->toArray();            

        return view('admin.master')->with([
            'content' => 'category.list',
            'categories' => $categories,
            'priorities' => $newPriorities,
            'pagination' => $pagination
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorityModel = new Priority();
        $priorities = $priorityModel->all()->toArray();
        return view('admin.master')->with([
            'content' => 'category.create',
            'priorities' => $priorities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\CategoryRequest  $request
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
        /**
         * @var \App\Category $categoryModel
         */
        $categoryModel = new Category();
        $categoryModel->name = $request->category_name;
        $categoryModel->describes = $request->category_describes;
        $categoryModel->priority_id = $request->category_priority;
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
        $priorityModel = new Priority();
        $priorities = $priorityModel->all()->toArray();

        $categoryModel = new Category();
        $editCategory = $categoryModel->find($id);

        return view('admin.master')->with([
            'content' => 'category.edit',
            'priorities' => $priorities,
            'editCategory' => $editCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
        /**
         * @var \App\Category $categoryModel
         */
        $categoryModel = new Category();
        $deleteCategory = $categoryModel->where('id', $id);
        if ($deleteCategory->delete()) {
            return redirect()->route('category.index');
        } else {
            throw new Exception('delete category error');
            return redirect()->route('category.index')->with(['error' => 'delete category error']);
        }
    }

    public function getSortList()
    {
        $sortValue = 'name';
        if (isset($_GET['sort'])) {
            $sortValue = $_GET['sort'];
        }
        $categories = Category::orderBy($sortValue, 'asc')->get()->toJson();
        $priorities = Priority::all()->toJson();
        return response()->json([
            'priorities' => $priorities,
            'categories' => $categories
        ]);
    }
}
