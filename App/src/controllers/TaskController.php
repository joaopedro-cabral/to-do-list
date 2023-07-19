<?php

namespace App\Controller;

class TaskController
{
    public function form($params)
    {
        return \App\Models\View::make('tasks/taskManage', ['pagesMap' => $params['pagesMap']])->render();
    }

    public function add($params)
    {
        $taskDTO = \App\DTO\TaskDTO::setFromRequest($_POST);

        return $this->returnAction('add', $params, $taskDTO);
    }

    public function update($params)
    {
        $taskDTO = \App\DTO\TaskDTO::setFromRequest($_POST);

        return $this->returnAction('edit', $params, $taskDTO);
    }

    public function view($params)
    {
        $taskDTO = $this->returnAction('view', $params);

        return \App\Models\View::make('tasks/taskManage', ['pagesMap' => $params['pagesMap'], 'taskDTO' => $taskDTO])->render();
    }

    public function returnAction($method, $params, $taskDTO = null)
    {
        $action = new \App\Models\RequestHandler($params['databaseConnection']);
        
        switch ($method)
        {
            case 'view':
                return $action->get('single', $params['taskId']);
            case 'add':
                return $action->post($taskDTO, false);
            case 'edit':
                return $action->post($taskDTO, true);
        }
    }
} 

?>