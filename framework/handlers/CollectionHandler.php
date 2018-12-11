<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/5
 * Time: 19:51
 */

namespace Framework\Handlers;


use Framework\App;
use Framework\Interfaces\HandleInterface;

class CollectionHandler implements HandleInterface
{
    protected $items;

    public function register(App $app)
    {

    }

    public function __construct($items = [])
    {
        $this->items = $this->getArrayAbleItems($items);
    }

    public function pop()
    {
        array_pop($this->items);
        return $this;
    }

    public function shift()
    {
        array_shift($this->items);
        return $this;
    }

    public function unShift($item)
    {
        array_unshift($this->items, $item);
        return $this;
    }

    public function toArray()
    {
        return $this->items;
    }

    public function only(array $keys)
    {
       if (!$keys || !array_filter($keys)) {
           return new static($this->items);
       }

       return new static();

    }

    public function filter(callable $callable) {
        if (!$callable) {
            $this->items = array_filter($this->items);
        }

        $this->items = array_filter($this->items, $callable);
    }

    public function first()
    {
        return reset($this->items);
    }

    public function end()
    {
        return reset(array_reverse($this->items));
    }


    public function get($key = null)
    {
        if ($key === null) {
            return $this;
        }

        if (array_key_exists($key, $this->items)) {
            $this->items = $this->items[$key];
            return $this;
        }
    }

    /**
     * @param $items
     * @return mixed
     */
    protected function getArrayAbleItems($items)
    {
        if (is_array($items)) {
            return $items;
        }

        echo __METHOD__;
        die;
    }
}