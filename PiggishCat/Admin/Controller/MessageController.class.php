<?php

    /*+------------------------------------------------+
      | 公告模块控制器
      +------------------------------------------------+                   
      | 作者:黄梓鑫                         
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Controller;

use Think\Controller;

class MessageController extends CommonController {
    
    // 公告列表
    public function index(){
        // 实例化对象
        // 获取用户id 用户姓名
        $client = D('client');
        $res = $client->meeList(); 
        // dump($res);
        
        // 实例化对象
        $message = D('message');
        // 数据处理
        $data = $message->meeList($res);
        // 分配数据
        $this->assign($data);
        $this->display();
    }

}
