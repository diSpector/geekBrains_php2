<?php
use PHPUnit\Framework\TestCase;
require_once '../vendor/autoload.php';
require_once '../autoload.php';


class goodModelTest extends TestCase
{
    protected $class;

    protected function setUp(){ // установка фикстуры
        $this->class = new GoodModel();
    }

    public function testGoodModelView(){ // тестирование вью
        $view = $this->class->view;
        $this->assertEquals('good', $view);
    }

    public function testGoodModelAmountOfViews(){ // проверка, что после показа товара количество его просмотров в базе увеличивается на 1
        $data['id'] = 3; // задаем id товара
        $dataId = $data['id'];
        db::getInstance()->Connect(Config::get('db_user'), Config::get('db_password'), Config::get('db_base'));
        // получаем текующее количество просмотров товара в базе
        $viewsAmount = db::getInstance()->SelectRow("select view from goods where id_good = $dataId")['view'];
        $oldAmount = $viewsAmount;
        // выполняем метод good и передаем id товара, в базе должно увеличиться кол-во просмотров товара
        $this->class->good($data);
        // получаем новое количество просмотров
        $newAmount = db::getInstance()->SelectRow("select view from goods where id_good = $dataId")['view'];
        // сравниваем количество просмотров товара до и после выполнения метода good() - оно должно различаться на единицу
        $this->assertEquals(++$oldAmount, $newAmount);
    }

    public function testGoodModelGoodId(){ // проверка id полученного товара
        $data['id'] = 4; // задаем id товара
        $dataId = $data['id'];
        db::getInstance()->Connect(Config::get('db_user'), Config::get('db_password'), Config::get('db_base'));
        // получаем характеристики запрашиваемого товара из базы (а вместе с ним и рекомендованных товаров)
        $result = $this->class->good($data);
        // сравниваем полученный id из базы с заданным id
        $this->assertEquals($dataId, $result['product'][0]['id_good']);
    }

    protected function tearDown() { // уничтожение фикстуры
        $this->class = NULL;
    }
}
