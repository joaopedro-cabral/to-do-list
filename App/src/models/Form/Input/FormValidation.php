<?php

namespace App\Models\Form\Input;

class FormValidation
{
    const FORM_MAP = FORM_MAP;

    private $taskDTO;
    private $databaseConnection;
    private $errors = [];

    public function __construct($taskDTO, $databaseConnection)
    {
        $this->taskDTO = $taskDTO;

        $this->databaseConnection = $databaseConnection;
    }

    public function validateForm($taskDTO)
    {
    
        foreach(FORM_MAP as $input)
        {
            if (empty($taskDTO->getProperty($input)) && !is_null($taskDTO->getProperty($input)))
            {
                $this->errors[$input] = 'Please, provide the data of "' . $input . '"!';
            } else {
                $validateFunction = $input . 'Validation';
    
                if (method_exists($this, $validateFunction)){
                    $this->$validateFunction($taskDTO->getProperty($input));
                }
            }
        }
        
        return $this->errors;

    }
}

?>