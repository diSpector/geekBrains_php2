<?php

class CatalogModel extends Model    
{
    public $view = 'catalog';
    public $title;

	public function index()
	{
	    parent::index();
		$sql = "select * from categories inner join pages on categories.id_pages = pages.id where categories.parent_id = 0";
		$result = db::getInstance()->Select($sql);
		$sql = "select * from categories INNER JOIN pages on categories.id_pages = pages.id where categories.parent_id in (SELECT categories.id_category from categories WHERE parent_id = 0)";
		$results = db::getInstance()->Select($sql);

		foreach ($result as $key=>$value)
		{
			foreach ($results as $keys=>$values)
			{
				if ($values['parent_id'] == $value['id_category'])
				{
					$result[$key]['sub_category'][] = $results[$keys];
				}
			}
		}
//		Debug::Deb($result);
		return $result;
	}

    public function __call($methodName, $args){
	    echo "Нет метода";
    }

}