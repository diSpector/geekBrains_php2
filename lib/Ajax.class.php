<?php

class Ajax
{
    public static $views;

    public static function register()
    {
        self::$views = 'auth.html';

        return ['isAuth' => Auth::logIn($_POST['login'], $_POST['pass'], $_POST['rememberme'])];
    }

    // метод для вывода доп. товаров при нажатии на кнопку "Посмотреть еще"
    public static function see_additional_goods()
    {
        self::$views = 'catalog/product_catalog.php';
        $model = new catalogModel();
        $nStart = $_POST['current_record'];
        $count = $_POST['count'];
        $data = $_POST['category'];
        return ['content_data' => $model->sub_catalog($data, $nStart, $count)];
    }

    // метод для добавления товара в корзину при нажатии на кнопку "Купить", "Добавить"
    public static function basket()
    {
        self::$views = 'cart/add_product.php';
        $data = Basket::getInstance()->add($_POST['var4']);
        $result = ['content_data' => $data];
//        Debug::Deb($quantity);
        return $result;
    }

    // метод для удаления товара из корзины при нажатии на кнопку "Удалить"
    public static function basketDelete()
    {
        self::$views = 'cart/add_product.php';
        $data = Basket::getInstance()->delete($_POST['var4']);
        $result = ['content_data' => $data];
//        Debug::Deb($quantity);
        return $result;
    }

    // метод для уменьшения количества товара на 1 при нажатии на кнопку "Уменьшить"
    public static function basketReduce(){
        self::$views = 'cart/add_product.php';
        $data = Basket::getInstance()->reduce($_POST['var4']);
        $result = ['content_data' => $data];
//        Debug::Deb($quantity);
        return $result;
    }

    // метод для размещения заказа - нажатие на кнопку "Оформить заказ"
    public static function placeOrder(){
        self::$views = 'cart/placed.php';
        $data = Basket::getInstance()->placeOrder();
        $result = ['content_data' => $data];
//        Debug::Deb($quantity);
        return $result;
    }

    // метод для получения данных о заказе при нажатии на номер заказа в личном кабинете
    public static function getOrder(){
        self::$views = 'account/order_contents.php';
        $data = Basket::getInstance()->getOrder();
        $statuses = Basket::getInstance()->getStatuses();
//        $result = ['content_data' => $data];
        $result = [
            'content_data' => $data,
            'statuses' => $statuses
            ];

//        Debug::Deb($result);
        return $result;
    }

    // метод для изменения статуса заказа в базе при изменении статуса заказа в личном кабинете
    public function changeStatus(){
        self::$views = 'account/changed_status.php';
        $data = Basket::getInstance()->changeStatus();
        $result = [
            'content_data' => $data,
        ];

        return $result;
    }
}