<?php

require ("../vendor/autoload.php");
include ("../src/config/constants.php");

// connect to database
$db = new App\Models\DatabaseConnection();
$databaseConnection = $db->getConnection();

$router = new App\Models\Router\Router();

$router
    ->get('/', [App\Controller\HomeController::class, 'listing'], ['databaseConnection' => $databaseConnection])
    ->post('/', [App\Controller\HomeController::class, 'delete'], ['databaseConnection' => $databaseConnection])
    ->get('/view-task', [App\Controller\TaskController::class, 'view'], ['databaseConnection' => $databaseConnection,
                                                                         'taskId' => isset($_GET['id']) ? $_GET['id'] : null,
                                                                         'pagesMap' => PAGES_MAP])
    ->get('/edit-task', [App\Controller\TaskController::class, 'view'], ['databaseConnection' => $databaseConnection,
                                                                         'taskId' => isset($_GET['id']) ? $_GET['id'] : null,
                                                                         'pagesMap' => PAGES_MAP])
    ->post('/edit-task', [App\Controller\TaskController::class, 'update'], ['databaseConnection' => $databaseConnection,
                                                                         'pagesMap' => PAGES_MAP])
    ->get('/add-task', [App\Controller\TaskController::class, 'form'], ['pagesMap' => PAGES_MAP])
    ->post('/add-task', [App\Controller\TaskController::class, 'add'], ['databaseConnection' => $databaseConnection,
                                                                        'pagesMap' => PAGES_MAP]);

echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));


?>