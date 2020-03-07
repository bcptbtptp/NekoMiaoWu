<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2019/12/7 下午 2:29
 *
 **/

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategories(){
        $categories = CategoryModel::all([],'img');
        if ($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;
    }
}