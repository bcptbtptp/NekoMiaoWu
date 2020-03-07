<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 上午 9:35
 *
 **/

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id','delete_time','product_id'];

    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}