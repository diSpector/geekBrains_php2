<?php
class AccountController extends Controller{
    public $view = 'account';

    public function index()
    {
        $this->view .= "/" . __FUNCTION__ . '.php';
        echo $this->controller_view();
    }
}