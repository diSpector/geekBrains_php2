<?php
$template = $twig->LoadTemplate('product.html'); // загрузить шаблон для вывода инфо об одном товаре
$db = DB_PDO::getDB(); // получить экземпляр соединения с БД
$productData = $db::readOneProduct($id); // получить данные о товаре из ДЗ, а затем передать их в шаблон
echo $template->render(array(
    'title'=>'Карточка товара',
    'name'=>'Карточка товара',
    'productData' => $productData,
    'img_dir' => IMG_DIR
));