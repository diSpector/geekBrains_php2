<?php
use PHPUnit\Framework\TestCase;
require_once '../vendor/autoload.php';
require_once '../autoload.php';

class goodControllerTest extends TestCase
{
    protected $class;

    protected function setUp(){ // установка фикстуры
        $this->class = new GoodController();
    }

    public function testGoodControllerIsClass(){ // тестирование предположения, что GoodController - класс
        $this->assertInstanceOf(
            GoodController::class,
            $this->class
        );
    }
    public function testGoodControllerView(){ // тестирование предположения, что вью по умолчанию - 'catalog'
        $view = $this->class->view;
        $this->assertEquals('catalog', $view);
    }

    public function testGoodControllerIndexView(){ // тестирование вью при запуске метода index()
        $this->class->index();
        $view = $this->class->view;
        $this->assertEquals('catalog/index.php', $view);
    }

    public function testGoodControllerCall(){ // тестирование, что при запуске неизвестного метода вызывается sub_catalog()
        $this->class->unknown();
        $view = $this->class->view;
        $this->assertEquals('catalog/sub_catalog.php', $view);
    }

    public function testGoodControllerControllerView(){ // проверка, что при если переход по ссылке /good/, будет загружена модель goodModel
        $_GET['page'] = "Good";
        $this->assertEquals('GoodModel->Index', $this->class->controller_view());
    }

    public function testGoodControllerControllerViewWithAction(){ // проверка, что при если был задан экшн, то будет вызван соответствующий метод модели
        db::getInstance()->Connect(Config::get('db_user'), Config::get('db_password'), Config::get('db_base'));
        $_GET['page'] = "Good";
        $_GET['action'] = "good";
        $this->assertEquals('GoodModel->good', $this->class->controller_view());
    }

    public function testGoodControllerData(){ // проверка свойства title контроллера
        $_GET['page'] = "Good";
        $_GET['action'] = "good";
        $this->class->controller_view();
        $this->assertEquals('Интернет-магазин | Товар', $this->class->data['title']);
    }

    protected function tearDown() { // уничтожение фикстуры
        $this->class = NULL;
    }
}
