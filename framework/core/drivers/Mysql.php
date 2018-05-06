<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-5-6
 * Time: 下午9:34
 */
namespace Framework\Core\Drivers;
class Mysql{
    public function __construct(
        $host = '',
        $dbname = '',
        $username = '',
        $password = '')
    {
        $this->dbhost   = $host;
        $this->dbname   = $dbname;
        $this->dsn      = "mysql:dbname={$this->dbname};host={$this->dbhost};";
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect()
    {
        $this->pdo = new PDO(
            $this->dsn,
            $this->username,
            $this->password
        );
    }

    /**
    * 魔法函数__get
    *
    * @param  string $name  属性名称
    * @return mixed
    */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set
     *
     * @param  string $name   属性名称
     * @param  mixed  $value  属性值
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }
}