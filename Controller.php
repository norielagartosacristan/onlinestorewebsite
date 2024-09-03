<?php

class Controller
{
    protected $model;
    protected $view;

    public function loadModel($model)
    {
        require_once '../app/models/' . ucfirst($model) . 'Model.php';
        $modelClass = ucfirst($model) . 'Model';
        $this->model = new $modelClass();
    }

    public function loadView($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }

    public function render($view, $data = [])
    {
        extract($data);
        $this->loadView($view, $data);
    }
}

?>
