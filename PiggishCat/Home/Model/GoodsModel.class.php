<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:Cong                       
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;
use Think\Model;

class GoodsModel extends Model
{


	//首页 热卖展示
	public function hotGoods()
	{
		
		$count = $this->count();
		$count = $count-6;
		$num = mt_rand(1,$count);
		$map['gos_status'] = ['eq',1];
		$goods = $this->order('gos_sales desc')->where($map)->limit($num,6)->select();
		
		foreach($goods as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_price']);
		}

		return $goods;
	}

	//首页 1F展示
	public function ShowGoods()
	{
		
		$count = $this->count();
		$count = $count-6;
		$num = mt_rand(1,$count);
		$map['gos_status'] = ['eq',1];
		$goods = $this->order('gos_sales desc')->where($map)->limit($num,6)->select();
		
		foreach($goods as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_price']);
		}

		return $goods;
	}

	//首页 2F展示
	public function SecGoods()
	{
		
		$count = $this->count();
		$count = $count-6;
		$num = mt_rand(1,$count);
		$map['gos_status'] = ['eq',1];
		$goods = $this->order('gos_sales desc')->where($map)->limit($num,6)->select();
		
		foreach($goods as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_price']);
		}

		return $goods;
	}

	//首页 3F展示
	public function ThrGoods()
	{
		$count = $this->count();
		$count = $count-6;
		$num = mt_rand(1,$count);
		$map['gos_status'] = ['eq',1];
		$goods = $this->order('gos_sales desc')->where($map)->limit($num,6)->select();
		
		foreach($goods as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_price']);
		}

		return $goods;
	}


	//首页 4F展示
	public function fourGoods()
	{
		$count = $this->count();
		$count = $count-6;
		$num = mt_rand(1,$count);
		$map['gos_status'] = ['eq',1];
		$goods = $this->order('gos_sales desc')->where($map)->limit($num,6)->select();
		
		foreach($goods as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_price']);
		}
		return $goods;
	}


	//底部JS商品展示
	public function bottomGoods()
	{
		$count = $this->count();
		$count = $count-5;
		$num = mt_rand(1,$count);
		$map['gos_status'] = ['eq',1];
		$data = $this->order('gos_sales desc')->where($map)->select();
		foreach($data as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_price']);
		}
		return $data;
	}

	//查询分类页商品
	public function showCateGoods($data)
	{
		
		foreach($data['ThreeCate'] as $val){
			$map['goy_id'] = ['eq',$val['goy_id']];
			$goodsInfo = $this->where($map)->select();
		}
		
	}

	//商品详情页的展示
	public function showDetails()
	{

		$get = I('get.');
		$map['gos_id'] = ['eq',$get['gos_id']];
		//调用私有方法 传递$map条件
		$res = $this->AccessUrl($get['gos_id']);
		if($res){
			$this->GoogdsView($map);
		}
		$map['gos_status'] = ['eq',1];
		$data = $this->where($map)->find();
		$data['gos_price'] = $data['gos_price'] / 100;
		return $data;
	}
	/**
	 * @param 	[goodsId] [商品自身id]
	 */
	//商品浏览量+1 超过24小时后即删除前一天的数据
	//一表两用 并且用做用户浏览历史
	private function AccessUrl($goodsId)
	{
		//设置时差时差 单位是秒;
		$TimeDifference = 300;

		//获取用户信息
		$userInfo = I('session.homeuser');
		//接收SERVER的数据
		$server = I('server.');
		//用户ip
		$data['user_ip'] = $server['REMOTE_ADDR'];
		//用户访问的url
		$data['url'] = $server['REQUEST_URI'];
		//用户名
		$data['clt_user'] = $userInfo['clt_user'];
		//商品ID
		$data['gos_id'] = $goodsId;
		//访问时间
		$data['addtime'] = time();
		//查询条件
		$map['clt_user'] = ['eq',$data['clt_user']];
		$map['url'] = ['eq',$data['url']];
		//先去查询一次
		$link = new Model('link');
		$Access = $link->where($map)->find();
		
		//取反 , 如果不存在
		if(!$Access){
			//插入表中
			$res = $link->add($data);
			$All_access = $this->deleteLink($data['clt_user'],$data['user_ip'],$TimeDifference);
			return true;
		}else{
			//存在就计算当前时间与访问时间的时差
			$time = time();
			$Jetlag = $time - $Access['addtime'];
			//大于24小时的秒数 执行删除原数据
			//设置为60s,展示项目所用
			if($Jetlag > $TimeDifference ){
				//where条件
				$map['clt_user'] = ['eq',$data['clt_user']];
				$map['url'] = ['eq',$Access['url']];
				//先删除旧的数据
				$link->where($map)->delete();
				//再执行插入最新的数据
				$link->add($data);
				
				return true;
			}
		}
	}

	/**
	 * @param	[string] [用户名]
	 * @param	[int] [设置好的时差值]
	 * @param	[string] [访问IP]
	 */
	private function deleteLink($User,$ip ,$TimeDifference)
	{
		//当前时间 - 时差值 = 过去时
		$TimeLeft = time() - $TimeDifference;
		$link = new Model('link');

		//不为空时查询用户资讯
		if(!empty($User)) {
			$map['clt_user'] = ['eq',$User];
			//查询用户所有的浏览记录
			$All_access = $link->where($map)->select();
			//通过遍历的方式 , 判断浏览事件是否小于过去时 
			foreach($All_access as $val){
				//小于过去时 , 执行删除
				if($val['addtime'] < $TimeLeft ){
					$map['addtime'] = $val['addtime'];
					$link->where($map)->delete();
				}
			}
		}
		
	}

