<?php
class AccountController extends Controller
{
    public $view = 'account';

    public function index()
    {
        session_start();
        if (isset($_SESSION['id_user'])){ // если пользователь залогинен, вывести личный кабинет
            $this->view .= "/" . __FUNCTION__ . '.php';
            echo $this->controller_view();
        } else { // если нет, перенаправить на Главную
            header("Location: /");
        }
    }
}