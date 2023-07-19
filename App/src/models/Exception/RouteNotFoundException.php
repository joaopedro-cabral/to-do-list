<?php

namespace App\Models\Exception;

use Exception;

class RouteNotFoundException extends Exception
{
    protected $message = '404 Not Found';
}

?>