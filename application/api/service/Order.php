<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 5:45
 *
 **/

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    // 订单商品列表，客户端传递过来的
    protected $clientProducts;
    // 数据库查询出来的商品，真实的商品信息
    protected $dbProducts;

    protected $uid;

    public function place($uid,$clientProducts){
        $this->clientProducts = $clientProducts;
        $this->dbProducts = $this->getProductsByOrder($clientProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if (!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        // 开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    private function createOrder($snap){
        Db::startTrans();
        try
        {
            $orderNo = $this->createOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);

            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach ($this->clientProducts as &$product)
            {
                $product['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->clientProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        }catch (Exception $e){
            Db::rollback();
            throw $e;
        }
    }
    //  订单号防止高并发重复
    public static function createOrderNo(){
        $startCode = array('A','B','C','D','E','F','G','H','I','J');
        $orderSN =
            $startCode[intval(date('Y')) - 2020] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                    '%02d', rand(0,99));
        return $orderSN;
    }

    private function snapOrder($status){
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        // 历史订单搜索，文档型数据库，NoSQL，TODO
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->dbProducts[0]['name'];
        $snap['snapImg'] = $this->dbProducts[0]['main_img_url'];
        if (count($this->dbProducts) > 1){
            $snap['snapName'] .= '等';
        }
//        for ($i = 0; $i < count($this->dbProducts); $i++) {
//            $product = $this->dbProducts[$i];
//            $oProduct = $this->clientProducts[$i];
//
//            $pStatus = $this->snapProduct($product, $oProduct['count']);
//            $snap['orderPrice'] += $pStatus['totalPrice'];
//            $snap['totalCount'] += $pStatus['count'];
//            array_push($snap['pStatus'], $pStatus);
//        }
        return $snap;
    }

    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id',$this->uid)
            ->find();
        if (!$userAddress){
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => 60001,
            ]);
        }
        return $userAddress->toArray();
    }

    private function getOrderStatus(){
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->clientProducts as $clientProduct){
            $pStatus = $this->getProductStatus(
                $clientProduct['product_id'],$clientProduct['count'],$this->dbProducts
            );
            if (!$pStatus['hasStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    private function getProductStatus($clientPID,$clientCount,$product){
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'hasStock' => false,
            'counts' => 0,
            'price' => 0,
            'name' => '',
            'totalPrice' => 0,
            'main_img_url' => null
        ];
        for ($i=0;$i<count($product);$i++){
            if ($clientPID == $product[$i]['id']){
                $pIndex =$i;
            }
        }

        if ($pIndex == -1){
            throw new OrderException([
                'msg' => 'id为'.$clientPID.'商品不存在，创建订单失败'
            ]);
        }else{
            $product = $product[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['counts'] = $clientCount;
            $pStatus['price'] = $product['price'];
            $pStatus['main_img_url'] = $product['main_img_url'];
            $pStatus['totalPrice'] = $product['price'] * $clientCount;
            if ($product['stock'] - $clientCount >= 0){
                $pStatus['hasStock'] = true;
            }
        }
        return $pStatus;
    }

    private function getProductsByOrder($clientProducts){
        $clientPIDs = [];
        foreach ($clientProducts as $product){
            array_push($clientPIDs,$product['product_id']);
        }
        $products = Product::all($clientPIDs)
            ->visible(['id','price','stock','name','main_img_url'])
            ->toArray();
        return $products;
    }

    public function checkOrderStock($orderID){
        $oProducts = OrderProduct::where('order_id','=',$orderID)
            ->select();
        $this->clientProducts = $oProducts;
        $this->dbProducts = $this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        return $status;
    }
}