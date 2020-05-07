<?php

namespace App\Http\Controllers\Admin\Header;

interface HeaderPanelInterface
{
    public function setBreadcrumb(\App\Http\Controllers\Admin\Header\Breadcrumb $breadcrumb);

    public function getBreadcrumbs();

    public function setPanel();

    public function getPanels();
}
