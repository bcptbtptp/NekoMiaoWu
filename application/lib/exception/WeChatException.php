<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/8 下午 3:47
 *
 **/

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}