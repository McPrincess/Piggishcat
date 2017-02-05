<?php
/*+------------------------------------------------+
      | 后台订单详情Model 
      +------------------------------------------------+                   
      | 作者:谢文瀚                
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Model;

use Think\Model;

class OrderdetailsModel extends Model{

	// 获取订单名对应的订单详情页
	public function gosdetails(){
		echo '<pre>';
			print_r($lists);
		echo '</pre>';
		$get = I('get.');
		$orm_status = $get['orm_status'];
		$orm_id = $get['orm_id'];
		$map['orm_id'] = ['eq' , $orm_id];

		$lists = $this->where($map)->select();
		foreach ($lists as $key => &$val) {
			
		}
		// 返回数据
		return ['lists'=>$lists];
	}

	// 返回订单详情
	public function returndetails($list){
		$get = I('get.');
		$orm_id = $get['orm_id'];
		$map['orm_id'] = ['eq',$orm_id];
		$lists = $this->where($map)->select();
		
		
		foreach ($list as $key => &$val) {
			$list['list']['0']['gos_id'] = $lists['0']['gos_id'];
			$list['list']['0']['gos_name'] = $lists['0']['gos_name'];
			$list['list']['0']['sht_num'] = $lists['0']['sht_num'];
		}
		// 返回数据
		return $list;
	}

	// 显示商品名的订单详情
	public function showgosreturn($result){
		$get = I('get.');
		$map['orm_id'] = $result['orm_id'];
		$list = $this->where($map)->select();
		
		// 返回数据
		return $list;
	}
}	