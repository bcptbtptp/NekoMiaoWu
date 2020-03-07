<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 下午 2:30
 *
 **/

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}