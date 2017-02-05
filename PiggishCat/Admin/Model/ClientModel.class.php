<?php
  /*+------------------------------------------------+
      | 用户模块Model
      +------------------------------------------------+                   
      | 作者:周敏                         
      | 最后修改时间:                                
      +------------------------------------------------+
   */ 
    
namespace Admin\Model;

use Think\Model;

class ClientModel extends Model 
{

	//处理会员列表
	public function ClientShow()
	{
		//实行搜索
		$get = I('get.');
		// dump($get);
		$map = [];
		switch ($get['search']) {
			case 'clt_id':
				$map[ $get['search'] ] = [ 'eq', $get['content'] ];
				break;
			case 'clt_user':
				$map[ $get['search'] ] = [ 'LIKE' ,  '%' . $get['content'] . '%' ];
				break;
			case 'clt_phone':
				$map[ $get['search'] ] = [ 'eq', $get['content'] ];
				break;
		}

		// //判断找到的为空 
  //       if(empty($map)){
  //           echo '当前没有数据';
  //       }
		//实例化分页
		$page = new \Think\Page($this->where($map)->count(),5);
		//分页查询
		$list = $this->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		//处理数据 
		$type = ['女','男','妖'];
		$stat = [1=>'禁用中',2=>'启用中'];
		foreach($list as $key=>&$val){
			$val['clt_status'] = $stat[$val['clt_status']];
			$val['clt_sex'] = $type[ $val['clt_sex'] ]; 
			$val['clt_addtime'] = date('Y-m-d',$val['clt_addtime']);

			
		}
		return ['list'=>$list,'show'=>$page->show(),'count'=>$count];
		
	}
	//修改用户禁用启用状态
	public function saveStatus()
	{
		$post = I('post.');
		$map['clt_id'] = $post['clt_id'];
		$data['clt_status'] = $post['clt_status'];
		$res = $this->where($map)->field('clt_status')->filter('strip_tags')->save($data);
		// dump($res);
		if($res) {
			return 1;
		}else{
			return false;
		}

	}

	// 获取用户id 用户名(黄梓鑫)
	public function meeList(){
		return $res = $this->getField('clt_id,clt_user');
	}

}
