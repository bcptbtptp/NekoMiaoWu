<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/12 下午 4:10
 *
 **/

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}