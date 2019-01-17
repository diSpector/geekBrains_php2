<?php

class Controller
{
    public $view = 'index';
	protected $data;
	protected $template;
	
	function __construct()
	{
		$this->data = [
			'isAuth' => Auth::logIn(),
            'domain' => Config::get('domain'),
		];
	}

	public function controller_view()
	{
//		echo "<br> Модель класса: " . $modelName = $_GET['page'] . 'Model';
//		echo "<br> Метод модели: " . $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
        $modelName = $_GET['page'] . 'Model';
        $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';

        $model = new $modelName();
		$content_data = $model->$methodName();

		$this->data['content_data'] = $content_data;
		$this->data['title'] = $model->title;

        $loader = new Twig_loader_Filesystem(Config::get('path_templates'));
        $twig = new Twig_Environment($loader);

//		Debug::Deb($this->data);

        // проверка, что пришел AJAX POST-запрос с формы авторизации
        if (isset($_POST['metod']) && ($_POST['metod'] === 'ajax') && ($_POST['PageAjax'] === 'register')){
            $this->data['isAuth'] = $model->ajax($_POST['PageAjax']); // обработать ajax-запрос, присвоить результат в переменную
            $template = $twig->loadTemplate('auth.html'); // подготовить шаблон для вывода
            echo $template->render(array('isAuth' => $this->data['isAuth'])); // вывести шаблон
            exit(); // прервать выполнение скрипта
        }


            $template = $twig->loadTemplate($this->view);
            return $template->render($this->data);
	}

	public function __call($name, $param)
	{
    echo "Параметры - $name";
//		header("Location: /page404/");
	}

}