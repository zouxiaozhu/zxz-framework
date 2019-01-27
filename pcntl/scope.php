<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/27
 * Time: 5:27 PM
 */

class scope
{
    public $a = 1;

    public function test_scope($data, callable $callback)
    {
        echo $callback();
    }
}

class test
{
    public $a = 3;

    public function _test()
    {
        $scope = new scope();
        $scope->test_scope('1', function () {
            return $this->a;
        });
    }
}

$test = new test();

$test->_test();


// 结果居然是3  也就是$this 的作用域依然是test对象
// 结果居然是3  也就是$this 的作用域依然是test对象
// 结果居然是3  也就是$this 的作用域依然是test对象