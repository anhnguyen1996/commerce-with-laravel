<?php

namespace App\Http\Controllers\Admin\Services;

use App\Priority;

class PriorityService
{
    public function getPriorityRecord()
    {
        $priorities = Priority::select('*')->get()->toArray();
        $newPriorities = [];
        foreach ($priorities as $priority) {
            $id = $priority['id'];
            $newPriorities[$id] = $priority;
        }
        return $newPriorities;
    }
}