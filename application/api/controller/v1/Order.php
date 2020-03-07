<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 4:15
 *
 **/

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Controller;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
        'checkSuperScope' => ['only' => 'delivery,getSummary']
    ];



    // 检查库存量
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        // 获取数组参数
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    /**
     * 根据用户id分页获取订单列表（简要信息）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummaryByUser($page = 1, $size = 15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()){
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address', 'prepay_id'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 获取订单详情
     * @param $id
     * @return static
     * @throws OrderException
     * @throws \app\lib\exception\ParameterException
     */
    public function getDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail){
            throw new OrderException();
        }
        return $orderDetail
            ->hidden(['prepay_id']);
    }
}