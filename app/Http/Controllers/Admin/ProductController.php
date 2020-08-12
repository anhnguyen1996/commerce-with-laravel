<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Modules\Cookie\JsonCookie;
use App\Http\Controllers\Admin\Modules\Images\ProductImage as ImagesProductImage;
use Exception;
use App\Product;
use App\ProductImage;
use App\ProductStatus;
use App\Http\Controllers\Admin\Modules\Pagination\Pagination;
use App\Http\Controllers\Admin\Modules\Sort\Sort;
use App\Http\Controllers\Admin\Services\CategoryService;
use App\Http\Controllers\Admin\Services\PriorityService;
use App\Http\Controllers\Admin\Services\ProductService;
use App\Http\Controllers\Admin\Services\ProductStatusService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Modules\Picture\ProductPicture;
use App\Http\Requests\ProductRequest;
use App\ProductImageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {
        $sortName = 'id';
        $sortCookieValue = JsonCookie::getValueInJsonCookie('sort', 'product');
        if ($sortCookieValue != null) {
            $sortName = $sortCookieValue;
        }

        $orderValue = 'asc';
        $orderCookieValue = JsonCookie::getValueInJsonCookie('order', 'product');
        if ($orderCookieValue != null) {
            $orderValue = $orderCookieValue;
        }

        //To display lastest ID for user, so we should order by DESC with field ID 
        if ($sortName == 'id') {
            $orderValue = 'desc';
        }

        $search = null;
        $searchCookieValue = JsonCookie::getValueInJsonCookie('search', 'product');
        if ($searchCookieValue != null) {
            $search = $searchCookieValue;
        }

        $totalProductRecord = 0;
        if ($search == null) {
            $totalProductRecord = Product::count();
        } else {
            $totalProductRecord = Product::where('name', 'like', "%$search%")->count();
        }
        $currentPage = $page;
        $pagination = Pagination::getPagination($currentPage, $totalProductRecord, 'admin/product');
        $pagination->setTotalRecordsPerPage(10);
        $pagination->save();

        $sortModule = new Sort($sortName, $orderValue);

        $categoryService = new CategoryService();
        $categories = $categoryService->getOptimizeCategoryRecords();

        $productService = new ProductService();
        if ($search != null) {
            $productService->setFindName($search);
        }
        $productService->setOrder($sortModule->getSortName(), $sortModule->getOrderValue());
        $productService->setLimit($pagination->getStartRecordNumber(), $pagination->getTotalRecordsPerPage());
        $products = $productService->getProductsToArray();

        $priorityService = new PriorityService();
        $priorities = $priorityService->getPrioritiesToArray();

        $productStatusService = new ProductStatusService();
        $productStatuses = $productStatusService->getProductStatusesToArray();

        $content = view('admin.product.list')->with([            
            'search' => $search,
            'products' => $products,
            'categories' => $categories,
            'priorities' => $priorities,
            'productStatuses' => $productStatuses,
            'pagination' => $pagination
        ]);

        JsonCookie::createJsonCookie('page', 'product', $page);

        return response($content);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryService = new CategoryService();
        $categories = $categoryService->getCategoryToArray();

        $priorityService = new PriorityService();
        $priorities = $priorityService->getPrioritiesToArray();

        $productStatusModel = new ProductStatus();
        $productStatuses = $productStatusModel->get()->toArray();

        $content = view('admin.product.create')->with([
            'categories' => $categories,
            'priorities' => $priorities,
            'productStatuses' => $productStatuses
        ]);

        return response($content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'product_alias' => 'unique:products,alias'
        ], [
            'product_alias.unique' => 'Đường dẫn không hợp lệ!'
        ]);
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }
        //Begin transaction
        DB::beginTransaction();
        try {
            /**
             * Condition 1:
             * Insert new product data to database
             */
            DB::table('products')->insert([
                'name' => $request->product_name,
                'alias' => $request->product_alias,
                'price' => $request->product_price,
                'sale_price' => $request->product_sale_price,
                'inventory_quantity' => $request->inventory_quantity,
                'description' => $request->product_description,
                'content' => $request->product_content,
                'product_status_id' => $request->product_status,
                'user_id' => 1,
                'category_id' => $request->product_category,
                'priority_id' => $request->product_priority
            ]);
            $productId = DB::getPdo()->lastInsertId();

            /**
             * Condition 2:
             * Move upload image to upload folder
             * After insert main image of product to database
             */
            if ($request->hasFile('product_image')) {

                $file = $request->file('product_image');
                $path = 'public/uploads/images/products/';
                $imageName = $request->product_alias . '.' . $file->getClientOriginalExtension();
                if ($file->move($path, $imageName)) {

                    $imageTypeId = DB::table('product_image_types')->select('id')->where('name', 'main')->get();
                    $imageTypeId = $imageTypeId[0]->id;

                    DB::table('product_images')->insert([
                        'name' => $imageName,
                        'path' => $path,
                        'alt' => $request->product_alias,
                        'product_image_type_id' => $imageTypeId,
                        'product_id' => $productId
                    ]);
                }
            }

            if ($request->hasFile('sub_product_image')) {
                $files = $request->file('sub_product_image');

                foreach ($files as $file) {

                    $imageTypeId = DB::table('product_image_types')->select('id')->where('name', 'sub')->get();
                    $imageTypeId = $imageTypeId[0]->id;
                    $productImage = new \App\Http\Controllers\Admin\Modules\Images\ProductImage(
                        $request->product_alias,
                        $file->getClientOriginalExtension(),
                        $request->product_alias,
                        $imageTypeId,
                    );

                    if ($file->move($productImage->getPath(), $productImage->getImageFullName())) {                        

                        DB::table('product_images')->insert([
                            'name' => $productImage->getImageFullName(),
                            'path' => $productImage->getPath(),
                            'alt' => $productImage->getAlt(),
                            'product_image_type_id' => $productImage->getTypeId(),
                            'product_id' => $productId
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        //End transaction
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productService = new ProductService();
        $productService->setFindId($id);
        $products = $productService->getProductsToArray();
        $editProduct = $products[0];

        $productImage = $productService->getImage($id, 'main');
        $productSubImages = $productService->getImage($id, 'sub');

        $categoryService = new CategoryService();
        $categories = $categoryService->getCategoryToArray();

        $priorityService = new PriorityService();
        $priorities = $priorityService->getPrioritiesToArray();

        $productStatusModel = new ProductStatus();
        $productStatuses = $productStatusModel->get()->toArray();

        $content = view('admin.product.edit')->with([
            'productImage' => $productImage,
            'productSubImages' => $productSubImages,
            'editProduct' => $editProduct,
            'categories' => $categories,
            'priorities' => $priorities,
            'productStatuses' => $productStatuses
        ]);           
        return response($content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {        
        $updateProduct = Product::find($id);
        if ($updateProduct->alias != $request->product_alias) {
            $validator = Validator::make($request->all(), [
                'product_alias' => 'unique:products,alias'
            ], [
                'product_alias.unique' => 'Đường dẫn không hợp lệ!'
            ]);
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator->errors());
            }
        }

        DB::beginTransaction();
        try {
            DB::table('products')->where('id', $id)->update([
                'name' => $request->product_name,
                'alias' => $request->product_alias,
                'price' => $request->product_price,
                'sale_price' => $request->product_sale_price,
                'inventory_quantity' => $request->inventory_quantity,
                'category_id' => $request->product_category,
                'product_status_id' => $request->product_status,
                'priority_id' => $request->product_priority,
                'description' => $request->product_description,
                'content' => $request->product_content
            ]);

            if ($request->hasFile('product_image')) {
                /**
                 * get Image Type Id is 'main'
                 */
                $mainImageTypeId = null;
                $mainImageType = ProductImageType::select('id')->where('name', 'main')->get()->first();
                if (isset($mainImageType)) {
                    $mainImageTypeId = $mainImageType->id;
                }

                /**
                 * get old Main Product Image edited
                 */
                $oldMainProductImage = ProductImage::where('product_id', $id)->where('product_image_type_id', $mainImageTypeId)->get()->first();


                if (isset($oldMainProductImage)) {                            

                    /**
                     * delete old Main Product Image
                     */
                    if (file_exists($oldMainProductImage->path . $oldMainProductImage->name)) {
                        unlink($oldMainProductImage->path . $oldMainProductImage->name);
                    }                    
                    //DB::table('product_image')->where('id', $oldMainProductImage->id)->delete();

                    /**
                     * After move new image file to host
                     * and add new Main Product Image Info to database
                     */
                    $file = $request->file('product_image');
                    $path = 'public/uploads/images/products/';
                    $imageName = $request->product_alias . '.' . $file->getClientOriginalExtension();
                    if ($file->move($path, $imageName)) {
                        DB::table('product_images')->where('id', $oldMainProductImage->id)->where('product_image_type_id', $mainImageTypeId)->update([
                            'name' => $imageName,
                            'path' => $path,
                            'alt' => $request->product_alias,
                        ]);
                    }                    
                }
            }

            if ($request->hasFile('sub_product_image')) {

                $files = $request->file('sub_product_image');
                foreach ($files as $file) {

                    $imageTypeId = DB::table('product_image_types')->select('id')->where('name', 'sub')->get();
                    $imageTypeId = $imageTypeId[0]->id;
                    $productImage = new \App\Http\Controllers\Admin\Modules\Images\ProductImage(
                        $request->product_alias,
                        $file->getClientOriginalExtension(),
                        $request->product_alias,
                        $imageTypeId,
                    );

                    if ($file->move($productImage->getPath(), $productImage->getImageFullName())) {                        

                        DB::table('product_images')->insert([
                            'name' => $productImage->getImageFullName(),
                            'path' => $productImage->getPath(),
                            'alt' => $productImage->getAlt(),
                            'product_image_type_id' => $productImage->getTypeId(),
                            'product_id' => $id
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('product_images')->where('product_id', $id)->delete();
            DB::table('products')->delete($id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return redirect()->route('product.index');
    }
}
