<?php
/* *
 * @File: index.php
 * #入口文件
 * @Auth:小鱼
 * @wechat:34734852
 *  */

//定义常量
define('DS', DIRECTORY_SEPARATOR);//路径分隔符/线
define('ROOT',getcwd().DS);//根目录
define('XIAOYU_PATH',ROOT.'Xiaoyu'.DS);//框架目录
define('CONF_PATH',XIAOYU_PATH.'Conf'.DS);//基础配置文件目录
define('API_PATH', XIAOYU_PATH.'Api'.DS);
define('DB_PATH', XIAOYU_PATH.'Database'.DS);
define('LIB_PATH', XIAOYU_PATH.'Lib'.DS);
define('TOOL_PATH', XIAOYU_PATH.'Tool'.DS);
define('APP_PATH', ROOT.'App'.DS);//定义应用目录
define('SYSDIR', 'CoopShop');//自定义网站所在目录，若非根目录，请在这里写上网站所在子目录
define('APP_CONFIG',APP_PATH.'Config'.DS);
define('APP_PUBLIC',APP_PATH.'Public'.DS);
define('APP_RUNTIME',APP_PATH.'RunTime'.DS);

define('DEBUG', TRUE);//默认调试模式开启
if(DEBUG){
   ini_set('display_errors','On');
}else{
    ini_set('display_errors','Off');
}
//打印
function p($expression){
    echo "<pre>";
    var_dump($expression);
}
//引入核心文件
include_once XIAOYU_PATH.'Xiaoyu.php';
Xiaoyu\xy::run();
