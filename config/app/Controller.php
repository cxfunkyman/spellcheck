<?php

class Controller
{
    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }
    public function loadModel()
    {
        $model = get_class($this) . 'Model';
        $route = 'models/' . $model . '.php';
        if (file_exists($route)) {
            require_once $route;
            $this->model = new $model();
        }
    }
}

?>