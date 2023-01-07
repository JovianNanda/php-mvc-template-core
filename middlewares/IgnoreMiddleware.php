<?php

namespace jnanda\jnandaphpmvc\middlewares;

use jnanda\jnandaphpmvc\Application;
use jnanda\jnandaphpmvc\exception\ForbiddenException;

class IgnoreMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions =  array_map('strtolower', $actions);
    }

    public function execute()
    {
        if (!Application::isGuest()) {
            $appAction = strtolower(Application::$app->controller->action);
            if (empty($this->actions) || in_array($appAction, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}