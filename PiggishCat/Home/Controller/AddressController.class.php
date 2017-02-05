<?php
/*+------------------------------------------------+
      | 用户个人中心用户信息模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class AddressController extends CommonController
{
	//显示模板查询用户地址数据
	public function index()
	{

		//判断用户是否登录
		
			// $data['clt_id'] = $_SESSION['homeuser']['clt_id'];
			// if(empty($data['clt_id'])){
			// 	$this->success('请先登录!',U('Home/Login/index'),1);
			// 	exit; 
			// }

		$address = D('address');
		$res = $address->searchAd();
		// dump($res);
		
			$this->assign('useraddress',$res);
			$areas = D('areas');
			$result = $areas->selAreas();
			$this->assign('areaslist',$result);

			$this->display();
 	       
		
	}

	//查询三级联动
	public function AreasSel()
	{
		$areas = D('areas');
		$res = $areas->Aareas();
		// dump($res);
		$this->ajaxReturn($res);


		// $this->display();
	}
	//用户添加地址
	public function InsterAddress()
	{
		$address = D('address');
		$result = $address->Addressadd();
		$this->ajaxReturn($result);
	}
	//用户删除地址
	public function Deladds()
	{

		$address = D('address');
		$result = $address->userDelads();
		$this->ajaxReturn($result);
	}
	//用户修改，查询三级地址
	public function Saveaddress()
	{
		$address = D('address');
		$res = $address->searchAd();
		// dump($res); 
		$this->assign('useraddress',$res);
		$areas = D('areas');
		$result = $areas->selAreas();
		// print_r($result);
		$this->assign('areaslist',$result);

		$this->display();
		
	}
	//用户修改地址
	public function addressSave()
	{
		$address = D('address');
		$res = $address->userEdit();
		$this->ajaxReturn($res);
	}
}
