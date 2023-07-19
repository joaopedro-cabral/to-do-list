<?php

namespace App\DTO;

class TaskListDTO
{
    public function __construct(
        private $toDoList = []
    ){}

    public static function setFromArray($arrayData)
    {
        return new TaskListDTO($arrayData);
    }

    public function getList()
    {
        return $this->toDoList;
    }
}

?>