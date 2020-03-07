<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 上午 11:14
 *
 **/

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule=[
      'ids' => 'require|checkIDs'
    ];
    protected $message = [
       'ids' => 'ids参数必须是以逗号分割的多个正整数'
    ] ;
    protected function checkIDs($value)
    {
        $value = explode(',',$value);
        if (empty($value))
        {
            return false;
        }
        foreach ($value as $id)
        {
            if (!$this->isPositiveInteger($id))
            {
                return false;
            }
        }
        return true;
    }
}