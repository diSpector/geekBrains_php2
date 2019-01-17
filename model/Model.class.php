<?php

class Model
{
    public $view = 'index';
    public $title;
    public $pages = [];

    function __construct()
    {	
        $this->title = Config::get('sitename');
    }

//    public function index($data)
    public function index() // при переходе на каждую страницу в БД записывается адрес страницы и id пользователя, если он авторизован
	{
	    session_start();
	    $thisUser = $_SESSION['id_user'];
	    if (isset($thisUser)){
            $thisPage = (isset($_GET['page'])) ? $_GET['page'] : '/';
            $sql = "insert into last_seen_pages (url, user_id) values ('$thisPage', $thisUser)";
            db::getInstance()->Query($sql);
        }
    }
	
	public function __call($methodName, $args) 
	{
        header("Location: Config::get('domain')/page404/");
  	}

  	// метод для обработки ajax-запросов, $page - переменная для определения, откуда пришел запрос
    public function ajax($page){
        switch ($page){
            case 'register': // если запрос с формы авторизации
                return Auth::logIn($_POST['login'], $_POST['pass']); // попробовать авторизоваться с данными, введенными в форму, вернуть результат
        }
    }

}