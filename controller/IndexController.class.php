<?php

class IndexController extends Controller
{
    public $view = 'index';

	public function index_old()
	{
		echo "<br> Модель класса: " . $modelName = $_GET['page'] . 'Model';
		echo "<br> Метод модели: " . $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
		
		$model = new $modelName();
		$content_data = $model->$methodName();
		
		$data = [
			'content_data'=> $content_data,
			'isAuth'=>Auth::login(),
			'domain'=>Config::get('domain'),
		];
		
		$loader = new Twig_loader_Filesystem(Config::get('path_templates'));
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate($this->view);
		echo $template->render($data);
	}

	public function index()
	{
//		echo "<br>Представление: " . $this->view .= "/" . __FUNCTION__ . ".php";
        $this->view .= "/" . __FUNCTION__ . ".php";
        echo $this->controller_view();
	}

	
}