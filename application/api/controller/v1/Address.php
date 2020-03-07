<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 上午 10:35
 *
 **/

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\api\model\UserAddress;
use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress']
    ];
    /**
     * 获取用户地址信息
     * @return UserAddress
     * @throws UserException
     */
    public function getUserAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException([
                'code' => 404,
                'msg' => '用户收获地址不存在',
                'errorCode' => 60001
            ]);
        }
        $userAddress = $user->address;
        // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
        $data = $validate->getDataByRule(input('post.'));
        if (!$userAddress){
            // 关联属性不存在，则新建
            $user->address()
                ->save($data);
        }else{
            // 存在则更新
//            fromArrayToModel($user->address, $data);
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系
            // 更新的save来自于模型
            $user->address->save($data);
        }
        return new SuccessMessage();
    }
}