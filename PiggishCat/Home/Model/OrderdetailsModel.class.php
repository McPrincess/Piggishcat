<?php
/*+------------------------------------------------+
      | 前台用户订单详情Model类
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
*/
namespace Home\Model;

use Think\Model;

class OrderdetailsModel extends Model{
	
	// 添加订单详情
	public function shopdetailss($result,$res){
		
		foreach ($result as $key => &$val) {
			$val['orm_id'] = $res;
			$data = $this->data($val)->add($val);
		}
		// 返回数组
		return $result;
	}


	// 提取订单详情信息
	public function locate(){
		// 获取数据
		$get = I('get.');
		$orm_id = $get['orm_id'];
		$map['orm_id'] = ['eq' , $orm_id];
		$session = I('session.');
		$clt_id = $session['homeuser']['clt_id'];
		
		$list = $this->where($map)->select();
		
		// 返回数据
		return $list;
	}

	
}