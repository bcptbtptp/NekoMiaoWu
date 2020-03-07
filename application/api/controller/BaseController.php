<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 5:06
 *
 **/

namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }
}