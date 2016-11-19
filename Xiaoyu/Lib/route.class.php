<?php
namespace Xiaoyu\Lib;

/**
 *
 * @author 小鱼
 * @wechat 34734852
 * @file rout.class.php
 * 路由类
 */

class route
{

    public $module;

    public $controller;

    public $action;

    public function __construct()
    {
        if (! empty($_SERVER['PATH_INFO'])) {
            $this->layout();
            $this->dispatch();
        } else {
            $this->url_dispatch();
        }
    }
    // 路由解析
    private function layout()
    {
        $urlPath = strtolower($_SERVER["REQUEST_URI"]);
        if (SYSDIR != NULL) {
            $info = str_replace(strtolower(SYSDIR), '', str_replace('index.php', '', $urlPath));
            $urlPath = preg_replace('/^\/+/', '', $info);
        } else {
            $urlPath = strtolower($_SERVER["REQUEST_URI"]);
        }
        if (isset($urlPath) && $urlPath != '/') {
            $urlArr = explode('/', trim($urlPath, '/'));
            if (isset($urlArr[0])) {
                $this->module = $urlArr[0];
                unset($urlArr[0]);
            } else {
                $this->module = 'home';
            }
            if (isset($urlArr[1])) {
                $this->controller = $urlArr[1];
                unset($urlArr[01]);
            } else {
                $this->controller = 'index';
            }
            if (isset($urlArr[2])) {
                $this->action = $urlArr[2];
                unset($urlArr[2]);
            } else {
                $this->action = 'index';
            }
            $count = count($urlArr) + 3;
            $i = 3;
            while ($i < $count) {
                if (isset($urlArr[$i + 1])) {
                    $_GET[$urlArr[$i]] = $urlArr[$i + 1];
                }
                $i = $i + 2;
            }
        } else {
            $this->module = 'home';
            $this->controller = 'index';
            $this->action = 'index';
        }
    }
    // 路由分发
    private function dispatch()
    {
        $module_name = strtolower(! empty($this->module) && $this->module != 'index.php' ? $this->module : 'home');
        $controller_name = strtolower(! empty($this->controller) ? $this->controller . 'Controller' : 'IndexController');
        $action_name = strtolower(! empty($this->action) ? $this->action : 'index');
        $classfile = strtolower(APP_PATH . $module_name . DS . 'Controller' . DS . $controller_name . '.class.php');
        
        if (file_exists($classfile)) {
            include $classfile;
            $newController = new $controller_name();
            if (method_exists($newController, $action_name)) {
                $newController->$action_name();
            } else {
                echo "<pre>";
                throw new \Exception('找不到方法' . $action_name);
            }
        } else {
            echo "<pre>";
            throw new \Exception('找不到控制器' . $controller_name);
        }
    }
    // 路由分发模式2
    // 例：index.php?m=home&c=index&a=index
    private function url_dispatch()
    {
        $newModule = strtolower(isset($_GET['m']) ? $_GET['m'] : 'home');
        $newController = strtolower(isset($_GET['c']) ? $_GET['c'] . 'Controller' : 'indexController');
        $newAction = strtolower(isset($_GET['a']) ? $_GET['a'] : 'index');
        $classFile = strtolower(APP_PATH . $newModule . DS . 'Controller' . DS . $newController . '.class.php');
        
        if (file_exists($classFile)) {
            include $classFile;
            $Controller = new $newController();
            if (method_exists($Controller, $newAction)) {
                $Controller->$newAction();
            } else {
                echo "<pre>";
                throw new \Exception('无法加载方法' . $newAction);
            }
        } else {
            echo "<pre>";
            throw new \Exception('无法加载控制器' . $newController);
        }
    }
}