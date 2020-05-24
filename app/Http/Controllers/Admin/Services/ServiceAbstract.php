<?php

namespace App\Http\Controllers\Admin\Services;

abstract class ServiceAbstract
{
    protected $select;

    protected $findId;

    protected $findName;

    protected $findDescribes;

    protected $skipRecordNumber;

    protected $takeRecordsNumber;

    protected $orderByWithSortName;

    protected $orderByWithOrder;

    public function setLimit($skipRecordNumber, $takeRecordsNumber)
    {
        $this->skipRecordNumber = $skipRecordNumber;
        $this->takeRecordsNumber = $takeRecordsNumber;
    }

    public function setOrder($orderByWithSortName, $orderByWithOrder = 'ASC')
    {
        $this->orderByWithSortName = $orderByWithSortName;
        $this->orderByWithOrder = $orderByWithOrder;
    }

    public function setFindId($findId)
    {
        $this->findId = $findId;
    }

    public function setFindName($findName)
    {
        $this->findName = $findName;
    }

    public function setFindDescribes($findDescribes)
    {
        $this->findDescribes = $findDescribes;
    }
}