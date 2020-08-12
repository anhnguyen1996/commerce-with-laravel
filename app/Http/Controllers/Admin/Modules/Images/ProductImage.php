<?php
namespace App\Http\Controllers\Admin\Modules\Images;

class ProductImage extends ImageAbstract
{
    const PATH = 'public/uploads/images/products/';

    private $typeId;
    
    /**
     * @param string $name
     * Image Name should be Product Alias
     * @param string $extensions
     * Extensions of image (Ex: jpg or png)
     * @param string $alt
     * Image Alt should be the Product Alias (Example:ao-thun-xam)
     * @param string $path
     * Path of picture
     * @param integer $typeId
     * Product image type id is query at product_image_types table in Database
     * (Example: Such as 'main' is 1 or 'sub' is 2)
     */
    public function __construct($name, $extensions, $alt, $typeId)
    {
        parent::__construct($name, $extensions, $alt, self::PATH);
        $this->typeId = $typeId;
    }
    
    /**
     * Get the value of typeId
     */ 
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set the value of typeId
     *
     * @return  self
     */ 
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }
}