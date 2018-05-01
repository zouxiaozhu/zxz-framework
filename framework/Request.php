<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-15
 * Time: 下午11:33
 */
namespace Framework;
class Request{
    /**
     * 请求header参数
     *
     * @var array
     */
    private $headerParams = [];

    /**
     * 请求server参数
     *
     * @var array
     */
    private $serverParams = [];

    /**
     * 请求所有参数
     *
     * @var array
     */
    private $requestParams = [];

    /**
     * 请求GET参数
     *
     * @var array
     */
    private $getParams = [];

    /**
     * 请求POST参数
     *
     * @var array
     */
    private $postParams = [];

    /**
     * cookie
     *
     * @var array
     */
    private $cookie = [];

    /**
     * file
     *
     * @var array
     */
    private $file = [];

    /**
     * http方法名称
     *
     * @var string
     */
    private $method = '';

    /**
     * 服务ip
     *
     * @var string
     */
    private $serverIp = '';

    /**
     * 客户端ip
     *
     * @var string
     */
    private $clientIp = '';

    /**
     * 请求开始时间
     *
     * @var float
     */
    private $beginTime = 0;

    /**
     * 请求结束时间
     *
     * @var float
     */
    private $endTime = 0;

    /**
     * 请求消耗时间
     *
     * 毫秒
     *
     * @var int
     */
    private $consumeTime = 0;

    /**
     * 请求身份id
     *
     * 每个请求都赋予唯一的身份识别id，便于追踪问题
     *
     * @var string
     */
    private $requestId = '';


    public function __construct(App $app)
    {
        $this->serverParams = $_SERVER;
        $this->method       = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
        $this->serverIp     = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : '';
        $this->clientIp     = isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR'] : '';
        $this->beginTime    = isset($_SERVER['REQUEST_TIME_FLOAT'])? $_SERVER['REQUEST_TIME_FLOAT'] : microtime(true);
        if ($app->runningMode === 'cli') {
            // cli 模式
            $this->postParams = $this->getParams  = $this->requestParams = isset($_REQUEST['argv'])? $_REQUEST['argv']: [];
            return;
        }

        $this->requestParams = $_REQUEST;
        $this->getParams     = $_GET;
        $this->postParams    = $_POST;

    }


    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {

        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name  属性名称
     * @param mixed  $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * ｇeｔ函数
     * @param string $name
     * @param string $default
     * @return null|string
     */
    public function get($name = '', $default = '')
    {

        if(!isset($this->getParams[$name])){
            return null;
        }

        if(empty($this->getParams[$name])){
           return trim($default);
        }

        return htmlspecialchars($this->getParams[$name]);

    }


    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function isMethod($method = ''){
        return $this->method === strtolower(trim($method));
    }


    /**
     * 11
     * @param  string $name 参数名
     * @return array
     */
    public function hasFile($name = '')
    {
        return [];
    }

    public function all( $name = '')
    {
        $res = array_merge($this->postParams, $this->getParams);
        if ( $name ) {
            return htmlspecialchars($res[$name]) ? : null;
        }
        foreach ($res as &$v) {
            $v = htmlspecialchars($v);
        }
        return $res;
    }

    /**
     * 获取SERVER参数
     *
     * @param  string $name 参数名
     * @return mixed
     */
    public function server($name = '')
    {
        if (isset($this->serverParams[$name])) {
            return $this->serverParams[$name];
        }
        return '';
    }






}