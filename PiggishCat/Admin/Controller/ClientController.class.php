<?php
  /*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Controller;

use Think\Controller;

class ClientController extends CommonController
{
    //用户列表显示
    public function index()
    {
    	//实例化用户表 
    	$user = D('client');
    	//调用数据处理的方法 
    	$data = $user->ClientShow();
    	//分配数据
    	$this->assign($data);
    	$this->assign('count',$data['count']);
    	//显示模板
    	$this->display();
    } 

    //ajax设置用户权限
    public function ajaxUpdate()
    {
        $user = D('client');
       $res =  $user->saveStatus();
       // dump($res);
    }

   
}
