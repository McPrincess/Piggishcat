<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController {
	public function index()
	{
		$Goods = D('goods');
		$data = $Goods->GoodsShow();

		$this->assign($data);
		$this->assign('count',$data['count']);
		$this->display();
	}

	//将三级分类展示在form页面的select中
	public function addFrom()
	{
		//判断url的参数是否全等 , 再去CategoryModel取出数据
		
			//从分类Model类中取出分类数据
			$Cate = D('Category');
			$data = $Cate->AllCategory();

			//将分类信息覆盖自身
			$data = $data['list'];
			// echo '<pre>';
			// 	print_r($data);
			// echo '</pre>';
			//去GoodsModel中处理
			$Goods = D('goods');
			$data = $Goods->proCate($data);
			$this->assign($data);
			$this->display();
	}

	//添加商品
	public function addGoods()
	{
		if(IS_POST){
			if(I('get.param') === 'goods'){
				$Goods = D('goods');
				$result = $Goods->proInfo();
				if(!is_int($result)){
					$this->error($result,U('Admin/Goods/addFrom/param/category'),5);
				}else{
					$this->success('添加成功！',U('Admin/Goods/index'),2);
				}
			}
		}
	}

	//Ajax删除
	public function delGoods()
	{
		if(I('get.param') == 'delete'){
			$get = I('get.');
			$Goods = D('goods');
			$res = $Goods->deleteGoods();
			$Goods->delGoodspic(I('get.gos_id'));
			$this->ajaxReturn($res);
		}
	}

	public function Details()
	{
		$goods = D('goods');
		$goodsInfo= $goods->goodsDetails();
		$this->assign($goodsInfo);

		//图片
		$Goodspic = D('goodspicture');
		$res = $Goodspic->showPic();
	
		// dump($res);
		$this->assign($res);
		$this->display();
	}


	//AJAX修改价钱
	public function ajax_goodsInfo()
	{
		// dump(I('get.'));
		$price = D('Goods');
		$res = $price->progoodsInfo();
		if($res == 1){
			$this->ajaxReturn($res);
		}else{
			// $this->ajaxReturn($res);
			echo 2;
		}
	}


	//AJAX修改库存
	public function ajax_goodsInve()
	{
		// dump(I('get.'));
		$price = D('Goods');
		$res = $price->proInventory();
		if($res == 1){
			$this->ajaxReturn($res);
		}else{
			// $this->ajaxReturn($res);
			echo 2;
		}
	}

	//AJAX修改描述
	public function ajax_goodsDesc()
	{
		$price = D('Goods');
		$res = $price->proDescription();
		if($res == 1){
			$this->ajaxReturn($res);
		}else{
			echo 2;
		}
	}

	//Ajax修改商品的状态
	public function Status()
	{
		$goodsStatus = D('goods');
		$res = $goodsStatus->saveStatus();
		if($res){
			$this->ajaxReturn($res);
		}else{
			return 0;
		}

	}

	//Ajax修改商品的名字
	public function goodsName()
	{
		dump(I('get.'));
		// $goodsStatus = D('goods');
		// $res = $goodsStatus->saveStatus();
		// if($res){
		// 	$this->ajaxReturn($res);
		// }else{
		// 	return 0;
		// }

	}

	//待审核商品
	public function auditGoods()
	{
		$Audit = D('goods');
		$data = $Audit->showAudit();
		$this->assign($data);
		$this->display('auditGoods');
	}

}
