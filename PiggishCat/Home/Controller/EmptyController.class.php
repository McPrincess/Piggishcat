<?php
namespace Home\Controller;
use Think\Controller;
class EmptyController extends Controller {


    // 访问不存在的方法自动调用
    public function _empty($key,$val)
    {
        // 获取不存在的方法名
        // echo $key; 
        // echo CONTROLLER_NAME;
        echo '你访问的页面不存在';
    }


}
