<?php
/*+------------------------------------------------+
      | 前台用户订单Model类
      +------------------------------------------------+                   
      | 作者:谢文瀚                        
      | 最后修改时间:                                
      +------------------------------------------------+
*/
namespace Home\Model;

use Think\Model;

class OrderformModel extends Model{


	public function index(){

		$this->display();
	}

	public function shopinsert()
    {
    	// 获取数据
    	$post = I('post.');
    	$session = I('session.homeuser');

    	// 定义数据
    	$map['clt_id'] = $session['clt_id'];
    	$map['orm_addtime'] = time();
    	$map['orm_status'] = '0';
    	$map['orm_remark'] = $post['orm_remark'];
    	$map['orm_total'] = $post['orm_total'][0];
    	$map['ads_id'] = $post['ads_id'][0];
    	$map['orm_remark'] = $post['orm_remark'];
    	
    	$res = $this->data($map)->add();
    	
    	// 返回数组
    	return $res;
  
    }

    // 执行搜索
    public function search(){
    	// 获取数据
    	$session = I('session.');
    	$clt_id = $session['homeuser']['clt_id'];
    	$array['clt_id'] = ['eq',$clt_id];

    	$list = $this->where($array)->select();
    	$type = ['0'=>'待发货','1'=>'已发货','2'=>'已签收','3'=>'交易完成'];
    	
    	// 遍历新数据
    	foreach ($list as $key => &$val) {
    		$num = date('YmdHis',$val['orm_addtime']);
    		 $val['orm_ordernum'] = $num.$val['orm_id'];
    		$val['orm_addtime'] = date('Y-m-d H:i:s',$val['orm_addtime']);
			 $val['orm_status'] = $type[$val['orm_status']];
			
			
    	}
    	return ['list'=>$list];

    }

    // 改变我的订单状态
    public function changeStatus(){
    	// 获取数据
		$get = I('get.');
		$data['orm_status'] = '2';
		$list = $this->where($get)->save($data);
		// 返回数据
		return $list;
	}
    

	// 新增状态
    public function addstatus(){
    	// 获取数据
    	$post = I('post.');
    	$map['orm_id'] = ['eq' ,$post['orm_id']];

    	$data['orm_evestatus'] = '1';
    	$data['orm_status'] = '3';	
    	$list = $this->where($map)->save($data);
    	// 返回数据
    	return $list;
    }

    // 搜索订单评价状态
    public function Searchstatus($list){
    	// 获取数据
    	$get = I('get.');

    	$orm_id = $get['orm_id'];
    	$map['orm_id'] = ['eq',$orm_id];
    	$lists = $this->where($map)->select();
    	
    	
    	$list['0']['orm_evestatus'] = $lists['0']['orm_evestatus'];
    	
    	// 返回数据
    	return $lists;
    }


  
}