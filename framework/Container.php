<?php

namespace Framework;
use Framework\Exceptions\ZxzHttpException;

class Container{
    private $classMap = [];
    public  $instanceMap = [];

    /**
     * 注入一个类
     *
     * inject a class
     * @params string $alias      类别名
     * @params string $objectName 类名
     * @return object
     */
    public function set($alias= '', $objName = '')
    {
        $this->classMap[$alias] = $objName;
        if (is_callable($objName)){
            return $objName();
        }
        return new $objName;
    }

    // 获取对象的实例
    public function get($alias = '')
    {
        if (!array_key_exists($alias, $this->classMap)){
            throw new ZxzHttpException('404', 'Class '.$alias);
        }

        if (is_callable($this->classMap[$alias])){
            return $this->classMap[$alias]();
        }

        if (is_object($this->classMap[$alias])){
            return $this->classMap[$alias];
        }
    }

    public function setSingle($alias = '', \Closure $singleton)
    {

    }
}

