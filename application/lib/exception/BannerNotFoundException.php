<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/3 下午 10:09
 *
 **/

namespace app\lib\exception;


use think\Exception;

class BannerNotFoundException extends BaseException
{
    public $code = 400;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}