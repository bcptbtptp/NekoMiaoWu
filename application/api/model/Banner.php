<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/11/22 下午 8:51
 *
 **/

namespace app\api\model;


use app\api\model\Banner as BannerModel;
use think\Db;
use think\Exception;
use think\Model;

class Banner extends BaseModel
{
    protected $hidden = ['update_time','delete_time'];
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
    //protected $table = 'category';
    //php think make:model api/:ModelName
    //根据Banner ID号获取Banner信息
    public static function getBannerByID($id){
        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
}