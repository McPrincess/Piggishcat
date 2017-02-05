<?php
/*+------------------------------------------------+
      | 前台退换货订单管理模块控制器 
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class SalesreturnController extends CommonController{


	public function indexx(){
		$Salesreturn = D('salesreturn');
		$list = $Salesreturn->index();

		$this->assign('list',$list);
		$this->display();
	}

	// 退货订单首页
	public function index(){
		$Salesreturn = D('salesreturn');
		$list = $Salesreturn->search();
		

		$Salesreturns = D('salesreturn');
		$result = $Salesreturns->foreach($list);

		$this->assign('result',$result);
		$this->assign('res',$res);
		$this->display();
	}

	public function addreturn(){
		$Salesreturn = D('salesreturn');
		$list = $Salesreturn->doadd();
		if ($list > '0') {
			$this->success('申请成功,请到个人中心->退换订单查看',U('Home/Orderform/index'));
		}else{
			$this->error('操作失败,请稍后再试');
		}
	}

	public function Changeretstatus(){
		$Salesreturn = D('salesreturn');
		$list = $Salesreturn->dochange();
		echo '<pre>';
			print_r($list);
		echo '</pre>';
		if ($list) {
			$this->success('操作成功,等待商家签收并退换货物/货款',U('Home/Orderform/index'));
		}else{
			$this->error('操作失败,请稍后再试');
		}
	}
}
