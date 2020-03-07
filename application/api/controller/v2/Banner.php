<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/11/21 下午 9:53
 *
 **/

namespace app\api\controller\v2;


class Banner
{
    /**
     * 获取指定id的banner信息
     * @param $id banner的id号
     * @param http GET
     */
    public function getBanner($id)
    {
        return 'This is v2 version test';
    }
}