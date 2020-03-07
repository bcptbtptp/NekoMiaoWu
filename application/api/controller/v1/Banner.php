<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/11/21 下午 9:53
 *
 **/

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerNotFoundException;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @param $id banner的id号
     * @param http GET
     */
    public function getBanner($id){
        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if (!$banner){
            throw new BannerNotFoundException();
        }
        return $banner;
    }
}