<?php

function getAssocResult($sql){
    $result = executeQuery($sql);
    $arrayResult = array();
    if (!$result) {
        return 0;
    } else {
        while ($row = $result->fetch()) {
            $arrayResult[] = $row;
        }
        $result = null;
        return $arrayResult;
    }
}

function getRow($sql){
    $result = executeQuery($sql);
    if (!$result) {
        return 0;
    } else {
        return $result->fetch();
    }
}

function executeQuery($sql){
    $db = connect();
    $sth = $db->query($sql);
    var_dump($sth);
    $db = null;
    return $sth;
}

function connect() {
    try{
        $db = new PDO('mysql:host=' . HOST . ';dbname=' . DB, USER, PASS);
        $db->exec('SET CHARACTER SET utf8');
        return $db;
    }
    catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

function readOneProduct($id){
    return getRow("select * from products where id = $id");
}