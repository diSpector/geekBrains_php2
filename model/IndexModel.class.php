<?php

class IndexModel extends Model
{
    public $view = 'index';
    public $title;

    function __construct()
    {	
		parent::__Construct();
		$this->title .= "Главная страница";

    }



    public function index($data = NULL, $deep = 0) 
	{			
		$result['top_product'] = Product::TopProduct();
		$result['new_product'] = Product::NewProduct();
		$result['sale_product'] = Product::StatusProduct();
		return $result;
    }





}