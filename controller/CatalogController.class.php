<?php

class CatalogController extends Controller
{
    public $view = 'catalog';

    public function index() //Метод с вынесенными однотипными действиями в метод класса родителя
    {
        $this->view .= "/" . __FUNCTION__ . '.php';

        echo $this->controller_view();
    }
}