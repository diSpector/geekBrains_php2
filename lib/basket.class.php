<?php


class Basket
{
    private static $_instance = null;

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Basket(); //создается объект класса db, файл db.class.php
        }
        return self::$_instance;
    }

    // метод для удаления товара из корзины
    public function delete($id){
        $user_id = $_SESSION['id_user'];
        $sql['sql'] = "delete from cart where good_uid = :good_uid and user_id = :user_id";
        $sql['param'] = [
            'good_uid' => $id,
            'user_id' => $user_id,
        ];
        db::getInstance()->Query($sql['sql'], $sql['param']);
        return '';
    }

    // метод для уменьшения количества товаров в корзине
    public function reduce($id){
        $user_id = $_SESSION['id_user'];
        $sqlQuantity = "select quantity from cart where good_uid = '$id'";
        $quantityOfAddedProduct = db::getInstance()->SelectRow($sqlQuantity)['quantity']; // получить количество товаров
            $sql['sql'] = "update cart set quantity = :quantity where good_uid = :id and user_id = :user_id";
            $sql['param'] =
                [
                    'quantity' => --$quantityOfAddedProduct,
                    'id' => $id,
                    'user_id' => $user_id,
                ];
            db::getInstance()->Query($sql['sql'], $sql['param']);

            if ($quantityOfAddedProduct <= 0){
                self::getInstance()->delete($id);
                return '';
            }

        return $result = [
            'good_uid' => $id, // uid товара
            'newQuantity' => $quantityOfAddedProduct,
        ];
    }

    // метод для добавления товара в корзину
    public function add($id)
    {
        $user_id = $_SESSION['id_user'];
        $sqlQuantity = "select quantity from cart where good_uid = '$id'";
        $quantityOfAddedProduct = db::getInstance()->SelectRow($sqlQuantity)['quantity']; // получить количество товаров
        if ($quantityOfAddedProduct > 0) { // если товар уже был в корзине, обновить количество
            $sql['sql'] = "update cart set quantity = :quantity where good_uid = :id and user_id = :user_id";
                $sql['param'] =
                    [
                        'quantity' => ++$quantityOfAddedProduct,
                        'id' => $id,
                        'user_id' => $user_id,
                    ];
                db::getInstance()->Query($sql['sql'], $sql['param']);
        } else { // если товара еще не было, добавить его в корзину
            $quantityOfAddedProduct = 1;
            $sql['sql'] = 'insert into cart (good_uid, user_id, quantity) value (:product_uid, :user_id, :quantity)';
            $sql['param'] = [
                'product_uid' => $id,
                'user_id' => $user_id,
                'quantity' => $quantityOfAddedProduct
            ];
            db::getInstance()->Query($sql['sql'], $sql['param']);
        }
        return $result = [
            'good_uid' => $id, // uid товара
            'newQuantity' => $quantityOfAddedProduct,
        ];
//        Debug::Deb($sql);
    }

    // метод оформления заказа
    public function placeOrder(){
        $user_id = $_SESSION['id_user'];

        // создать в таблице с заказами нового заказа
        $dateNow = time();
        $sql['sql'] = "insert into orders_data (time_order, user_id) values (:time_order, :user_id)";
        $sql['param'] = [
            'time_order' => $dateNow,
            'user_id' => $user_id
        ];
        // создать новый заказ и вернуть его id
        $orderId = db::getInstance()->InsertAndReturnID($sql['sql'], $sql['param']);

        // перенос товаров из таблицы cart в таблицу order и объединение этого с данными заказа (id, время заказа, юзер)
        $sql = "insert into orders (good_uid, user_id, quantity, time_order, order_id)
          select good_uid, cart.user_id, quantity, time_order, orders_data.id from cart left outer join orders_data on cart.user_id = orders_data.user_id where orders_data.id = $orderId";
        db::getInstance()->Query($sql);

        // удаление товаров из корзины
        $sql1['sql'] = "delete from cart where user_id = :user_id";
        $sql1['param'] = [
            'user_id' => $user_id
        ];
        db::getInstance()->Query($sql1['sql'], $sql1['param']);

        return $orderId; // вернуть номер нового заказа
    }

    // получить информацию о товарах в заказе
    public function getOrder(){
        $user_id = $_SESSION['id_user'];
        $order_id = $_POST['id'];
        $sql = "select * from orders inner join goods on orders.good_uid = goods.ID_UUID where user_id = $user_id and order_id = $order_id";
        $result = db::getInstance()->Query($sql);
        return $result;
    }

    // получить все статусы заказов
    public function getStatuses(){
        $sql = "select * from order_status";
        $result = db::getInstance()->Select($sql);

//		Debug::Deb($result);

        return $result;
    }

    // изменить статус заказа
    public function changeStatus(){
        $order_id = $_POST['id'];
        $newStatus = $_POST['statusName'];
        $sql = "select id from order_status where status_name = '$newStatus'";
        $result = db::getInstance()->SelectRow($sql)['id'];
//        echo $result;
        $sql2['sql'] = "update orders_data set status = :status where id = :id";
        $sql2['param'] = [
            'status' => $result,
            'id' => $order_id,
        ];
        db::getInstance()->Query($sql2['sql'], $sql2['param']);
        $result = "Изменен";
//        		Debug::Deb($result);

        return $result;
    }

}

