<?php
/*+------------------------------------------------+
      | 前台订单管理模块控制器 
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class OrderformController extends CommonController{

	// 我的订单
	public function index(){
		$Orderform = D('Orderform');
		$list = $Orderform->search();
		$this->assign($list);
		$this->display();
	}

	// 订单详情页面
	public function details(){
		$Orderdetails = D('orderdetails');
		$list = $Orderdetails->locate();
		
		$Orderform = D('Orderform');
		$lists = $Orderform->Searchstatus($list);
		// 分配数据
		$this->assign('lists',$lists);
		$this->assign('list',$list);
		$this->display();
	}

	// 修改订单状态
	public function Change(){
		$OrderChange = D('Orderform');
		$list = $OrderChange->changeStatus();

		if ($list == '1') {
			// 收货成功 返回我的订单界面
			 $this->success('收货成功', U('Home/Orderform/index'));
		}else{
			// 收货失败 返回当前界面
			 $this->error('操作失败,请稍后再试');
		}
	}


	// 订单内商品评价页面
	public function Comment(){
		$opinion = D('Evaluate');
		$list = $opinion->addopn();
		
		// 分配数据
		$this->assign($list);
		$this->display();
	}

	// 执行评价
	public function doComment(){
		$opinion = D('Evaluate');
		$list = $opinion->doadd();

		$addopinion = D('Orderform');
		$addlist = $addopinion->addstatus();
		
		if ($list > 0) {
			// 评论成功 返回订单表
			$this->success('评论成功',U('Home/Orderform/index'));
		}else{
			// 评论失败 返回当前页面
			$this->error('操作失败，请稍后再试');
		}
	}
}
