<?php
/*+------------------------------------------------+
      | 用户收藏模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class EnshrineController extends CommonController
{
	//显示模板
	public function index()
	{
		// $data['clt_id'] = $_SESSION['homeuser'];
		// 	if(empty($data['clt_id'])){
		// 		$this->success('请先登录!',U('Home/Login/index'),1);
		// 		exit; 
		// 	}
		$enshrine = D('enshrine');
		//接收model返回的收藏表和商品表的数据
		$list = $enshrine->exenshrineList();
		$sunt = $enshrine->count();
		//实例化商品图片表，为了拿到商品图片路径
		$pic = D('Goodspicture');
		//
		$result = $pic->ShowPic($list);
		
		//将返回来的3维数组，处理成2维
		foreach ($result as $key => &$va) {
			$result = $va;
		}
		// dump($result);
		// 分配数据
		$this->assign('list',$result);
		$this->assign('count',$sunt);
		$this->display();
		
	}
	
	//ajax点击收藏商品
	public function addenshrine()
	{
		// $this->display();
		$enshrine = D('enshrine');
		//接收model返回的数组
		$res = $enshrine->addcoll();
		$gos_id = $res['gos_id'];
		$msg = $res['msg'];
		// dump($res);
		if($msg) {
			$this->ajaxReturn($msg);
		}		
	}
	//显示数据，遍历收藏夹
	public function enshrineList()
	{
		$enshrine = D('enshrine');
		$list = $enshrine->select();
		// print_r($list);
	}

	//ajax删除用户收藏
	public function Delenshrine()
	{
		$enshrine = D('enshrine');
		$res = $enshrine->U_enshrine();
		// dump($res);
		$this->ajaxReturn($res);
	}

}

