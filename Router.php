<?php 

namespace jnanda\jnandaphpmvc;

use jnanda\jnandaphpmvc\exception\NotFoundException;

class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;    
        $this->response = $response;
    }

    public function get($path, $callback)
    {   
        $this->routes['get'][$path] = $callback;
    }
    
    public function post($path, $callback)
    {   
        $this->routes['post'][$path] = $callback;
    }

    public function getRouteMap($method): array
    {
        return $this->routes[$method] ?? [];
    }

    public function getCallback()
    {
        $method = $this->request->method();
        $url = $this->request->getPath();
        // Trim slashes
        $url = trim($url, '/');

        // Get all routes for current request method
        $routes = $this->getRouteMap($method);

        $routeParams = false;

        // Start iterating registed routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if(!$callback)  {
            $callback = $this->getCallback();       
            
            if($callback === false){
                throw new NotFoundException();
            }
        }
        if(is_string($callback)){
            return Application::$app->view->renderView($callback);
        }
        
        if (is_array($callback)) {
            /** @var \jnanda\jnandaphpmvc\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
        
    }
}