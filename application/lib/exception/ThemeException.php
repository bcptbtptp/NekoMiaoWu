<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 下午 1:17
 *
 **/

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '请求主题不存在，请检查主题ID';
    public $errorCode = 30000;
}