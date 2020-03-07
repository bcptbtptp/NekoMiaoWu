<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 下午 2:37
 *
 **/

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定类目不存在，请检查参数';
    public $errorCode = 50000;
}