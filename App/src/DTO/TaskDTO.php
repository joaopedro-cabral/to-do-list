<?php

namespace App\DTO;

class TaskDTO
{
    public function __construct(
        private $id = null,
        private $name = null,
        private $status = null,
        private $description = null,
        private $response = []
    ){}

    public static function setFromRequest($request)
    {
        return new TaskDTO(
            $request['data']['id'],
            $request['data']['name'],
            $request['data']['status'],
            $request['data']['description']
        );
    }

    public static function setFromArray($arrayData)
    {
        return new TaskDTO(
            $arrayData['id'],
            $arrayData['name'],
            $arrayData['status'],
            $arrayData['description']
        );
    }

    public function setProperty($propertyName, $propertyValue)
    {
        $this->$propertyName = $propertyValue;
    }

    public function getProperty($propertyName)
    {
        return $this->$propertyName;
    }
}

?>