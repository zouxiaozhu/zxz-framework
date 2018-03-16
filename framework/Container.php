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

    public function setSingle($alias = '', $object = '')
    {
        if (is_callable($alias) || is_object($alias)) {
            $instance = is_callable($alias) ? $alias() : $alias;
            var_export(111);die;
            $className = get_class($instance);
var_export($className);die;
            if (array_key_exists($className, $this->instanceMap)) {
                return $this->instanceMap[$alias];
            }
            $this->instanceMap[$className] = $instance;
            var_export($this->instanceMap);die;
            return $this->instanceMap[$className];
        }

        if (is_callable($object)) {
            if (empty($alias)) {
                return new ZxzHttpException(
                    '403', 'no alias for instance');
            }

            if (array_key_exists($alias, $this->instanceMap)) {
                return $this->instanceMap[$alias];
            }

            $this->instanceMap[$alias] = $object();
            return $object();
        }

        if(is_object($object)){
            if(empty($object)){
                throw new ZxzHttpException('403', 'empty'.get_class($object));
            }
            $this->instanceMap[$alias] = $object;
            return $object;
        }

        $this->instanceMap[$alias] =  new $alias();
        return $this->instanceMap[$alias];
    }

}

