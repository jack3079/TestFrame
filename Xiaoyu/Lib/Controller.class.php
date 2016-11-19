<?php
/**
 * @author 小鱼
 * @wechat:34734852
 * @file:Controller.class.php
 * 基础控制器类
 */
namespace Xiaoyu\Lib;

class Controller{
    
    public static $toolfile = array();
    
    public function __construct(){
        
    }
    //添加数据
    protected function add($table,$data=array()){
        
    }
    //修改数据
    protected function update($table,$where,$data=array()){
        
    }
    //删除
    protected function del($table,$where,$id){
        
    }
    //查询一条
    protected function find($table,$where){
        
    }
    //查询多条
    protected function select($table,$where){
        
    }
 
    //加载工具类
    protected function loadtool($filename){
        $xiaoyu_tool=TOOL_PATH.$filename.'.php';
        if(isset(self::$toolfile[$filename])){
            echo "<pre>";
            throw new \Exception('请不要重复加载'.$xiaoyu_tool);            
        }else{
            if (is_file($xiaoyu_tool)){
                include $xiaoyu_tool;
            }else{
                echo "<pre>";
                throw new \Exception('TOOL文件加载失败'.$xiaoyu_tool);
            
        }
      }
    }
}