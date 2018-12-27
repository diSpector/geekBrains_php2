<?php
// класс соединения с БД (паттерн Синглтон)

class DB_PDO{

    private $dsn = 'mysql:host=' . HOST . ';dbname='  . DB; // часть параметров для соединения с БД
    private static $db = null; // экземпляр класса
    private static $connection; // соединение с БД

    private function __construct(){ // в конструторе задается подключение к БД и установка чарсета
        try {
            self::$connection = new PDO($this->dsn, USER, PASS);
            self::$connection->exec('SET CHARACTER SET utf8');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function getDB() { // метод для получения экземляра класса БД (вызывает конструктор или возвращает ссылку на класс)
        if (self::$db == null) self::$db = new DB_PDO();
        return self::$db;
    }

    public static function executeQuery($sql){ // метод для выполнения запроса, возвращает массив значений
        $sth = self::$connection->query($sql);
        $connection = null; // закрытие соединения с БД
        return $sth;
    }

    public static function getRow($sql){ // метод получения одной строки из массива результатов запроса
        $result = self::executeQuery($sql);
        if (!$result) {
            return 0;
        } else {
            return $result->fetch();
        }
    }

    public static function getAssocResult($sql){ // метод для получения массива всех результатов запроса
        $result = self::executeQuery($sql);
        $arrayResult = array();
        if (!$result) {
            return 0;
        } else {
            while ($row = $result->fetch()) { // запись всех результатов в массив
                $arrayResult[] = $row;
            }
            $result = null; // удаление ссылки на данные из БД
            return $arrayResult;
        }
    }

    public static function readOneProduct($id){ // метод для получения данных об одном продукте
        return self::getRow("select * from products where id = $id");
    }
}







