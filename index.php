<?php
//1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
//2. Описать свойства класса из п.1 (состояние).
//3. Описать поведение класса из п.1 (методы).
//4. Придумать наследников класса из п.1. Чем они будут отличаться?

// Класс - товар в интернет-магазине
// Свойства - закрытые название, цена; статическое открытое общее количество созданных товаров
// Методы - изменить цену, получить цену, получить название
// Наследники - товары из определенного каталога (игральные карты, наборы для фокусов). Будут отличаться свойством "категория"

class Product{ // класс товара со свойствами цены и названия, к которым нельзя обратиться извне объекта.
    // Для установки цены используется метод setPrice
    protected $name;
    protected $price;
    public static $quantity = 0;

    public function __construct($name = "Новый Товар", $price = 1) // конструктор
    {
        $this->name = $name;
        $this->price = $price;
        echo("Создан товар '$this->name'\n");
        self::$quantity++;
    }
    public function getPrice(){ // геттер цены
        return $this->price;
    }
    public function getName(){ // геттер названия
        return $this->name;
    }
    public function setPrice($price = 0){ // сеттер цены
        if(is_numeric($price) && $price > 0){
            $this->price = $price;
            echo "Новая цена товара '$this->name' - $this->price рублей";
        } else {
            echo "Неверный формат цены";
        }
    }
    static public function howManyProducts(){ // статический метод для вывода количества всех Товаров
        echo "Создано всего товаров - " . self::$quantity;
    }
}

class PlayingCards extends Product{ // класс "Игральные карты" - наследник класса "Продукт"
    protected $category; // новое свойство - Категория
    public static $quantity = 0;

    public function __construct($name = "Новая колода Игральных карт", $price = 1) // конструктов
    {
        parent::__construct($name, $price); // конструктор родителя
        $this->category = 1;
        self::$quantity++;
    }
    public function getCategory(){ // геттер категории
        echo "Категория товара - $this->category";
    }
    static public function howManyPlayingCards(){ // статический метод для вывода количества созданных объектов "Игральные Карты"
        echo "Создано всего Игральных Карт - " . self::$quantity;
    }
}

class MagicTrick extends Product{ // класс "Фокус" - наследник класса "Товары"
    protected $category;
    public static $quantity = 0;

    public function __construct($name = "Новый Фокус", $price = 1)
    {
        parent::__construct($name, $price);
        $this->category = 2;
        self::$quantity++;
    }
    public function getCategory(){
        echo "Категория товара - $this->category";
    }
    static public function howManyMagicTricks(){
        echo "Создано всего Фокусов - " . self::$quantity;
    }
}
// Тесты
$good1 = new Product("Игральные карты Bicycle", 350); // создаем новый Товар
$goodName = $good1->getName(); // получаем его название
$goodPrice = $good1->getPrice(); // получаем цену
echo ("Название товара - $goodName"); // выводим название
echo PHP_EOL;
echo ("Цена товара - $goodPrice"); // выводим цену
echo PHP_EOL;
$good1->setPrice(200); // устанавливаем новую цену
echo PHP_EOL;
echo ("Всего было создано товаров - " . Product::$quantity); // выводим количество созданных Товаров через статическое свойство
echo PHP_EOL;
$good2 = new Product("Игральные карты Bee", 400); // создаем новый Товар
Product::howManyProducts(); // выводим количество созданных Товаров через статический метод
echo PHP_EOL;
// создаем экземпляр класса-наследника
$good3 = new PlayingCards("Игральные карты Tally Ho", 500); // создаем новые Игральные Карты
$good3->getCategory(); // выводим категорию товара
echo PHP_EOL;
Product::howManyProducts(); // выводим количество созданных товаров
echo PHP_EOL;
PlayingCards::howManyPlayingCards(); // выводим количество созданных Товаров в категории Игральные карты
echo PHP_EOL;
$good4 = new MagicTrick("Фокус Tarantula", 4000); // создаем новый Фокус
echo $good4->getPrice(); // вывод унаследованного метода из класса-родителя
echo PHP_EOL;
$good4->getCategory(); // выводим категорию товара
echo PHP_EOL;
$good5 = new PlayingCards("Игральные карты Arcane", 1000); // создаем новые Игральные Карты
Product::howManyProducts(); // выводим количество созданных Товаров
echo PHP_EOL;
PlayingCards::howManyPlayingCards(); // выводим количество созданных Товаров в категории Игральные карты
echo PHP_EOL;
MagicTrick::howManyMagicTricks(); // выводим количество созданных Товаров в категории Фокусы
echo PHP_EOL;


// 5. Что выведет код на каждом шаге? Почему?
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
$a1 = new A(); // первый объект класса А
$a2 = new A(); // второй объект класса А
$a1->foo(); // $x = 1. вызов метода, который прибавит СТАТИЧЕСКОЙ переменной класса единицу
$a2->foo(); // $x = 2. так как переменная $x - статическая, каждый вызов функции foo() из любого объекта класса A будет прибавлять единицу к $x
$a1->foo(); // $x = 3.
$a2->foo(); // $x = 4.

// 6. Если изменить код:
class C {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class D extends C {
}
$a1 = new C(); // объект класса C
$b1 = new D(); // объект класса D
// при вызове foo() из разных класов создаётся переменная $x для каждого класса
$a1->foo(); // вызов метода foo() объекта класса C. $x класса C = 1
$b1->foo(); // вызов метода foo() объекта класса D. $x класса D = 1
$a1->foo(); // вызов метода foo() объекта класса C. $x класса C = 2
$b1->foo(); // вызов метода foo() объекта класса D. $x класса D = 2

// 7. Что изменится в этом случае?
// По сравнению с заданием 6 не изменится ничего, так как единственная разница в том, что объекты создаются без скобок из классов.
// Такая запись допустима, если в конструктор класса не передаются переменные.
class E {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class F extends E {
}
$a1 = new E;
$b1 = new F;
$a1->foo(); // $x класса E = 1
$b1->foo(); // $x класса F = 1
$a1->foo(); // $x класса E = 2
$b1->foo(); // $x класса F = 2