<?php
class cartModel extends Model
{
    public $view = 'cart';
    public $title;

    function __construct()
    {
        parent::__Construct();
        $this->title .= "Корзина";
    }

    public function index($data = NULL, $deep = 0)
    {
        $user_id = $_SESSION['id_user'];
//        $sql = "select good_uid, quantity from cart where user_id = $user_id";
        $sql = "select good_uid, quantity, id_good, name, price from cart inner join goods on cart.good_uid = goods.ID_UUID where cart.user_id = $user_id";
        $result = db::getInstance()->Select($sql);
        foreach ($result as $key=>$value){
            $results[] = array(
                'name' => $value['name'],
                'quantity' => $value['quantity'],
                'price' => $value['price'],
                'id_good' => $value['id_good'],
                'uid_good' => $value['good_uid'],
            );
        }

//select good_uid, quantity, id_good, name, price from cart inner join goods on cart.good_uid = goods.ID_UUID where cart.user_id = 1;

//        $sql = "select * from categories INNER JOIN pages on categories.id_pages = pages.id where categories.parent_id = $deep;";
//        $result = db::getInstance()->Select($sql);
//
//        $sql = "select * from categories inner join pages on categories.id_pages = pages.id where categories.parent_id in (select categories.id_category from categories where parent_id = $deep)";
//        $results = db::getInstance()->Select($sql);

//        foreach ($result as $key=>$value)
//        {
//            foreach ($results as $keys=>$values)
//            {
//                if ($values['parent_id'] == $value['id_category'])
//                {
//                    $result[$key]['sub_category'][] = $results[$keys];
//                }
//            }
//        }

//		Debug::Deb($result);

        return $results;
    }

}

?>