<?php
namespace App\Http\Controllers\Admin\Modules\Header;

use App\Http\Controllers\Admin\Header\HeaderPanelInterface;

class HeaderPanel
{
    private $breadcrumbs = [];

    private $panels = [];

    public function addNewBreadcrumb(\App\Http\Controllers\Admin\Header\Breadcrumb $breadcrumb)
    {
        $this->breadcrumbs[] = $breadcrumb;
    }

    public function addNewPanel(\App\Http\Controllers\Admin\Header\Panel $panel)
    {
        $this->panels[] = $panel;
    }

    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    public function setBreadcrumbs(array $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }    

    public function getPanels()
    {
        return $this->panels;
    }

    public function setPanel(array $panels)
    {
        return $this->panels = $panels;
    }
}