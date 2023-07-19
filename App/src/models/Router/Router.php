<?php

declare (strict_types=1);

namespace App\Models\Router;

class Router
{
    private array $routes;

    public function set(string $requestMethod, string $route, callable|array $action, array $params = [])
    {
        $this->routes[$requestMethod][$route] = ['action' => $action, 'data' => $params];

        return $this;
    }

    public function get(string $route, callable|array $action, array $params = [])
    {
        return $this->set('get', $route, $action, $params);
    }

    public function post(string $route, callable|array $action, array $params = [])
    {
        return $this->set('post', $route, $action, $params);
    }

    public function routes()
    {
        return $this->routes();
    }

    public function resolve(string $requestURI, string $requestMethod)
    {
        $route = explode('?', $requestURI)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) 
        {
            throw new \App\Models\Exception\RouteNotFoundException();
        }

        if(is_callable($action))
        {
            return call_user_func($action);
        }

        if(is_array($action))
        {
            $class = $action['action'][0] ?? null;
            $method = $action['action'][1] ?? null;

            if($class && $method && class_exists($class))
            {
                $classInstance = new $class();

                if(method_exists($classInstance, $method))
                {
                    $data = $this->routes[$requestMethod][$route]['data'] ?? [];

                    return call_user_func_array([$classInstance, $method], [$data]);
                }
            }
        }

        throw new \App\Models\Exception\RouteNotFoundException();
    }
}

?>