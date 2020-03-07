<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 上午 11:06
 *
 **/

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = 'User不存在';
    public $errorCode = 60000;
}