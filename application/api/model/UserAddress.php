<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 2:21
 *
 **/

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id','delete_time','user_id'];
}