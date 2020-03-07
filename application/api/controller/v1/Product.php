<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 下午 2:02
 *
 **/

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecentProducts($count=15){
        (new Count())->goCheck();
        $products = ProductModel::getMostRecentProducts($count);
        if ($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if ($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getOneProduct($id){
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product){
            throw new ProductException();
        }
        return $product;
    }
}