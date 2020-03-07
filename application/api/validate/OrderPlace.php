<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/18 下午 5:24
 *
 **/

namespace app\api\validate;


use app\lib\exception\ParamterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count'=>'require|isPositiveInteger'
    ];

    protected function checkProducts($values){
//        if (is_array($values)){
//            throw new ParamterException([
//                'msg' => '商品参数不正确'
//            ]);
//        }
        if (empty($values)){
            throw new ParamterException([
                'msg' => '商品列表不能为空'
            ]);
        }
        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    protected function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if (!$result){
            throw new ParamterException([
               'msg' => '商品列表参数错误'
            ]);
        }
    }
}