<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/19 下午 1:59
 *
 **/

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'update_time', 'delete_time'];
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    public static function getSummaryByPage($page=1, $size=20){
        $pagingData = self::order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }

    public static function getSummaryByUser($uid, $page=1, $size=15){
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }

    public function getSnapItemsAttr($value)    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode(($value));
    }
}