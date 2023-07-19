<?php

namespace App\Controller;

class HomeController
{
    public function listing($params)
    {
        $taskListDTO = $this->returnAction('get', $params);

        return \App\Models\View::make('tasks/toDoList', ['taskListDTO' => $taskListDTO])->render();
    }

    public function delete($params)
    {
        $taskDTO = new \App\DTO\TaskDTO();

        $taskDTO->setProperty('id', $_POST['data']);

        $this->returnAction('delete', $params, $taskDTO);
    }

    public function returnAction($method, $params, $taskDTO = null)
    {
        $action = new \App\Models\RequestHandler($params['databaseConnection']);
        
        switch ($method)
        {
            case 'get':
                return $action->get('list');
                break;
            case 'delete':
                return $action->delete($taskDTO);
                break;
        }
    }
}

?>