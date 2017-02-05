<?php
/*+------------------------------------------------+
      | 前台退换货订单管理Model 
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Model;

use Think\Model;

class SalesreturnModel extends Model{


	public function index(){
		$session = I('session.');
		$clt_id = $session['homeuser']['clt_id'];
		
		$map['clt_id'] = ['eq',$clt_id];
		
		$list = $this->where($map)->select();

		$type = ['0'=>'审核中','1'=>'审核通过','2'=>'商家已签收','3'=>'退换货完成','4'=>'拒绝退换货'];
		foreach ($list as $key => &$val) {
			$val['san_status'] = $type[$val['san_status']];
			$val['san_addtime'] = date('Y-m-d H:i:s',$val['san_addtime']);
		}
		return $list;
	}

	public function search(){
		$get = I('get.');
		$orm_id = $get['orm_id'];
		$session = I('session.');
		$clt_user = $session['homeuser']['clt_user'];
		
		$map['orm_id'] = $get['orm_id'];
		$map['clt_id'] = $session['homeuser']['clt_id'];
		$map['san_addtime'] = time();
		$map['san_status'] = '0';

		$res = $this->data($map)->add();
		return $res;
	}


	public function foreach($list){
		$get = I('get.');
		$session = I('session.');
		$clt_user = $session['homeuser']['clt_user'];
		$orm_ordernum = $get['orm_ordernum'];
		$san_id = $list;
		$map['san_id'] = $san_id;
		$result = $this->where($map)->select();
		


		$type = ['0'=>'审核中','1'=>'审核通过','2'=>'商家已签收','3'=>'退换货完成','4'=>'拒绝退换货'];

		foreach ($result as $key => &$val) {
			$val['san_status'] = $type[$val['san_status']];
			$val['san_addtime'] = date('Y-m-d H:i:s',$val['san_addtime']);
		}
		$result['0']['clt_user'] = $clt_user;
		$result['0']['orm_ordernum'] = $orm_ordernum;
		
		return ['result'=>$result];
	}


	public function doadd(){
		$get = I('get.');
		$orm_id = $get['orm_id'];
		$clt_id = $get['clt_id'];
		$data['orm_id'] = $orm_id;
		$data['clt_id'] = $clt_id;
		$data['san_addtime'] = time();
		$data['san_status'] = '0';
		$list = $this->add($data);
		return $list;
	}

	public function dochange(){
		$get = I('get.');
		$san_id = $get['san_id'];
		$san_status = '2';
		$data['san_status'] = $san_status;
		$data['san_id'] = $san_id;

		$list = $this->data($data)->save();
		
		return $list;
	}
}