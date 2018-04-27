<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午10:50
 */

namespace Framework\Traits;

trait ErrorTrait{
    public function exceptionHandler($exception)
    {
        $this->info = [
            'code'       => $exception->getCode(),
            'message'    => $exception->getMessage(),
            'file'       => $exception->getFile(),
            'line'       => $exception->getLine(),
            'trace'      => $exception->getTrace(),
            'previous'   => $exception->getPrevious()
        ];

        $this->end();
    }

    /**
     * 脚本结束
     *
     * @return　mixed
     */
    private function end()
    {
        switch ($this->mode) {
//            case 'swooole':
//                ::reponseErrSwoole($this->info);
//                break;

            default:
                \Framework\Exceptions\ZxzHttpException::error($this->info);
            break;
        }
    }


}