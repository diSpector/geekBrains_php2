<?php
class catalogModel extends Model
{
	public $view = 'catalog';
	public $title;
	
	function __construct()
	{
		parent::__Construct();
		$this->title .= "Товары";
	}
	
	
	public function index_old($data = NULL, $deep = 0)
	{
		$result['catalog'] = db::getInstance()->Select('SELECT * FROM `categories` where parent_id = "0";');
		foreach ($result['catalog'] as $key=>$value)
		{
			$result['catalog'][$key]['sub_category'] = db::getInstance()->Select('SELECT * FROM `categories` where parent_id = "'. $value['id_category'] .'";');
		}
		return $result;
	}

	
	public function index($data = NULL, $deep = 0)
	{
		$sql = "select * from categories INNER JOIN pages on categories.id_pages = pages.id where categories.parent_id = $deep;";
		$result = db::getInstance()->Select($sql);
		
		$sql = "select * from categories inner join pages on categories.id_pages = pages.id where categories.parent_id in (select categories.id_category from categories where parent_id = $deep)";
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

	
	
  public function __call($methodName, $args) 
  {
    $result = $this->sub_catalog($_GET['id']);

	return $result; 
  }
	
	
	public function sub_catalog($data, $nStart = 0, $count = 5)
	{
		$this->view .= "/" . __FUNCTION__ . '.php';
		$id = $data;
		$nEnd = $nStart + $count;
	
		$sql1 = "select parent_id from categories where id_pages = (select id from pages where url = '$id')";
		
		$sql1_1 = "select id_category from categories where id_pages = (select id from pages where url = '$id')";
		
		$sql_ = "select * from categories where id_category = ($sql1)";
		
		$sql = "select count(*) as count_record from goods where id_category = ($sql1_1)";
		
		$count_record = db::getInstance()->SelectRow($sql)['count_record'];
		
		$out_row = $count_record <= $nEnd ? FALSE : TRUE;
		
		$sql = "select * from goods where id_category = ($sql1_1) limit $nStart, $count";
		
		$result['catalog'] = db::getInstance()->Select($sql);
		$result['parent'] = db::getInstance()->Select($sql_);
		$result['category'] = $data;
		$result['current_record'] = $nEnd;
		$result['out_row'] = $out_row;
		
		return $result; 
	}	
	

	
}

?>