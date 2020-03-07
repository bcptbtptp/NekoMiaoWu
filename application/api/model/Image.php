<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/5 下午 10:04
 *
 **/

namespace app\api\model;


use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id','from','update_time','delete_time'];

    public function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }
}