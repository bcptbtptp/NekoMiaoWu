<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/11/21 下午 10:41
 *
 **/

namespace app\api\validate;


use think\Validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'ID必须为正整数'
    ];
}