<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/8 下午 12:28
 *
 **/

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
      'code' =>  'require|isNotEmpty'
    ];

    protected $message = [
      'code' => '没有Code没有Token'
    ];
}