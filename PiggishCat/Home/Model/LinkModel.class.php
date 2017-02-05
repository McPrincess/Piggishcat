<?php
/*+------------------------------------------------+
      | 用户浏览历史
      | 一表两用(这里的是处理用户的浏览信息) 
      +------------------------------------------------+                   
      | 作者:Cong                       
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;
use Think\Model;

class LinkModel extends Model
{
	//差用户最近5条浏览记录
	public function browsingHistory()
	{

		//获取用户信息
		$userInfo = I('session.homeuser');
		//接收SERVER的数据
		$server = I('server.');
		//用户名
		$data['clt_user'] = $userInfo['clt_user'];
		//商品ID
		$data['gos_id'] = $goodsId;
		//查询条件
		$map['clt_user'] = ['eq',$data['clt_user']];
		//倒序查询最新的5条
		$link = $this->order('addtime desc')->where($map)->limit(5)->select();
		foreach($link as $val){
			$goodsId[] = $val['gos_id'];
		}
		return $goodsId;
		
	}
}
