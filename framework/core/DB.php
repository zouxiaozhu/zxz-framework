<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/4/27
 * Time: 14:07
 */

namespace Framework\Core;
use Framework\App;
use Framework\Exceptions\ZxzHttpException;

class DB {
    protected $database_group;

    protected $db_strategy_map  = [
        'mysql' => 'Framework\Orm\Db\Mysql'
    ];

    public function __construct()
    {

    }

    /**
     * @param string $table_name
     * @return DB
     * @throws ZxzHttpException
     */
    public static function table($table_name = '' )
    {
        if ( !$table_name ){
            throw new ZxzHttpException('504', 'DOESNOT SET TABLENAME');
        }

        $db = new self();

        $prefix = env('DB_PREFIX', '');
        $table_name = $prefix ? trim($prefix).'_'.$table_name : trim($table_name);
        $db->_table_name = $table_name;
        return $db;
    }

    public function where($where = [])
    {
        if (empty($data)){
            return [];
        }
        $this->where = ' 1 = 1';
        foreach ((array) $where as $k => $v) {
            if ( ! is_array($v)){
                $this->where .= " `$k` = :{$k} ";
                $this->bindParams[$k] = $v;
                continue;
            }

            $this->where = "  `$k` IN (:{$k})";
            $this->bindParams[$k] = implode(',', $v);
        }

        return $this;
    }

    public function select($data = [])
    {

        if ( (is_array($data) && count($data) != count($data, 1)) ||)
        {
            return new ZxzHttpException(400, 'field error');
        }

        if (is_array($data)){
            $field = join(',', $data);
        }

        $field = $field ? : $field;
        $this->select = $field;
    }

    public function orderBy($field = '', $sort = 'ASC')
    {
        $this->order_by .= "order by {$field} {$sort}";
        return $this;
    }


    public function limit($start = 0, $len = 0)
    {
        if ( ! ctype_digit(strval($start))) {
            return new ZxzHttpException(400, ' offset illegle');;
        }

        if ( ! ctype_digit(strval($len))) {
            return new ZxzHttpException(400, 'limit illegle')
        }

        $this->limit = "limit {$start}";
        if ($len) {
            $this->limit .= "{$len}";
        }

        return $this;
    }

}
