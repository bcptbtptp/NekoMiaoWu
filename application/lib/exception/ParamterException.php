<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/3 下午 11:06
 *
 **/

namespace app\lib\exception;


class ParamterException extends BaseException
{
    public $code = 400;
    public $msg = 'Parameter invalid.';
    public $errorCode = 10000;
}