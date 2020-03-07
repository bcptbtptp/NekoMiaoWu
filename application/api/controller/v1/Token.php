<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/8 下午 12:27
 *
 **/

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\api\service\Token as TokenService;

class Token
{
    public function getToken($code=''){
        (new TokenGet())->goCheck();
        $userToken = new UserToken($code);
        $token = $userToken->get();
        return [
            'token' => $token
        ];
    }

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se=''){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
        (new AppTokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token=''){
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }
}