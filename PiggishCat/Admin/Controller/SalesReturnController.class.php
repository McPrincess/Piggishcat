<?php 
/*+------------------------------------------------+
      | 后台退换货订单管理模块控制器 
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Admin\Controller;

use Think\Controller;

class SalesReturnController extends EmptyController {

	// 退换货订单界面
	public function index() {
		$Connection = D('salesreturn');
		$data = $Connection->SalesReturn();
		$this->assign('count',$data['count']);
		// 分配数据
		$this->assign($data);
		// 显示模板
		$this->display();

	}

	// 退换货订单详情界面
	public function detail(){
		$Connection = D('Orderform');
		$result = $Connection->detail1();

		$Connection2 = D('orderdetails');
		$list = $Connection2->showgosreturn($result);

	
		$san_id = I('get.san_id');
		$result['san_id'] = $san_id;

		// 分配数据
		$this->assign('result',$result);
		$this->assign($list);
		// 显示模板
		$this->display();
	}

	// 修改退换货订单
	public function Modify(){
		$Connection = D('salesreturn');
		$result = $Connection->Modify2();
		$san_id = I('get.san_id');
		$id = $san_id;
		// 分配数据
		$this->assign('result',$result);
		// 显示模板
		$this->display();
		
	}

	// ajax返回地址状态
	public function saveRess(){
		$ordRess = D('salesreturn');
		$res = $ordRess->upRess();

	}

	// 改变退换货订单状态
	public function Change(){
		$sanChange = D('salesreturn');

		// 接收返回值
		$res = $sanChange->changesanStatus();

		// 判断返回值，返回给ajax
		if ($res = 1 ) {
			$this->ajaxReturn($res);
		}else{
			echo 'fail';
		}
	}

	// 发送退换货订单状态
	public function Send(){

		$sanSend = D('salesreturn');

		// 获取返回值
		$result2 = $sanSend->sendsanStatus();

		// 判断返回值
		if ($res = 2) {
			$this->ajaxReturn($res);
		}else{
			echo 'fail';
		}
	}

}

