<?php

namespace App\TaskNodeFilter;

use App\TaskNode;
use App\TaskNodeFilter\Filter\Priority;
use App\TaskNodeFilter\Filter\Status;
use App\TaskNodeFilter\Filter\Update;
use App\TaskNodeFilter\Filter\RangeDate;
use App\TaskNodeFilter\Filter\Create;
use App\TaskNodeFilter\Filter\Username;


class TaskNodeFilter 
{
    public static function apply($filters)
    {
        $taskNodeQuery = TaskNode::query();
        $root = TaskNode::root();

        if (count($filters->except('_token', '_method')) === 0) {
            $childrens = $root->getDescendants();
            return array('root' => $root, 'childrens' => $childrens);

        } else {
            if ($filters->has('priority')) {
                $taskNodeQuery = Priority::apply($taskNodeQuery, $filters->get('priority'));
            }
    
            if ($filters->has('status')) {
                $taskNodeQuery = Status::apply($taskNodeQuery, $filters->get('status'));
            }
    
            if ($filters->has('user')) {
                $taskNodeQuery = Username::apply($taskNodeQuery, $filters->get('user'));
            }

            if ($filters->has('created_at')) {
                $taskNodeQuery = Create::apply($taskNodeQuery, $filters->get('created_at'));
            }

            if ($filters->has('updated_at')) {
                $taskNodeQuery = Update::apply($taskNodeQuery, $filters->get('updated_at'));
            }

            if ($filters->has('from')) {
                $taskNodeQuery = RangeDate::apply($taskNodeQuery, ['to' => $filters->get('to'), 'from' => $filters->get('from')]);
            }
            
            $childrens = $taskNodeQuery->get();

            return array('root' => $root, 'childrens' => $childrens);
        }

        
    }
}

?>