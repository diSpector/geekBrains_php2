<?php

class IndexController extends Controller
{
    public $view = 'index';



public function index()
	{
		$this->view .= "/" . __FUNCTION__ . '.php';
		$modelName = $_GET['page'] . 'Model';
		$methodName = isset($_GET['action']) ? $_GET['action'] : 'Index';
		
		$model = new $modelName();
		$content_data = $model->$methodName($_GET);  

		$data = [
			'content_data' => $content_data,
			'title' => $model->title,
			'domain' => Config::get('domain'),
			'BreadCrumbs' => Bread::BreadCrumbs(explode("/", $_SERVER['REQUEST_URI'])),
			'isAuth' => Auth::logIn(),
			];
		
		
		$loader = new Twig_Loader_Filesystem(Config::get('path_templates'));
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate($this->view);
			
		echo $template->render($data);
			
	}





}