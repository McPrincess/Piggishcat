<?php 
/*+------------------------------------------------+
      | 后台订单管理Model 
      +------------------------------------------------+                   
      | 作者:谢文瀚                
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Model;

use Think\Model;

class OrderformModel extends Model{

	// 显示订单界面
	public function Orderform(){

		$get = I('get.');
		$map = [];
		switch ($get['search']) {
			case 'orm_id':
				$map[$get['search']] = ['eq',$get['content']];
				break;
			case 'clt_id':
				$map[ $get['search'] ] = [ 'eq', $get['content'] ];
				break;
			case 'orm_status':
				$map[$get['search']] = ['eq',$get['content']];
				break;
		}

		// 分页
		$page = new \Think\Page($this->where($map)->count(),8);
		$show = $page->show();
		$list = $this->where($map)->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$type = ['0'=>'新订单','1'=>'已发货','2'=>'已签收','3'=>'交易完成'];
		foreach ($list as $key => &$val) {
			$val['real_status'] = $val['orm_status'];
			$val['orm_addtime'] = date('Y-m-d H:i:s',$val['orm_addtime']);
			$val['orm_status'] = $type[$val['orm_status']];

		}
		 $num = $this->where($map)->count();
		$show = $page->show();
		// 返回数据
		return ['show'=>$show,'list'=>$list,'count'=>$count,'num'=>$num];
	}

	// 订单详情界面
	public function detail(){
		
		$id = I('get.')['orm_id'];
		$array['orm_id'] = ['eq',$id];
		$list=$this->where($array)->select();
		$type = ['0'=>'新订单','1'=>'已发货','2'=>'已签收','3'=>'交易完成'];
		foreach ($list as $key => &$val) {
			$val['orm_addtime'] = date('Y-m-d H:i:s',$val['orm_addtime']);
			 $val['orm_status'] = $type[$val['orm_status']];
		}
		// 返回数据
		return ['list'=>$list];
	}

	// 显示订单详情界面
	public function detail1(){

		$id = I('get.')['clt_id'];
		$array['clt_id'] = ['eq',$id];

		$result = $this->where($array)->find();

		return $result;
		
	}

	// ajax上传地址状态
	public function upRess(){
		$get = I('get.');
		$map['orm_id'] = ['eq',$get['orm_id']];
		$data['orm_ress'] = $get['orm_ress']; 
		$res = $this->where($map)->field('orm_ress')->filter('strip_tags')->save($data);
		if($res){
			return 1;
		}else{
			return false;
		}
	}

	// 改变订单发货状态
	public function changeormStatus(){
		//接收get携带的参数
		$get = I('get.');
		$map['orm_id'] = ['eq',$get['orm_id']];
		$data['orm_status'] = $get['orm_status'];

		//更新数据库
		$res = $this->where($map)->field('orm_status')->filter('strip_tags')->save($data);

		//成功会返回受影响行
		if($res) {
			return 1;
		}else{
			//失败 返回false
			return false;
		}
	}

}
