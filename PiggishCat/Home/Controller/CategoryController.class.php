<?php
namespace Home\Controller;
use Think\Controller;
class CategoryController extends EmptyController {

	public  function Category()
	{
		//拿ID
		$get = I('get.');
		$this->assign('param',$get['goy_id']);
		//查顶级分类
		$TopCate = D('category');

		//去找到全部的三级分类!
		$AllgoodsInfo = $TopCate->ThreeCate($get);

		//查询用户的浏览过的商品的ID
		$goodsId = $this->historyRecord();

		//去找商品
		$ProductinFormation = $this->AllGoods($AllgoodsInfo,$get,$goodsId);
		
		//将商品分配下去
		$this->assign($ProductinFormation[0]);
		$this->assign($ProductinFormation);
		
		//查询顶级分类分配下去
		$data = $TopCate->showCate();

		$this->assign($data);

		//横幅
		$advpic = $this->advShow();
		$this->assign($advpic);
			
		//展示模版
		$this->display();
	}

	//找出所有商品 , 并且查询用户浏览过的商品信息
	private function AllGoods($AllgoodsInfo,$get,$goodsId=array())
	{
		$goodsInfo = D('goods');

		$data = $goodsInfo->porAllcategory($AllgoodsInfo,$get);

		$goodsCategory = $this->AllgoodsPic($data);
		
		$Recording = $goodsInfo->findRecording($goodsId);
		
		return [$goodsCategory,'Recording'=>$Recording];

	}

	//去获取商品图片
	private function AllgoodsPic($data)
	{
		
		$goodsInfo = D('goodspicture');
		$ProductinFormation = $goodsInfo->AllgoodsPic($data);
		return $ProductinFormation;

	}

	//去获得用户最新浏览的5个商品的ID
	private function historyRecord()
	{
		$Record = D('Link');
		$goodsId = $Record->browsingHistory();
		return $goodsId;
	}


	//获取横幅
	private function advShow()
	{
		$adv = D('advertising');
		$data = $adv->showAdv();
		return $data;
	}
}
