<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/11/21 下午 10:15
 *
 **/

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'mail' => 'email'
    ];
}