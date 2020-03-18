<?php
namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
abstract class CommonProductsController extends AdminController
{
    // 定义一个抽象方法，返回当前管理的商品类型
    abstract public function getProductType();


}
