<?php
class AccountModel extends Model
{
    public $view = 'account';
    public $title;

    function __construct()
    {
        parent::__Construct();
        $this->title .= "Личный Кабинет";
    }

    public function index($data = NULL, $deep = 0)
    {
        $user_id = $_SESSION['id_user'];

        $sql = "select orders_data.id, status_name from orders_data inner join order_status on orders_data.status = order_status.id where user_id = $user_id";
//        $result = db::getInstance()->Select($sql);
        $result['orders'] = db::getInstance()->Select($sql);
        $sql = "select * from order_status";
        $result['statuses'] = db::getInstance()->Select($sql);

//		Debug::Deb($result);

        return $result;
    }

}

?>