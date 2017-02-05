<?php
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller {


    // 访问不存在的方法自动调用
    public function _empty($key,$val){
        // 获取不存在的方法名
       echo '您太牛了,找到了不存在的页面';
    }
}
