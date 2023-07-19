<?php

declare (strict_types=1);

namespace App\Models\Tasks;

class Tasks 
{
    // File connection
    protected $databaseConnection;

    // MySQL Table
    protected $databaseTable = 'to_do_list';

    // Table columns
    protected $id;
    protected string $name;
    protected string $description;
    protected bool $status;

    // sets connection
    public function __construct($db)
    {
        $this->databaseConnection = $db;
    }

    public function getTasks()
    {
        $query = 'SELECT id, name, status, description FROM ' . $this->databaseTable . "";

        $stmt = $this->executeQuery($query, null, null, false);

        return $stmt;   
    }

    public function getTask($id)
    {
        $query = 'SELECT id, name, status, description FROM ' . $this->databaseTable . 
                 ' WHERE id = :id';

        $stmt = $this->executeQuery($query, null, $id, false);

        return $stmt;  
    }

    public function insertTask($taskDTO)
    {
        $query = 'INSERT INTO ' . $this->databaseTable . 
                 ' SET name = :name, description = :description, status = :status';

        $stmt = $this->executeQuery($query, $taskDTO, null, true);

        return $stmt; 

    }

    public function updateTask($taskDTO)
    {
        $query = 'UPDATE ' . $this->databaseTable . 
                 ' SET name = :name, description = :description, status = :status WHERE id = :id';

        $stmt = $this->executeQuery($query, $taskDTO, null, true);

        return $stmt;  
    }

    public function deleteTask($id)
    {
        $query = 'DELETE FROM ' . $this->databaseTable . " WHERE id = :id";

        $stmt = $this->executeQuery($query, null, $id, false);

        return $stmt;  
    }

    public function executeQuery($query, $taskDTO = null, $id = null, $useDTO)
    {
        $stmt = $this->databaseConnection->prepare($query);

        switch ($useDTO)
        {
            case true:
                if (!is_null($taskDTO->getProperty('id'))) 
                {
                    $this->id=htmlspecialchars(strip_tags($taskDTO->getProperty('id')));
                    $stmt->bindValue(':id', $this->id);
                }

                if (!is_null($taskDTO->getProperty('name'))) 
                {
                    $this->name=htmlspecialchars(strip_tags($taskDTO->getProperty('name')));
                    $stmt->bindValue(':name', $this->name);
                }

                if (!is_null($taskDTO->getProperty('description'))) 
                {
                    $this->description=htmlspecialchars(strip_tags($taskDTO->getProperty('description')));
                    $stmt->bindValue(':description', $this->description);
                }

                if (!is_null($taskDTO->getProperty('status'))) 
                {
                    $this->status = filter_var($taskDTO->getProperty('status'), FILTER_VALIDATE_BOOLEAN);
                    $stmt->bindValue(':status', $this->status);
                }
                break;
            case false:
                if (!is_null($id))
                {
                    $stmt->bindValue(':id', $id);
                };

                break;
        }

        $stmt->execute();

        return $stmt;
    }
}

?>