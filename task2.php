<?php
//2. *Реализовать паттерн Singleton при помощи traits.

trait Singleton{ // трейт Синглтон
    protected static $instance;

    protected function __construct(){ // в конструкторе вызов метода setInstance($this)
        static::setInstance($this);
    }

    final public static function setInstance($instance){ // установить статической переменной значение класса - $this и вернуть ее
        static::$instance = $instance;
        return static::$instance;
    }

    final public static function getInstance(){ // получить класс
        return isset(static::$instance) // если значение статической переменной $instance установлено, вернуть его. Если нет - установить ей значение класса
            ? static::$instance
            : static::$instance = new static;
    }
}

class SingletonClass{ // класс Синглтон, использующий трейт Синглтон
    use Singleton;
}

