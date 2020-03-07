<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/3 下午 10:06
 *
 **/

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    //HTTP 错误码
    public $code = 400;
    //错误信息
    public $msg = 'Parameter is invalid';
    //自定义错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        if (!is_array($params))
        {
            return;
            //throw new Exception('Parameter must be array.');
        }
        if (array_key_exists('code',$params))
        {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg',$params))
        {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode',$params))
        {
            $this->errorCode = $params['errorCode'];
        }
    }
}