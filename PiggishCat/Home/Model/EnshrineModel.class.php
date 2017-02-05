<?php
/*+------------------------------------------------+
      | 用户收藏模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */

namespace Home\Model;

use Think\Model;

class EnshrineModel extends Model
{
	//展示收藏商品处理
	public function exenshrineList()
	{
		//查询用户的id
		$session = I('session.homeuser');
		$map['clt_id'] = $session['clt_id'];
		// $res = $this->where($map)->select();
		// 根据用户的id查询商品表和收藏标的所有数据
		$res = $this->where($map)->field('*')->join('__GOODS__ on __ENSHRINE__.gos_id = __GOODS__.gos_id')->select();
		//处理收藏时间
		foreach ($res as $key => &$v) {
			$v['ene_addtime'] = date('Y-m-d',$v['ene_addtime']);
		}
		return $res;
	}
	//处理收藏商品
	public function addcoll()
	{
		//判断用户是否登录
		if(IS_POST){ 
			$data['clt_id'] = $_SESSION['homeuser']['clt_id'];
			if(empty($data['clt_id'])){
				echo "请您登录后再收藏该商品！";
				exit;
			}
		//接收html页面ajax传递过来的数据
		$post = I('post.');
		// dump($post);
		// 接收商品id
		$data['gos_id'] = $post['gos_id'];
		//找到已登录的用户id
		$client = I('session.homeuser');
		$data['clt_id'] = $client['clt_id'];
		// print_r($client);返回的是用户的数据
		
		// 调用exenshrine查询是否已经收藏
		$result = $this->exenshrine($data);
		// dump($result);
		// exit; //int(1)

		if($result > 0) {
			$data['ene_addtime'] = time();
			$res = $this->add($data);
			if($res) {
				// dump($res);
				//将商品id返回
				return ['gos_id'=>$post['gos_id'],'msg'=>1];
			}else{
				return 0;
			}	
		}else{
			return 0;
		}		
	}
}
	//查询一条判断是否已收藏
	private function exenshrine(array $data)
	{
		
		$map['gos_id'] = ['eq',$data['gos_id']];
		$map['clt_id'] = ['eq',$data['clt_id']];
		$res = $this->where($map)->find();
		if(!$res){
			return 1;
		}else{
			return 0;
		}
	}

	//ajax删除我的收藏
	public function U_enshrine()
	{
		$get = I('get.');
		$map['ene_id'] = ['eq',$get['ene_id']];
		// print_r($map);
		$res = $this->where($map)->delete();
		// dump($res);
		if($res){
			return 1;
		}else{
			return 2;
		}
	}

	// 从购物车中添加收藏(黄梓鑫)
	public function addene()
	{	
		// 接收数据
		$map = I('get.');
		
		// 从session中获取用户id
		$session = (I('session.homeuser'));		
		$map['clt_id'] = $session['clt_id'];
		
		// 查询收藏表中是否存在
		$res = $this->where($map)->find();
		
		// 判断执行
		if(!$res){
			// 如果不存在执行添加
			$map['ene_addtime'] = time();
			$resadd = $this->data($map)->add();
				if($resadd){
					// 成功返回 1
					return 1;
				}else{

					// 失败返回 2
					return 2;
				}
			
		}else{

			// 如果存在直接返回 1
			return 1;
		}
		
		
	}
}
