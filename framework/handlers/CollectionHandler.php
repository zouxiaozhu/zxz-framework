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
    public function getArrayAbleItems($items)
    {
        if (is_array($items)) {
            return $items;
        }

        echo __METHOD__;
        die;
    }
}