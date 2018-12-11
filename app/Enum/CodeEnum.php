<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/7
 * Time: 下午4:40
 */

namespace App\Enum;

use Zl\Compose\Enums\Enums;

class CodeEnum extends Enums
{
    const AMQP_CONN_ERROR = 9999;

    public static function getEnum($alias)
    {
        $constants = parent::getConstants();
        if (!($constants[$alias] ?? '')) {
            return 10000;
        }

        return $constants[$alias];
    }

}