	private function GoogdsView($condition)
	{
		$GoodsView = $this->where($condition)->find();
		//点击量+1
		$GoodsView['gos_view'] = $GoodsView['gos_view']+1;
		//更新点击量
		$this->where($condition)->field('gos_view')->filter('strip_tags')->save($GoodsView); 
	}



	//点击顶级分类,获取到所有商品数据
	public function porAllcategory($AllgoodsInfo,$get)
	{

		// dump($get);
		//遍历三级分类
		foreach($AllgoodsInfo as $val){
			//把商品的父级ID拿出来
			foreach($val as $goods){
				$data[] = $goods['goy_id'];
			}
		}
		$sort = 'gos_sales desc';
		if(isset($get['param'])) {
			$content = $get['param'];
			switch($content){
				case 'Saledown':
					$sort = 'gos_sales asc';
					break;
				case 'SaleHot':
					$sort = 'gos_sales desc';
					break;
				case 'Pricedown':
					$sort = 'gos_price asc';
					break;

				case 'PriceHeight':
					$sort = 'gos_price desc';
					break;
				default:
					$sort = '';
					break;
			}
		}
		$map['gos_status'] = ['eq',1];
		$map['goy_id'] = ['in',$data];
		$page = new \Think\Page($this->where($map)->count(),20);
		$show = $page->show();
		$goodsInfo[] = $this->order($sort)->where($map)->limit($page->firstRow.','.$page->listRows)->select();
	
		return ['allProducts'=>$goodsInfo,'show'=>$show];
	}

	//前台模糊搜索方法
	public function SearchGoods($get)
	{
		//搜索后,判断参数进行用户所选择的方式排序
		if(isset($get['param'])){
			$sort = '';
			$content = $get['param'];
			switch($content){
				case 'Saledown':
					$sort = 'gos_sales asc';
					break;

				case 'SaleHot':
					$sort = 'gos_sales desc';
					break;

				case 'Pricedown':
					$sort = 'gos_price asc';
					break;

				case 'PriceHeight':
					$sort = 'gos_price desc';
					break;

				default:
					$sort = '';
					break;
			}
		}else{
			//默认排序
			$sort = 'gos_sales desc';
		}


		$map['gos_name'] =[ 'LIKE' , '%' . $get['gos_name']. '%' ];
		$page = new \Think\Page($this->where($map)->count(),25);
		$show = $page->show();
		$map['gos_status'] = ['eq',1];
		$data = $this->order($sort)->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		foreach($data as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
		}

		//搜索结果页面的JS展示图
		$sun = $this->where('gos_status = 1')->count();
		$num = mt_rand(1,$sun-4);
		$jsNum = mt_rand(1,$sun-10);
		$JsGoods = $this->order('gos_sales desc')->where('gos_status = 1')->limit($jsNum,10)->select();
		foreach($JsGoods as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
		}
		$AdvGoods = $this->order('gos_view desc')->where('gos_status = 1')->limit($num,4)->select();
		

		return ['data'=>$data,'JsGoods'=>$JsGoods,'show'=>$show,'AdvGoods'=>$AdvGoods];
	}

	//无限级分类导航,三级分类的商品数据处理
	public function ThreeCategorygoods($get)
	{
		// 查看三级分类下的商品后,判断参数进行用户所选择的方式排序
		if(isset($get['param'])){
			$sort = '';
			$content = $get['param'];
			switch($content){
				case 'Saledown':
					$sort = 'gos_sales asc';
					break;

				case 'SaleHot':
					$sort = 'gos_sales desc';
					break;

				case 'Pricedown':
					$sort = 'gos_price asc';
					break;

				case 'PriceHeight':
					$sort = 'gos_price desc';
					break;

				default:
					$sort = '';
					break;
			}
		}else{
			$sort = 'gos_sales desc';
		}

		$map['goy_id'] = ['eq',$get['goy_id']];
		$map['gos_status'] = ['eq',1];
		$page = new \Think\Page($this->where($map)->count(),20);
		$show = $page->show();
		$data = $this->order($sort)->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		foreach($data as &$val){
			$val['gos_price'] = $val['gos_price'] / 100;
			$val['gos_addtime'] = date('Y-m-d',$val['gos_addtime']);
		}
		
		return ['goodsInfo'=>$data,'show'=>$show];
	}

	public function findRecording($goodsId=array())
	{

		if(!empty($goodsId)){
			$map['gos_id'] = ['in',$goodsId];

		//如果条件不为空才去查询
		if(!empty($map['gos_id'])){
			$data = $this->where($map)->select();
			
			$goodsPic = D('goodspicture');

			//去获取图片信息
			$data = $goodsPic->hotPicture($data);
			foreach($data as &$val){
				$val['gos_price'] = $val['gos_price'] / 100;
			}
			return $data;
		}
		
		}
		
		
	}


	// 商品销量 库存的加减(黄梓鑫)
	public function shtGos($result){
		// 遍历查询修改商品销量 库存
		foreach ($result as $key => $val) {
			// 获取商品id
			$map['gos_id'] = $val['gos_id'];

			// 查询数据
			$res = $this->where($map)->field('gos_sales,gos_inventory')->Select();
			
			// 修改商品销量 库存
			$res[0]['gos_sales'] = $res[0]['gos_sales'] + $val['sht_num'];
			$res[0]['gos_inventory'] = $res[0]['gos_inventory'] + $val['sht_num'];
			
			// 数组的转换
			foreach ($res as $key => $val) {
				$res = $val;
			}
			
			// 插入修改
			$result = $this->where($map)->data($res)->save();
			
		}
	}
}
