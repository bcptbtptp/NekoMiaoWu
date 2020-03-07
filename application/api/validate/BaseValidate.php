<?php
/**
 * @Desc 验证器基方法
 * @author 42
 * @CreateTime 2019/11/22 下午 8:12
 *
 **/

namespace app\api\validate;


use app\lib\exception\ParamterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);

        if (!$result){
            $e = new ParamterException([
                'msg' => $this->error,
            ]);
            throw $e;
        }else{
            return true;
        }
    }

    protected function isPositiveInteger($value,$rule='',$data='',$filed=''){
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
            return false;
        }
    }

    protected function isNotEmpty($value,$rule='',$data='',$filed=''){
        if (empty($value)){
            return false;
        }else{
            return true;
        }
    }

    public function getDataByRule($array){
        if (array_key_exists('user_id',$array) |
            array_key_exists('uid',$array)){
            throw new ParamterException(
                [
                    'msg' => '参数中包含非法的user_id或uid'
                ]);
        }
        $newDataArray = [];
        foreach ($this->rule as $key => $value){
            $newDataArray[$key] = $array[$key];
        }
        return $newDataArray;
    }

    protected function isMobile($value){
//        $rule = '^1(3|4|5|6|8)[0-9]\d{8}$^';
        $rule = '^(0[0-9]{2,3}/-)?([2-9][0-9]{6,7})+(/-[0-9]{1,4})?$^';
        $result =  preg_match($rule,$value);
        if ($result){
            return true;
        }else{
            return false;
        }
    }
}