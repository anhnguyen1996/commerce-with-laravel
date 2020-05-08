<?php
namespace App\Http\Controllers\Admin\Pagination;

/*
This class is used by method index in All Controller
or anything same operation
*/

class Pagination
{
    private $currentPage = 1;
    
    private $totalPages;

    private $totalRecordsPerPage;

    private $totalRecords;

    private $startRecordNumber;

    private $endRecordNumber;

    /**
     * This field use to set url for one by page for List view
     * Example as: 'admin/category', 'admin/product', 'admin/user', 'product', 'cart'
     * @var string
     */
    private $url;

    /**
     * @param int $currentPage
     * @param int $totalRecords
     * @param string $url
     * This field use to set url for one by page for List view
     * Example as: 'admin/category', 'admin/product', 'admin/user', 'product', 'cart'
     * 
     * @param int $totalRecordsPerPage
     */
    public function __construct($currentPage, $totalRecords, $url, $totalRecordsPerPage = 10)
    {
        $this->currentPage = $currentPage;
        $this->totalRecords = $totalRecords;        
        $this->totalRecordsPerPage = $totalRecordsPerPage;
        $this->url = $url;
        $this->calculateTheTotalNumberOfPages();
        $this->calculateStartRecordNumber();
        $this->calculateEndRecordNumber();
    }
    
    /**
     * This function obligately use to confirm change after you set new value into field
     * And after that calculating all field
     */
    public function save()
    {
        $this->calculateTheTotalNumberOfPages();
        $this->calculateStartRecordNumber();
        $this->calculateEndRecordNumber();
    }

    private function calculateTheTotalNumberOfPages()
    {        
        $totalPages = (int)($this->totalRecords / $this->totalRecordsPerPage);
        if ($this->totalRecords % $this->totalRecordsPerPage != 0) {
            $totalPages++;
        }        
        $this->totalPages = $totalPages;          
    }

    private  function calculateStartRecordNumber()
    {
        $this->startRecordNumber =  ($this->currentPage - 1) * $this->totalRecordsPerPage;
    }

    private function calculateEndRecordNumber()
    {
        $this->endRecordNumber = $this->currentPage * $this->totalRecordsPerPage - 1;
    }
    
    /**
     * Get the value of currentPage
     */ 
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the value of currentPage
     *
     * @return  self
     */ 
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Get the value of totalRecordsPerPage
     */ 
    public function getTotalRecordsPerPage()
    {
        return $this->totalRecordsPerPage;
    }

    /**
     * Set the value of totalRecordsPerPage
     *
     * @return  self
     */ 
    public function setTotalRecordsPerPage($totalRecordsPerPage)
    {
        $this->totalRecordsPerPage = $totalRecordsPerPage;

        return $this;
    }

    /**
     * Get the value of totalRecords
     */ 
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    /**
     * Set the value of totalRecords
     *
     * @return  self
     */ 
    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;

        return $this;
    }

    /**
     * Get the value of totalPages
     */ 
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * Set the value of totalPages
     *
     * @return  self
     */ 
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;

        return $this;
    }    

    /**
     * Get the value of startRecordNumber
     */ 
    public function getStartRecordNumber()
    {
        return $this->startRecordNumber;
    }

    /**
     * Set the value of startRecordNumber
     *
     * @return  self
     */ 
    private function setStartRecordNumber($startRecordNumber)
    {
        $this->startRecordNumber = $startRecordNumber;

        return $this;
    }

    /**
     * Get the value of endRecordNumber
     */ 
    public function getEndRecordNumber()
    {
        return $this->endRecordNumber;
    }

    /**
     * Set the value of endRecordNumber
     *
     * @return  self
     */ 
    private function setEndRecordNumber($endRecordNumber)
    {
        $this->endRecordNumber = $endRecordNumber;

        return $this;
    }

    /**
     * Get $url
     *
     * @return  string
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set $url
     * 
     * @param  string  $url
     * This param use to set url for one by page for List view
     * Example as: 'admin/category', 'admin/product', 'product', 'cart' ...     
     * 
     * @return  self
     */ 
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }
}