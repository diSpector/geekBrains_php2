<?php

class IndexModel extends Model
{
    public $view = 'index';
    public $title;


    public function index_old($data) //Метод рассмотренный на уроке
	{
        parent::index();
        $this->title .="Главная страница";
		$result['top_product'] = db::getInstance()->Select('select * from goods order by view desc, date desc limit 3');
		$result['new_product'] = db::getInstance()->Select('select * from goods order by date desc limit 3');
		$result['sale_product'] = db::getInstance()->Select('select * from goods where status = "2" order by view desc limit 3');
		
		return $result;
    }
	

    public function index($data = NULL, $deep = 0) 	//Метод с использованием классов для вывода категорий товаров
	{			
		$result['top_product'] = Product::TopProduct();
		$result['new_product'] = Product::NewProduct();
		$result['sale_product'] = Product::StatusProduct();
		
		
		return $result;
    }




}