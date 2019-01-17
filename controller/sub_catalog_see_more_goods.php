<?php
// переменные для вывода товаров по клику на кнопку "Загрузить еще"
$count = $_POST['count'];
$category = $_POST['category'];
$current_record = $_POST['current_record'];
$db = db::getInstance();
$db->Connect('root', 'mysql', 'php2-4'); // поключение к БД

// посчитать количество товаров в подкаталоге
$query= "select COUNT(*) as count from goods where id_category = '$category'";
$queryCount = $db->Select($query);
$quantity = (int)$queryCount[0]['count'];

// загрузить следующие $howMany товаров из подкаталога
$start = $current_record;
$howMany = 25;
$current_record = $current_record + $howMany;
$query = "select * from goods where id_category = '$category' limit " . $start . ", " . " $howMany";
$goodsFromSubCategory = $db->Select($query);

// если общее количество товаров в подкаталоге больше количества уже загруженных, отобразить кнопку "Показать еще"
$out_row = ($quantity > $current_record) ? true : false;

// передать данные в шаблон
$template = $twig->LoadTemplate('catalog/product_catalog.php');
echo $template->render(array(
    'domain'=>'/',
    'content_data' => array(
        'catalog' => $goodsFromSubCategory,
        'current_record' => $current_record,
        'category' => $category,
        'out_row' => $out_row,
    )
));