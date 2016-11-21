<?php
namespace Xiaoyu\Lib;

use Xiaoyu\Database\Mysql;

class Model extends Mysql{
    
    protected $table;//数据表
    protected $fieleds = array();//字段表
    
    function __construct($table){
        
        $this->table = $this->conf('DB_PREFIX').$table;
    }
    
    //获取数据表字段
    protected function getFields(){
        
    }
}