//
//class Basket
//{
//
////Метод, показывающий общую информацию о корзине. В данный момент представленна в виде заглушки
//    public static function basketInfo()
//    {
//        //Стоимость корзины
//        $basket_price = 100;
//        //Количество наименований товаров в корзине
//        $basket_count = 10;
//        //Общее количество товаров в корзине
//        $basket_count_good = 15;
//
//        //Составим массив для отправки в браузер
//        $result['basket_count_good'] = $basket_count_good;
//        $result['basket_count'] = $basket_count;
//        $result['basket_price'] = $basket_price;
//
//        return $result;
//    }
//
////В случае, если пользователь авторизован, то берем корзину из БД и сохраняем ее в сессии
//    public static function basketIsAuth()
//    {
//        $id_user = $_SESSION['IdUserSession'];
//        $sql = "select * from basket where id_user = (select id_user from users_auth where hash_cookie = '$id_user')";
//        $basket_db = getAssocResult($sql);
//
//        foreach ($basket_db as $key => $value) {
//            $basket[$value['ID_UUID']] = $value['count'];
//        }
//
//        $_SESSION['basket'] = $basket;
//    }
//
////Соединяем корзину из сессии с корзиной из cookie
//    public static function BasketSessionCookie()
//    {
//        if ($_SESSION['basket']) {
//            $mass_basket_json = json_decode($_COOKIE['basket'], true);
//            if (is_array($mass_basket_json)) {
//                $basket = array_merge($mass_basket_json, $_SESSION['basket']);
//            }
//        }
//
//        $_SESSION['basket'] = $basket;
//    }
//
//
////Добавление товара в корзину
//    public static function addGoods($data_product_guid, $count_goods = 1, $isAuth = false)
//    {
//        $basket = $_SESSION['basket'];
//
//        $count_goods = $count_goods == '' ? 1 : (int)$count_goods;
//
////	$basket[$data_product_guid] = $count_goods;
//
//        $basket[$data_product_guid] = isset($basket[$data_product_guid]) ? $basket[$data_product_guid] + 1 : 1;
//
//
//        if ($isAuth) {
//
//            $idUserSession = $_SESSION['IdUserSession'];
//
//
//            //Создадим ззапрос для проверки наличия записи в БД
//            $sql['sql'] = "select * from basket where ID_UUID = :data_product_guid and id_user = (select id_user from users_auth where hash_cookie = :idUserSession)";
//            $sql['param'] =
//                [
//                    'data_product_guid' => $data_product_guid,
//                    'idUserSession' => $idUserSession,
//                ];
//
//            $goods_basket = db::getInstance()->SelectRow($sql['sql'], $sql['param']);
//
//
//            $id = $goods_basket['id'];
//            if ($goods_basket) //Если товар имеется в корзине
//            {
//                $sql['sql'] = "update basket set count = :count_goods where id = :id";
//                $sql['param'] =
//                    [
//                        'id' => $id,
//                        'count_goods' => $basket[$data_product_guid],
//                    ];
//                db::getInstance()->Query($sql['sql'], $sql['param']);
//            } else {
//                $sql['sql'] = "insert into basket (id_uuid, count, id_user) value (:data_product_guid, :count_goods, (select id_user from users_auth where hash_cookie = :idUserSession));";
//                $sql['param'] =
//                    [
//                        'data_product_guid' => $data_product_guid,
//                        'count_goods' => $count_goods,
//                        'idUserSession' => $idUserSession,
//                    ];
//                db::getInstance()->Query($sql['sql'], $sql['param']);
//            }
//
//        }
//
//        $_SESSION['basket'] = $basket;
//
//
//        Debug::SessCookClear();
//        Debug::DebugAll($data_product_guid, $count_goods, $_SESSION, $goods_basket);
//
//        $mass_basket_json = json_encode($basket);
//        setcookie('basket', $mass_basket_json, TIME_COOKIE_BASKET, '/');
//        return $result;
//    }
//
//
////Очистка корзины полная или выборочная запись
//    public static function ClearBasket($isAuth = false, $uuid = NULL)
//    {
//        $basket = $_SESSION['basket'];
//
//        if ($uuid) {
//            unset($basket[$uuid]);
//            if ($isAuth) {
//                $sql = "DELETE FROM `basket` WHERE `basket`.`ID_UUID` = '$uuid';";
//                executeQuery($sql);
//            }
//        } else {
//            if ($isAuth) {
//                $idUserSession = $_SESSION['IdUserSession'];
//                $sql = "DELETE FROM `basket` WHERE `basket`.`id_user` = (select id_user from users_auth where hash_cookie = '$idUserSession');";
//                executeQuery($sql);
//            }
//            unset($basket);
//        }
//
//        $_SESSION['basket'] = $basket;
//        $mass_basket_json = json_encode($basket);
//        setcookie('basket', $mass_basket_json, TIME_COOKIE_BASKET, '/');
//        return $result;
//    }
//
//}
//
?>