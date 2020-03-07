<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 7:58
 *
 **/

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}