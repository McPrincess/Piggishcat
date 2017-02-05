<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */

namespace Home\Model;

use Think\Model;

class AddressModel extends Model
{
	//查询地址详情
	public function searchAd()
	{
		$session = I('session.homeuser');
		$map['clt_id'] = ['eq',$session['clt_id']];
		$get =  I('get.');
		// dump($get);
		if($get){
			$map['ads_id'] = ['eq',$get['ads_id']];
		}
		

		$res = $this->where($map)->select();
		// dump($res);
		 // echo json_encode($list);
		return $res;
	}
	//添加地址
	public function Addressadd()
	{
		// print_r(I('post.'));
		$post = I('post.');
		$map['clt_id'] = ['eq',$post['clt_id']];
		$data['clt_id'] = $post['clt_id'];
		$data['clt_name'] = $post['clt_name'];
		$data['clt_phone'] = $post['clt_phone'];
		$data['clt_address'] = $post['clt_address'];
		$address = $this->where($map)->count();
		// print_r($address);
		if ($address < 5) {
				$res = $this->add($data);
				// print_r($res);
				if($res > 0) {
					return $res;
				}else{
					return false;
				}
		}
	}
	//用户删除地址的方法 
	public function userDelads()
	{
		$get = I('get.');
		$map['ads_id'] = ['eq',$get['ads_id']];
		// print_r($map);
		$res = $this->where($map)->delete();
		// print_r($res);
		if($res) {
			return 1;
		}else {
			return 2;
		}
	}
	//用户修改地址
	public function userEdit()
	{
		// print_r(I('post.'));
		$post = I('post.');
		$map['ads_id'] = ['eq',$post['ads_id']];
		$data['clt_name'] = $post['clt_name'];
		$data['clt_phone'] = $post['clt_phone'];
		$data['clt_address'] = $post['clt_address'];
		$res = $this->where($map)->save($data);
		if ($res) {
			return 1;
		}else{
			return 2;
		}

	}
	
}
