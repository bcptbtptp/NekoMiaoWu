<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 4:04
 *
 **/

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public  $errorCode = 10001;
}