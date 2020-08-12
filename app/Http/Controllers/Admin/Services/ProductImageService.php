<?php
namespace App\Http\Controllers\Admin\Services;

use App\ProductImage;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductImageService
{
    public function delete($id)
    {
        $id = (integer)$id;
        $result = false;
        DB::beginTransaction();
        try {        
            $productImage = DB::table('product_images')->where('id', $id)->first();
            
            //delete record on DB
            DB::table('product_images')->where('id', $id)->delete();

            //delete image file on server
            $imageFullName = $productImage->path .  $productImage->name;
            unlink($imageFullName);

            DB::commit();
            $result = true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }        
        return $result;
    }
}