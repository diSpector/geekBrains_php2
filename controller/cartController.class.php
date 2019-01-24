<?php

class CartController extends Controller
{
    public $view = 'cart';

    public function index()
    {
        $this->view .= "/" . __FUNCTION__ . '.php';
        echo $this->controller_view();
    }

}