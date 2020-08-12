<?php
namespace App\Http\Controllers\Admin\Services;

use App\Priority;

class PriorityService
{
    private function getPriorities()
    {
        $priorities = Priority::select('*')->get();
        return $priorities;
    }

    public function getPrioritiesToArray()
    {
        $priorities = $this->getPriorities()->toArray();
        $newPriorities = [];
        foreach ($priorities as $priority) {
            $id = $priority['id'];
            $newPriorities[$id] = $priority;
        }
        return $newPriorities;
    }

    public function getPrioritiesToJson()
    {
        return $this->getPriorities()->toJson();
    }
}