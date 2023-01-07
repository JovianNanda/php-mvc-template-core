<?php

namespace jnanda\jnandaphpmvc;

use jnanda\jnandaphpmvc\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var BaseMiddleware;
     */
    protected array $middlewares = [];

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function view($view, $params = []){
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware, $url = null)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}