<?php

namespace jnanda\jnandaphpmvc;
use jnanda\jnandaphpmvc\exception\ViewException;

class View
{
    public $title = "";
    public $active = "";

    public function e($text) {
        echo htmlspecialchars($text);
    }

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        if(!file_exists(Application::$ROOT_DIR. "/views/$view.php")){
            throw new ViewException;
        }
        include_once Application::$ROOT_DIR."/views/$view.php";
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params){
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }


}