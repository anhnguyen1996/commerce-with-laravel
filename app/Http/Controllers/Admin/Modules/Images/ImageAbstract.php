<?php

namespace App\Http\Controllers\Admin\Modules\Images;

abstract class ImageAbstract
{
    protected $name;

    protected $extensions;

    protected $alt;

    protected $path;    

    /**
     * @param string $name
     * Name of image
     * @param string $extensions
     * Extensions of image (Example: jpg or png)
     * @param string $alt
     * Image Alt should be the Product Alias (Example:ao-thun-xam)
     * @param string $path
     * Path of image
     */
    public function __construct($name, $extensions, $alt, $path)
    {
        $this->name = $name . '-' . $this->generateAutoString();;
        $this->extensions = $extensions;
        $this->alt = $alt;
        $this->path = $path;
    }
    
    public function getImageFullName()
    {        
        $imageName = $this->name . '.' . $this->extensions;        
        return $imageName;
    }

    private function generateAutoString($length = 8)
    {
        $character = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characterLength = strlen($character);
        $string  = '';
        for ($i = 0; $i < $length; $i++) {
            $newCharacter = $character[rand(0, $characterLength - 1)];
            $string .= $newCharacter;
        }
        return $string;
    }
    


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of extensions
     */ 
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Set the value of extensions
     *
     * @return  self
     */ 
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;

        return $this;
    }

    /**
     * Get the value of alt
     */ 
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set the value of alt
     *
     * @return  self
     */ 
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get the value of path
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */ 
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}