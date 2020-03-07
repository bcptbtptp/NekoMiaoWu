<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/8 下午 1:26
 *
 **/

namespace app\api\model;


class User extends BaseModel
{
    public function address(){
        return $this->hasOne('UserAddress','user_id','id');
    }

    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)
            ->find();
        return $user;
    }


}