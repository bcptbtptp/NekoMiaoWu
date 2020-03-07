<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 上午 9:37
 *
 **/

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['id','product_id','delete_time'];
}