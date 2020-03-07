<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 下午 2:04
 *
 **/

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
      'count' => 'isPositiveInteger|between:1,15'
    ];
}