<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/19
 * Time: 下午5:28
 */
namespace App\Model;
use Framework\Core\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'user';
    protected $guarded = [];
    public $timestamps = false;
}