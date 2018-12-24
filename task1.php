<?php
// 1. Создать структуру классов ведения товарной номенклатуры.
// а) Есть абстрактный товар.
// б) Есть цифровой товар, штучный физический товар и товар на вес.
// в) У каждого есть метод подсчета финальной стоимости.
// г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза.
// У штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах.
// У всех формируется в конечном итоге доход с продаж.
// д) Что можно вынести в абстрактный класс, наследование?

// Логика работы.
// Product - абстрактный товар (класс).
// Свойства: название товара, себестоимость.
// Абстрактные методы: расчет цены продажи товара, расчет чистой прибыли с продажи

// PhysProduct - наследник абстрактного класса Product
// Расширяет абстрактный класс полями type (тип товара), priceForUnit (цена за единицу), unit (единица товара - шт или кг)
// Реализует абстрактные методы класса Product
// Позволяет с помощью метода createDigitalProductFromThis() из себя создать цифровой товар,
// у которого стоимость продажи будет в 2 раза ниже физического товара, себестоимость равна нулю

// DigitalProduct - наследник класса PhysProduct
// переопределяет расчет чистой прибыли

// WeightProduct - наследник класса PhysProduct
// расширяет родительский класс свойством kgs (кол-вом килограммов)
// переопределяет расчет цены продажи и расчет чистой прибыли с учетом веса (килограммов)

abstract class Product{
    public $name; // название
    public $costPrice; // себестоимость

    public function __construct($name, $costPrice){
        $this->name = $name;
        $this->costPrice = $costPrice;
        echo "Название: $this->name,<br>Себестоимость - $this->costPrice<br>";
    }

    abstract public function getTotal(); // подсчет суммы продажи товара
    abstract public function getProfit(); // подсчет чистой прибыли с продажи товара
}

class PhysProduct extends Product{ // физический товар
    public $type = "Физический товар<br>";
    public $unit = "шт"; // единица измерения - шт. или кг.
    public $priceForUnit; // цена за 1 шт

    public function __construct($name, $costPrice, $priceForUnit){ // конструктор физического товара
        echo "Создан - " . $this->type;
        parent::__construct($name, $costPrice);
        $this->priceForUnit = $priceForUnit;
        echo "Цена за 1 $this->unit - $this->priceForUnit<br>";
    }

    public function getTotal(){ // подсчет суммы продажи 1шт товара
        return $this->priceForUnit; // просто вернуть цену продажи товара
    }

    public function getProfit(){ // подсчет чистой прибыли с продажи 1шт товара
        return $this->getTotal() - $this->costPrice; // вернуть разницу между ценой товара и себестоимостью
    }

    public function createDigitalProductFromThis(){ // создать цифровой товар из физического - имя такое же, себестоимость - ноль, цена продажи - половина цены физического товара
        return new DigitalProduct($this->name, 0, $this->priceForUnit/2);
    }
}

class DigitalProduct extends PhysProduct{ // цифровой товар - наследник физического
    public $type = "Цифровой товар<br>";

        // конструктор и расчет стоимости продажи наследуются без изменений

        public function getProfit(){ // расчет чистой прибыли переопределяется
        return $this->getTotal(); // т.к. себестоимость равна нулю, чистая прибыль равна стоимости продажи
    }
}

class WeightProduct extends PhysProduct{ // весовой товар - наследник физического
    public $type = "Весовой товар<br>";
    public $unit = "кг";
    public $kgs; // вес - сколько килограмм нужно приобрести

    public function __construct($name, $costPrice, $priceForUnit, $kgs){
        parent::__construct($name, $costPrice, $priceForUnit);
        $this->kgs = $kgs;
    }

    public function getTotal(){ // расчет стоимости продажи переопределяется: цена за 1 кг * кол-во килограммов
        return $this->priceForUnit * $this->kgs;
    }

    public function getProfit(){ // расчет чистой прибыли переопределяется: стоимость продажи минус себестоимость 1кг * кол-во килограммов
        return $this->getTotal() - $this->costPrice * $this->kgs;
    }
}

class Screen{ // класс для простого вывода информации на экран
    static public function view($obj){
        if (!is_null($obj)){
            $howManyUnits = ($obj instanceof WeightProduct) ? "$obj->kgs $obj->unit" : ""; // если весовой товар, вывести кол-во килограммов
            echo "Сумма продажи $howManyUnits товара $obj->name - " . $obj->getTotal();
            echo "<br>";
            echo "Чистая прибыль с продажи $howManyUnits товара $obj->name - " . $obj->getProfit();
            echo "<br>";
            echo "<br>";
        } else {
            echo "Ошибка - отсутствует товар";
        }
    }
}

// ТЕСТЫ - вариант 1 - создание товаров с выбором типа товара вручную (new PhysProduct и т.д.)
// создаем физический товар - карты Bicycle
echo 'Создание товаров вручную:<br><br>';
$bicycle = new PhysProduct("Карты Bicycle", 200, 350);
Screen::view($bicycle);

// создаем физический товар - книгу по фокусам
$book = new PhysProduct("Книга Royal Road to Card Magic", 600, 1000);
Screen::view($book);

// создаем цифровой товар из физического товара, созданного ранее (книги),
// соответсвенно цена его продажи будет в 2 раза меньше продажи физического товара
$digitalBook = $book->createDigitalProductFromThis();
Screen::view($digitalBook);

// создаем цифровой товар без предварительного создания физического товара - в этом случае его цена продажи
// не будет привязана к стоимости продажи физического товара
$videoCourse = new DigitalProduct("Видеокурс по фокусам", 0, 1000);
Screen::view($videoCourse);

// создаем весовой товар - пудру для карт
$powder = new WeightProduct("Пудра для карт", 50, 100, 2);
Screen::view($powder);


// вариант 2 - создание объектов фабричным методом

class Factory {
    public static function build($type, $name, $costPrice, $price, $kgs = null){
        switch ($type){
            case '1':
                return new PhysProduct($name, $costPrice, $price);
                break;
            case '2':
                return new DigitalProduct($name, 0, $price);
                break;
            case '3':
                return new WeightProduct($name, $costPrice, $price, $kgs);
                break;
            default:
                echo 'Неверный тип, товар не создан<br>';
                return null;
        }
    }
}

// тесты - вариант 2- при создании указывается тип товара, а затем товар создается фабрикой
echo 'Создание товаров фабричным методом:<br><br>';
// создать физический товар - книгу
$newBookRoyalRoad = Factory::build(1, 'Книга "Expert Card Technique"', 600,1000);
Screen::view($newBookRoyalRoad);

// создать цифровой товар из физического товара - книги
$newDigitalBookFormPhysBook = $newBookRoyalRoad->createDigitalProductFromThis();
Screen::view($newDigitalBookFormPhysBook);

// создать цифровой товар без предварительного создания физического товара
$newDigitalBook = Factory::build(2, 'Цифровая книга "Modern Coin Magic"', 0,500);
Screen::view($newDigitalBook);

// создать весовой товар - снег
$newPowder = Factory::build(3, 'Волшебный снег', 100,150, 15);
Screen::view($newPowder);

// попытка создания товара с заведомо неправильным типом
$someProduct = Factory::build(4, "Странный товар", 100, 'fdg');
Screen::view($someProduct);

