<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
session_start();

require_once 'autoload.php'; //подключаем файл с методами автозагрузки классов	

try{

}
catch (PDOException $e){
    echo "DB is not available";
    var_dump($e->getTrace());
}
catch (Exception $e){
    echo $e->getMessage();
}

?>