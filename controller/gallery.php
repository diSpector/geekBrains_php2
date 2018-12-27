<?php
$db = DB_PDO::getDB(); // получить экземпляр соединения с БД
$products = $db::getAssocResult('select * from products'); // получить все данные о товарах из БД

if (isset($_GET['productId'])){ // если установлено значение ключа productId, перейти на страницу товара
    $id = $_GET['productId'];
    require_once '../controller/product.php';
} else { // иначе загрузить Галерею
    $template = $twig->LoadTemplate('gallery.html');
    echo $template->render(array(
        'title'=>'Каталог товаров',
        'name'=>'Галерея',
        'img_dir' => IMG_DIR,
        'products'=> $products
    ));
}

