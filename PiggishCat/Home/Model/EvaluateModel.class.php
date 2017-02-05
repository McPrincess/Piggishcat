<?php
/*+------------------------------------------------+
      | 前台订单评价Model类
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
*/
namespace Home\Model;

use Think\Model;

class evaluateModel extends Model{

	// 记录将添加的评论
	public function addopn(){
		// 获取数据
		$get = I('get.');
		$session = I('session.');
		$clt_id = $session['homeuser']['clt_id'];
		$clt_user = $session['homeuser']['clt_user'];
		// 返回数据
		return ['get'=>$get,'clt_id'=>$clt_id,'clt_user'=>$clt_user];
		
	}

	// 执行添加评论方法
	public function doadd(){
		// 获取数据
		$session = I('session.');
		$post = I('post.');
		$post['eve_addtime'] = time();
		$post['clt_user'] = $session['homeuser']['clt_user'];
		$list = $this->data($post)->add();
		// dump($list);
		// 返回数据
		return ['list'=>$list];
	}     


	public function Showcomment(){
		$get = I('get.');	
		
		$map['gos_id'] = $get['gos_id'];
		$commentlist = $this->where($map)->select();
		foreach ($commentlist as $key => &$val) {
			$val['eve_addtime'] = date('Y-m-d H:i:s' ,$val['eve_addtime']);
		}
		return $commentlist;
	}
}
