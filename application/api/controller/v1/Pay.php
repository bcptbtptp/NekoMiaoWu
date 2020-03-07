<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/19 下午 5:12
 *
 **/

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;
class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];
    public function getPreOrder($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function redirectNotify(){
        $notify = new WxNotify();
        $config = new \WxPayConfig();
        $notify->Handle($config);
    }

    public function receiveNotify(){
        $xmlData = file_get_contents('php://input');
        $result = curl_post_raw('http:/z.cn/api/v1/pay/re_notify?XDEBUG_SESSION_START=17753',
            $xmlData);
//        return $result;
//        Log::error($xmlData);
    }
}