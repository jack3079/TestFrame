<?php
namespace Xiaoyu;


use Xiaoyu\Database\Mysql;
/**
 *
 * @author 小鱼
 * @wechat 34734852
 * @file xiaoyu.php
 * 核心启动类，自动加载
 */
class xy
{

    public static $classFile = array();

    static public function run()
    {
        self::autoload();
        new \Xiaoyu\Lib\route();
        new mysql();
        
    }
    
    
    // 自动加载
    static private function autoload()
    {
        spl_autoload_register('self::load');
    }

    static private function load($className)
    {
        if (isset(self::$classFile[$className])) {
            echo "<pre>";
            throw new \Exception('您已经加载过该文件！');
        } else {
            $fileName = strtolower($className . '.class.php');
            if (file_exists($fileName)) {
                require($fileName);
                self::$classFile[$className] = $className;
            } else {
                echo "<pre>";
                throw new \Exception('您要加载的文件不存在！');
            }
        }
    }
}