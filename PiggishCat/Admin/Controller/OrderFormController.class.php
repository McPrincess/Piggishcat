<?php
/*+------------------------------------------------+
      | 后台订单管理模块控制器 
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Admin\Controller;

use Think\Controller;

class OrderFormController extends EmptyController {

	// 我的订单界面
	public function index(){
		$Connection = D('Orderform');
		$data = $Connection->Orderform();

		// 分配数据
		$this->assign($data);
		
		// 显示模板
		$this->display();
	}

	// 订单详情界面
	public function detail(){
		$Connection = D('Orderform');
		$list = $Connection->detail();


		$Connection2 = D('orderdetails');
		$lists = $Connection2->gosdetails();

		// 分配数据
		$this->assign($lists);
		$this->assign($list);
		// 显示模板
		$this->display();
	}

	// 修改发货状态
	public function Modify(){
		$Connection = D('Orderform');
		$list = $Connection->detail();

		$Connection2 = D('orderdetails');
		$lists = $Connection2->returndetails($list);
		
		// 分配数据
		$this->assign($lists);
		// 显示模板
		$this->display();
	}

	// 保存地址状态
	public function saveRess()
	{
		$ordRess = D('Orderform');
		$res = $ordRess->upRess();
		// ajax返回
		if($res){
			$this->ajaxReturn($res);
		}
	}
	

	public function Change(){

		$ordChange = D('Orderform');
		
		//接收返回值
		$res = $ordChange->changeormStatus();

		//判断返回值，返回给ajax
		if($res>0) {
			$this->ajaxReturn($res);
		}else{
			echo 2;
		}
	} 
}
