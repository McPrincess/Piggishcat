<?php 
/*+------------------------------------------------+
      | 后台退换货订单Model 
      +------------------------------------------------+                   
      | 作者:谢文瀚                
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Model;

use Think\Model;

class SalesReturnModel extends Model{

	// 显示退换货订单界面
	public function SalesReturn(){

		$get = I('get.');
		$map = [];
		switch ($get['search']) {
			case 'san_id':
				$map[$get['search']] = ['eq',$get['content']];
				break;
			case 'clt_id':
				$map[ $get['search'] ] = [ 'eq', $get['content'] ];
				break;
			case 'san_status':
				$map[$get['search']] = ['eq',$get['content']];
				break;
		}

		// 分页
		$page = new \Think\Page($this->where($map)->count(),8);
		$show = $page->show();
		$list = $this->where($map)->limit($page->firstRow . ',' . $page->listRows)->select();

		$type = ['0'=>'等待审核','1'=>'准备货物返还','2'=>'已签收','3'=>'退换货完成','4'=>'拒绝退换货'];
		foreach ($list as $key => &$val) {
			$val['san_addtime'] = date('Y-m-d H:i:s',$val['san_addtime']);
			$val['san_status'] = $type[$val['san_status']];
		}
		$num = $this->where($map)->count();
		$show = $page->show();
		// 返回数据
		return ['show'=>$show , 'list'=>$list ];
	}


	// 显示退换货订单详情
	public function detail1(){
		$id = I('get.')['san_id'];
		$array['san_id'] = ['eq' , $id];
		$list=$this->where($array)->select();
		$type = ['0'=>'等待审核','1'=>'准备货物返还','2'=>'已签收','3'=>'退换货完成','4'=>'拒绝退换货'];
		foreach ($list as $key => &$val) {
			$val['san_addtime'] = date('Y-m-d H:i:s',$val['san_addtime']);
			$val['san_status'] = $type[$val['san_status']];
		}
		// 返回数据
		return $list;
	}

	// 修改退换货订单内容
	public function Modify2(){
		$id = I('get.')['san_id'];
		$array['san_id'] = ['eq' , $id];
		$result = $this->where($array)->select();

		$type = ['0'=>'等待审核','1'=>'准备货物返还','2'=>'已签收','3'=>'退换货完成','4'=>'拒绝退换货'];
		foreach ($result as $key => &$val){
			$val['san_addtime'] = date('Y-m-d H:i:s',$val['san_addtime']);
			$val['san_status'] = $type[$val['san_status']];
		}
		// 返回数据
		return $result;
	}	
	
	// 修改退换货订单状态
	public function changesanStatus(){
		// 接收get携带的参数
		$get = I('get.');
		$map['san_id'] = ['eq',$get['san_id']];
		$data['san_status'] = $get['san_status'];

		// 更新数据库
		$res = $this->where($map)->field('san_status')->filter('strip_tags')->save($data);

		// 成功返回受影响行
		if ($res) {
			return 1;
		}else{
			return false;
		}
	}


	// 发送退换货订单状态
	public function sendsanStatus(){
		// 接收get携带的参数
		$get = I('get.');
		$map['san_id'] = ['eq',$get['san_id']];
		$data['san_status'] = $get['san_status'];

		// 更新数据库
		$res = $this->where($map)->field('san_status')->filter('strip_tags')->save($data);

		// 成功返回受影响行
		if ($res) {
			return 2;
		}else{
			return false;
		}
	}

	// 显示退换货订单详情页的商品
	public function showgosreturn($result){
		$get = I('get.');
		$orm_id = $get['orm_id'];
		$map['orm_id'] = ['eq' , $orm_id];

		$list = $this->where($map)->select();
		foreach ($lists as $key => &$val) {
			
		}
		// 返回数据
		return ['list'=>$list];
	}
}

