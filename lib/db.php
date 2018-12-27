<?php

function getAssocResult($sql){
    $result = executeQuery($sql);
    if (!$result) {
        return 0;
    } else {
        $arrayResult = array();
        while($row = mysqli_fetch_assoc($result))
            $arrayResult[] = $row;

        return $arrayResult;
    }
}

function executeQuery($sql){
    $db = connect();
    $result = mysqli_query($db, $sql);
    $num = mysqli_num_rows($result);
    if (!$num) {
        return 0;
    }
    mysqli_close($db);
    return $result;
}

// экранирование строки
function escapeString($str){
    return mysqli_real_escape_string(connect(),(string)htmlspecialchars(strip_tags($str)));
}

function connect() {
    $db = mysqli_connect(HOST, USER, PASS, DB);
    // по умолчанию кодировка latin, далее устанавливаем ее в UTF8, чтобы корректно отображалась кириллица
    mysqli_set_charset ( $db , 'UTF8' );
    if (!$db) {
        echo 'Ошибка: Невозможно установить соединение с MySQL.'. PHP_EOL;
        exit;
    }

    return $db;
}

// добавить нового пользователя
function addNewUser($name, $password, $realname){
    $db = connect();
    $sql = "insert into users (name, password, realname) values ('$name','$password','$realname')";
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    return $result;
}

function addGoodForUser($userId, $productId, $quantity = 1){
    $db = connect();
    $sql = "insert into cart (userid, productid, productquant) values ('$userId','$productId','$quantity')";
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    return $result;
}

function deleteGoodForUser($userId, $productId){
    $db = connect();
    $sql = "delete from cart where userid = '$userId' and productid = '$productId'";
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    return $result;
}

function updateGoodForUser($userId, $productId, $newQuantity){
    $db = connect();
    $sql = "UPDATE cart SET productquant = '$newQuantity' WHERE userid = " . $userId . " AND productid = " .$productId;
    $result = mysqli_query($db, $sql);
    mysqli_close($db);
    return $result;
}

// прочитать все товары
function readFromProducts(){
    return getAssocResult('select * from products');
}

// прочитать один товар
function readOneProduct($id){
    return getAssocResult("select * from products where id =$id")[0];
}

// обновить товар
function updateOneProduct($id, $name, $description){
    $query1 = executeQuery("UPDATE products SET name = '$name' WHERE id = " . $id );
    $query2 = executeQuery("UPDATE products SET description = '$description' WHERE id = " . $id );
    return ($query1 && $query2);
}

function addNewProduct($name, $description){
    return executeQuery("insert into products (name, description) values ('$name', '$description')");
}

function deleteOneProduct($id){
    return executeQuery("delete from products where id = $id");
}

// создать отзыв
function createOneReview($author, $text){
    return executeQuery("insert into reviews (author, text) values ('$author', '$text')");
}

// прочитать все отзывы
function readFromReviews(){
    return getAssocResult('select * from reviews');
}

// прочитать один отзыв
function readOneReview($id){
    return getAssocResult("select * from reviews where id =$id")[0];
}

// удалить отзыв
function deleteOneReview($id){
    return executeQuery("delete from reviews where id = $id");
//    executeQuery("delete from reviews where id = $id");
//    return (mysqli_affected_rows(connect()) > 0);

}

// обновить отзыв
function updateOneReview($id, $author, $text){
    $query1 = executeQuery("UPDATE reviews SET author = '$author' WHERE id = " . $id );
    $query2 = executeQuery("UPDATE reviews SET text = '$text' WHERE id = " . $id );
    return ($query1 && $query2);
}