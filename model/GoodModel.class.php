<?php

class GoodModel extends Model
{
    public $view = 'good';

    public function good($id){
        echo $id;
    }


    public function __call($methodName, $args){
        echo "Нет метода";
    }

}