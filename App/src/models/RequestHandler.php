<?php

namespace App\Models;

class RequestHandler
{
    public function __construct(
        private $databaseConnection
    ){}
    
    public function get($type, $id = null)
    {
        // set to-do list
        $toDoList = array();
        $toDoList['body'] = array();
        $toDoList['itemCount'] = 0;

        $items = new \App\Models\Tasks\Tasks($this->databaseConnection);

        switch ($type)
        {
            case 'single':
                $stmt = $items->getTask($id);
                break;
            case 'list':
                $stmt = $items->getTasks();
                break;
        }
                
        $itemCount = $stmt->rowcount();

        // insert items in array
        if($itemCount > 0) 
        {    
            $toDoList['itemCount'] += $itemCount;
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) 
            {
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "status" => $status,
                    "description" => $description
                );
                // populate to-do list with the item brought from db
                array_push($toDoList['body'], $e);
            } 
        }

        switch ($type)
        {
            case 'single':
                $taskDTO = \App\DTO\TaskDTO::setFromArray($toDoList['body'][0]);

                //return $toDoList['body'];
                return $taskDTO;
            case 'list':
                // sort the to-do list by sku value
                $idValues = array_column($toDoList['body'], 'id');
                array_multisort($idValues, SORT_ASC, $toDoList['body']);

                $taskListDTO = \App\DTO\TaskListDTO::setFromArray($toDoList['body']);
                
                //return $toDoList['body'];
                return $taskListDTO;
        }
    }

    public function post($taskDTO, $isUpdate)
    {
        $errors = [];
        $data = [];

        $formValidation = new \App\Models\Form\Input\FormValidation($taskDTO, $this->databaseConnection);

        $errors = $formValidation->validateForm($taskDTO);

        if (!empty($errors)) 
        {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $tasks = new \App\Models\Tasks\Tasks($this->databaseConnection);
            
            switch ($isUpdate)
            {
                case true:
                    if ($tasks->updateTask($taskDTO))
                    {
                        $data['success'] = true;
                        $data['message'] = 'Task Updated!';
                    } else {
                        $data['success'] = false;
                        $data['message'] = 'Error while editing task. Try again!';
                    }

                    break;
                    
                case false:
                    $taskDTO->setProperty('id', null);

                    // adds task
                    if ($tasks->insertTask($taskDTO))
                    {
                        $data['success'] = true;
                        $data['message'] = 'Task Added!';
                    } else {
                        $data['success'] = false;
                        $data['message'] = 'Error while adding task. Try again!';
                    }

                    break;
            }
        }

        $taskDTO->setProperty('response', $data);

        echo json_encode($taskDTO->getProperty('response'));
    }

    public function delete($taskDTO)
    {
        $id = $taskDTO->getProperty('id');
    
        $task = new \App\Models\Tasks\Tasks($this->databaseConnection);

        if($task->deleteTask($id))
        {
            $data['success'] = true;
            $data['message'] = 'Task Deleted!';
        }   

        $taskDTO->setProperty('response', $data);

        echo json_encode($taskDTO->getProperty('response'));
    }
}

?>