<?php

namespace App\Models;

class PageHandler
{
    private $route;

    function __construct($uri)
    {
        $this->route = explode('?', $uri);
    }

    function setTitle($pagesMap)
    {
        foreach ($pagesMap as $page => $title)
        {
            if ($this->route[0] === $page)
            {
                return '<h3>' . $title . ' Task</h3>';
            }
        }
    }

    function getPage($pagesMap)
    {
        foreach ($pagesMap as $page => $title)
        {
            if ($this->route[0] === $page)
            {
                return $title;
            }
        }
    }

    function renderSelect($taskDTO)
    {
        $select = [];

        $selectOptions = [
            true => 'Done',
            false => 'Undone'
        ];

        foreach($selectOptions as $bool => $option)
        {
            $selected = ($bool == htmlspecialchars($taskDTO->getProperty('status'))) ? "selected" : "";
            $option = "<option value=" . $bool . " " . $selected . ">" . $option . "</option>";

            array_push($select, $option);
        }

        return $select;
    }
}

?>