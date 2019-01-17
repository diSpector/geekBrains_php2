<?php

class AccountModel extends Model
{
    public $view = 'account';
    public $title;

    public function index()
    {
        session_start();
        $user_id = $_SESSION['id_user'];
        $sql = "select * from last_seen_pages where user_id = $user_id ORDER BY id DESC LIMIT 5";
        $result = db::getInstance()->Select($sql);

//		Debug::Deb($result);
        return $result;
    }
}