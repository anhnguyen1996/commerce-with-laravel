<?php

namespace App\Http\Controllers\Admin\Modules\Header;

use App\Http\Controllers\Controller;

class Breadcrumb extends Controller
{
    private $name;
    private $link;

    public function __construct($name = null, $link = null)
    {
        $this->name = $name;
        $this->link = $link;        
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
     * Get the value of link
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */ 
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }
}