<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/21 下午 3:35
 *
 **/

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数'
    ];
}