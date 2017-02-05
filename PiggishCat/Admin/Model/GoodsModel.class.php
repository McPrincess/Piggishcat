<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {
	public  static $result = '';
	public function GoodsShow()
	{	
		$post = I('post.');
		$search = $post['search'];
		$content = $post['content'];
		$content_two = $post['content_two'];
		if(empty($post['content_two'])){
			unset($post['content_two']);
		}

		switch($search){
			case 'gos_id':
					$map['gos_id'] = ['eq',$content];
				break;
			case 'gos_name':	
					$map['gos_name'] = [ 'LIKE' , '%' . $content . '%' ];
				break;
			
			case 'gos_price':

					$map['gos_price'] = ['BETWEEN',($content*100).','.($content_two*100)];
				break;
			case 'gos_inventory':
					$map['gos_inventory'] = ['BETWEEN',$content.','.$content_two];
				break;
			case 'gos_view':
					$map['gos_view'] = ['BETWEEN',$content.','.$content_two];
				break;
			case 'gos_sales':
					$map['gos_sales'] = ['BETWEEN',$content.','.$content_two];
				break;
			default:
				$map['gos_status'] = ['eq',1];
				break;
		}	

		$page = new \Think\Page($this->count(),10);
		$list = $this->order('gos_id desc')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		$show = $page->show();
		$count = $this->count();
		$type = ['待审核','已上架'];
		foreach($list as $key=>&$val){
			$val['gos_addtime'] = date('Y-m-d',$val['gos_addtime']);
			$val['gos_status'] = $type[ $val['gos_status'] ];
			$val['gos_price'] = $val['gos_price'] / 100;
		}
		return ['list'=>$list,'show'=>$show,'conut'=>$count];
	}

	
	//展示所有商品详情
	public function goodsDetails()
	{
		$get = I('get.');
		$map['gos_id'] = $get['gos_id'];
		$result[] = $this->where($map)->find();
		if($result){
			$data = $this->goodsParam($map['gos_id']);
			$type = ['待审核','已上架'];
			foreach($result as $key=>&$val){
				$val['gos_addtime'] = date('Y-m-d',$val['gos_addtime']);
				$val['gos_status'] = $type[ $val['gos_status'] ];
				$val['gos_price'] = $val['gos_price'] / 100;
			}
			return ['list'=>$result,'param'=>$data];
		}
	}

	private function goodsParam($gos_id)
	{
		$Param = D('Parameters');
		$data = $Param->findParam($gos_id);
		return $data;
	}

	//处理分类数据的等级
	public function proCate($data)
	{
		$str = '|--';
		$str_t = '|--|--';
		foreach($data as $key=>&$val){
			if(substr_count($val['goy_path'],',')==2){
				$val['goy_name']  = $str.$val['goy_name'];
			}else if(substr_count($val['goy_path'],',')>2){
				$val['goy_name']  = $str_t .$val['goy_name'];
			}
		}
		return ['list'=>$data];
	}

	//处理用户上传的价格
	public function proInfo()
	{
		$post = I('post.');
		$price = $post['gos_price'];
		$inventory = $post['gos_inventory'];
		if(!is_numeric($price) || !is_numeric($inventory)){
			return self::$result= '请填写正确的价格和库存';
		}else if(strlen($post['gos_price'])>7){
			return self::$result= "<h3>价格不能超出七个数字 , 含小数</h3>";
		}else{
			$post['gos_price'] = $post['gos_price'] * 100;
		}
		//检测品名是否存在
		$map['gos_name'] = ['eq',$post['gos_name']];
		$res = $this->where($map)->find();
		if($res){
			return self::$result = '品名已存在!!!';
		}else{
			$post['gos_addtime'] = time();
			$res = $this->add($post);
			if($res){
				return self::$result = 1;
			}
		}
	}

	//删除数据库 
	public function deleteGoods()
	{
		$get = I('get.');
		$id = $get['gos_id'];

		$map['gos_id'] = ['eq',$id];
		$res = $this->where($map)->delete();
		if($res){
			return '1';
		}else{
			return '2';
		}
	}

	//AJAX修改商品价格
	public function progoodsInfo()
	{
		$goodsInfo = I('post.');
		//检测用户输入的价格
		$Detection = $this->proPrice($goodsInfo['gos_price']);
		//返回结果 如果为true
		if($Detection){
			$res = $this->findInfo($goodsInfo['gos_id'],$goodsInfo['gos_price']);
			if($res){
				$goodsInfo['gos_price'] = $goodsInfo['gos_price'] * 100;
				$data['gos_price'] = $goodsInfo['gos_price'];
				$map['gos_id'] = ['eq',$goodsInfo['gos_id']];
				$result =$this->where($map)->field('gos_price')->filter('strip_tags')->save($data); 
				if($result){
					// dump($result);
					return 1;
				}else{
					return 2;
				}
			}else{

				return 3;
			}
		}else{
			return 4;
		}
	}

	//AJAX修改商品库存
	public function proInventory()
	{
		$goodsInfo = I('post.');
		//检测用户输入的库存
		$Detection = $this->proPrice($goodsInfo['gos_inventory']);
		//返回结果 如果为true
		if($Detection){
			$res = $this->findInfo($goodsInfo['gos_id'],$goodsInfo['gos_inventory']);
			if($res){
				$data['gos_inventory'] = $goodsInfo['gos_inventory'];
				$map['gos_id'] = ['eq',$goodsInfo['gos_id']];
				$result =$this->where($map)->field('gos_inventory')->filter('strip_tags')->save($data); 
				if($result){
					// dump($result);
					return 1;
				}else{
					return 2;
				}
			}else{

				return 3;
			}
		}else{
			return 4;
		}
	}

	//验证价格是否数字并且不大于七位,含小数点
	private function proPrice($digital)
	{
		$length = strlen($digital);
		if(!is_numeric($digital)) {
			return false;
		}else{
			return true;
		}
	}

	private function findInfo($id,$digital)
	{
		$map['gos_id'] = ['eq',$id];
		$data = $this->where($map)->find();
		$Original = $data['gos_price'];
		$OriginalInve = $data['gos_inventory'];
		$OriginalDesc = $data['gos_description'];
		if($Original == $digital || $OriginalInve ==$digital || $OriginalDesc == $digital){
			return false;
		}else{
			return true;
		}
	}

	public function proDescription()
	{
		$goodsInfo = I('post.');
		$res = $this->findInfo($goodsInfo['gos_id'],$goodsInfo['gos_description']);
		if($res){
			$data['gos_description'] = $goodsInfo['gos_description'];
			$map['gos_id'] = ['eq',$goodsInfo['gos_id']];
			$result =$this->where($map)->field('gos_description')->filter('strip_tags')->save($data); 
			if($result){
				return 1;
			}else{
				return 2;
			}
		}else{

			return 3;
		}
	}

	public function delGoodspic($id)
	{
		$map['gos_id'] = ['eq',$id];
		$goodspic = M('goodspicture');
		$data = $goodspic->where($map)->select();
		foreach($data as $val){
			$path = $val['goe_path'];
			unlink('./Public/image/goods/home_'.$path);
			unlink('./Public/image/goods/details_'.$path);
			unlink('./Public/image/goods/'.$path);
		}

		$goodspic->where($map)->delete();
	}

	public function saveStatus()
	{
		
		$goodsInfo = I('get.');
		if(!isset($goodsInfo['param'])){
			return false;
		}else{
			$map['gos_id'] = ['eq',$goodsInfo['gos_id']];
			$data['gos_status'] = $goodsInfo['gos_status'];
			$res = $this->where($map)->field('gos_status')->filter('strip_tags')->save($data); 
			if($res){
				return 1;
			}else{
				return false;
			}
		}
	}

	public function threeGoods()
	{
		$get = I('get.');
		$map['goy_id'] = ['eq',$get['goy_id']];
		$page = new \Think\Page($this->count(),10);
		$list = $this->order('gos_id desc')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		$type = ['待审核','已上架'];
		foreach($list as $key=>&$val){
			$val['gos_addtime'] = date('Y-m-d',$val['gos_addtime']);
			$val['gos_status'] = $type[ $val['gos_status'] ];
			$val['gos_price'] = $val['gos_price'] / 100;
		}
		return ['list'=>$list,'show'=>$show];
	}

	public function showAudit()
	{
		$map['gos_status'] = ['eq',0];
		$page = new \Think\Page($this->count(),10);
		$list = $this->order('gos_id desc')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		$show = $page->show();
		$count = $this->count();
		$type = ['待审核','已上架'];
		foreach($list as $key=>&$val){
			$val['gos_addtime'] = date('Y-m-d',$val['gos_addtime']);
			$val['gos_status'] = $type[ $val['gos_status'] ];
			$val['gos_price'] = $val['gos_price'] / 100;
		}
		return ['list'=>$list,'show'=>$show,'conut'=>$count];
	}
}
