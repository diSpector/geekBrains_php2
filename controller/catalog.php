<?php
$db = db::getInstance();
$db->Connect('root', 'mysql', 'php2-4'); // поключение к БД

// первичная загрузка каталога
$query = "select * from categories"; // выбрать все записи из таблицы категорий
$allEntriesFromCategories = $db->Select($query, []);
$categories = []; // массив со всеми данными из таблицы categories, сгруппированный по категориям
$subCategories = []; // массив с подкатегориями для проверки url
foreach ($allEntriesFromCategories as $entry){ // создаем массив категорий и подкатегорий
    switch ($entry['parent_id']){
        case '0':
            $categories[] = $entry;
            break;
        case '1':
            $categories[0]['sub_category'][] = $entry;
            $subCategories[] = $entry['url'];
            break;
        case '2':
            $categories[1]['sub_category'][] = $entry;
            $subCategories[] = $entry['url'];
            break;
        default:
            echo 'Ошибка категории';
            break;
    }
}

// если третьего фрагмента адреса строки нет в подкатегориях, загрузить главную страницу каталога,
// иначе загрузить страницу ПОДкаталога
if (!in_array($dirs[3], $subCategories)){
    // передать данные в шаблон
    $template = $twig->LoadTemplate('catalog/index.php');
    echo $template->render(array(
            'domain'=>'/',
            'content_data' => $categories)
    );
} else { // загрузка подкаталога
    $query = "select id_category, name from categories where url = '$dirs[3]'"; // выбрать id, название подкаталога
    $dataForSubCatalog = $db->Select($query);
    $idCategory = $dataForSubCatalog[0]['id_category']; // id подкаталога
    $nameCategory = $dataForSubCatalog[0]['name']; // название подкаталога

    // посчитать количество товаров в данном подкаталоге
    $query= "select COUNT(*) as count from goods where id_category = '$idCategory'";
    $queryCount = $db->Select($query);
    $quantity = $queryCount[0]['count'];

    // загрузить первые $howMany товаров из подкаталога
    $start = 0;
    $howMany = 25;
    $query = "select * from goods where id_category = '$idCategory' limit $howMany";
    $allGoodsFromSubCategory = $db->Select($query);
    $currentRecord = $start + $howMany;

    $out_row = ($currentRecord < $quantity) ? true : false;

    // передать данные в шаблон
    $template = $twig->LoadTemplate('catalog/sub_catalog.php');
    echo $template->render(array(
            'domain'=>'/',
            'content_data' => array(
                'name' => $nameCategory,
                'catalog' => $allGoodsFromSubCategory,
                'category' => $idCategory,
                'current_record' => $currentRecord,
                'out_row' => $out_row
                )
    ));
}

