<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Header\HeaderPanel;

class ReturnData
{
    /**
     * set view content
     * Example:  category.list, brand.create ...
     * @var string $content
     */
    private $content;

    /**
     * @var \App\Http\Controllers\Admin\Header\HeaderPanel $headerPanel
     */
    private $headerPanel;

    private $results = [];

    private $data = [];

    public function __construct(
        string $content = null,
        \App\Http\Controllers\Admin\Header\HeaderPanel $headerPanel = null,
        array $result = []
    ) {
        $this->content = $content;
        $this->headerPanel = $headerPanel;
        $this->result = $result;
    }

    private function converHeaderPanelToData()
    {
        $this->data['content'] = $this->content;
        $this->data['headerPanel']['breadcrumbs'] = [];
        $this->data['headerPanel']['panels'] = [];

        /*
        Set breadcrumb
        */
        $breadcrumbs = $this->headerPanel->getBreadcrumbs();
        $breadcrumbArray = [];
        foreach ($breadcrumbs as $breadcrumb) {            
            /**
             * @var \App\Http\Controllers\Admin\Header\Breadcrumb $breadcrumb
             */
            $name = $breadcrumb->getName();
            $link = $breadcrumb->getLink();
            $newBreadcrumb = [];
            $newBreadcrumb['name'] = $name;
            $newBreadcrumb['link'] = route($link);
            $breadcrumbArray[] = $newBreadcrumb;
        }
        $this->data['headerPanel']['breadcrumbs'] = $breadcrumbArray;        
    }

    public function returnData()
    {

    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the value of headerPanel
     */
    public function getHeaderPanel()
    {
        return $this->headerPanel;
    }

    /**
     * Set the value of headerPanel
     *
     * @return  self
     */
    public function setHeaderPanel(\App\Http\Controllers\Admin\Header\HeaderPanel $headerPanel)
    {
        $this->headerPanel = $headerPanel;
        return $this;
    }

    /**
     * Get the value of result
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set the value of result
     *
     * @return  self
     */
    public function setResult($results)
    {
        $this->results = $results;
        return $this;
    }
}
