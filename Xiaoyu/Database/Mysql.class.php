<?php
namespace Xiaoyu\Database;

/**
 * @author 小鱼
 * 数据库类
 * @Wechat 34734852      
 */
class Mysql
{

    protected static $config = array();

    protected $link = FALSE;
 // 数据库连接资源
    protected $sql;
 // SQL语句
    function __construct()
    {
        $this->conn();
    }

    /**
     *
     * @author 小鱼
     * 获取配置信息，项目CONFIG优先
     * @access protected
     * @param $name 配置项名称；$file 配置文件名称          
     */
    protected function conf($name, $file = 'Config')
    {
        $appConf = APP_CONFIG . $file . '.php';
        $confPath = CONF_PATH . $file . '.php';
        
        if (isset(self::$config[$name])) {
            echo "<pre>";
            throw new \Exception('配置项加载失败');
        } else {
            
            if (is_file($appConf)) {
                $config = include ($appConf);
                self::$config[$name] = $config;
                if (isset($config[$name])) {
                    return $config[$name];
                } else {
                    $config = include ($confPath);
                    return isset($config[$name]) ? $config[$name] : false;
                }
            } elseif (is_file($confPath)) {
                $config = include ($confPath);
                self::$config[$name] = $config;
                if (isset($config[$name])) {
                    return $config[$name];
                } else {
                    return false;
                }
            } else {
                echo "<pre>";
                throw new \Exception('配置文件加载失败');
            }
        }
    }
    // 连接数据库
    private function conn()
    {
        $this->link = @new \mysqli($this->conf('DB_HOST'), $this->conf('DB_USER'), $this->conf('DB_PWD'), $this->conf('DB_NAME'), $this->conf('DB_PORT'));
        if ($this->link->connect_errno) {
            $pathname = APP_RUNTIME . 'log';
            if (file_exists($pathname)) {
                file_put_contents($pathname . DS . date('Ymd') . 'error.log', '创建日期：' . date('Y-m-d H:i:s') . ', 数据库连接失败！-' . $this->link->connect_error . "\r\n", FILE_APPEND);
            } else {
                mkdir($pathname);
                file_put_contents($pathname . DS . date('Ymd') . 'error.log', '创建日期：' . date('Y-m-d H:i:s') . ', 数据库连接失败！-' . $this->link->connect_error . "\r\n", FILE_APPEND);
            }
            echo '<pre>';
            throw new \Exception('数据库连接失败' . $this->link->connect_error . ',错误编号：' . $this->link->connect_errno);
        }
        // 设置编码
        $this->link->set_charset($this->conf('DB_CHARSET'));
    }
    
    // 执行错误判断
    protected function db_query($sql)
    {
        $this->sql = addslashes($sql); // 转义
        $result = $this->link->query($sql);
        if (! $result) {
            
            $pathname = APP_RUNTIME . 'log';
            if (file_exists($pathname)) {
                file_put_contents($pathname . DS . date('Ymd') . 'error.log', '创建日期：' . date('Y-m-d H:i:s') . ', 错误信息：' . $this->link->errno . "-" . $this->link->error . "\r\n", FILE_APPEND);
            } else {
                mkdir($pathname);
                file_put_contents($pathname . DS . date('Ymd') . 'error.log', '创建日期：' . date('Y-m-d H:i:s') . ', 错误信息：' . $this->link->errno . "-" . $this->link->error . "\r\n", FILE_APPEND);
            }
            echo '<pre>';
            throw new \Exception('错误信息：' . $this->link->errno . "-" . $this->link->error);
        }
        return $result;
    }

    /**
     *
     * @author 小鱼
     * 获取一条记录
     * @access protected
     * @param $sql 查询的sql语句            
     * @return array 关联数组
     */
    protected function getOne($sql)
    {
        $result = $this->db_query($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        } else {
            echo '<p style="text-align:center";>暂无数据</p>';
        }
    }

    /**
     *
     * @author 小鱼
     * 获取所有条记录
     * @access protected
     * @param $sql 执行的sql语句            
     * @return $list 有所有记录组成的二维数组
     */
    protected function getAll($sql)
    {
        $result = $this->db_query($sql);
        $list = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        return $list;
    }
}

?>