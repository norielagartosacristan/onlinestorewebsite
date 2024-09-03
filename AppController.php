<?php

class AppController extends Controller
{
    public function __construct($model = null, $view = null)
    {
        if ($model) {
            $this->loadModel($model);
        }
        if ($view) {
            $this->view = $view;
        }
    }
}

?>
