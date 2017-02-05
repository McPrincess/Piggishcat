<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends EmptyController {
	public function index()
	{	
		
		// 获取公告内容遍历(黄梓鑫)
		$indexBulletin = D('bulletin');
		$bunList = $indexBulletin->indexList();
		$this->assign('bunList',$bunList);
		
		//广告表
		$Adv = D('Advertising');
		$AdvPicture = $Adv->showAdv();
		
		$this->assign($AdvPicture);
		
		//首页JS大图
		$JsPic = D('advpicture');
		$Home_jspic = $JsPic->showAdvpic();
		$this->assign($Home_jspic);
		
		//商品表
		$goodsInfo = D('goods');
		
		//商品图片表
		$goodsPic = D('goodspicture');
		

		//################限时特卖####################
		//查询热卖商品

		$hotSales = $goodsInfo->hotGoods();
		//查询商品图
		$hotGoods = $goodsPic->hotPicture($hotSales);
		
		//分配数据
		$this->assign('hotGoods',$hotGoods);



		//################1F商品展示#######################
		//查询1F商品

		$goods = $goodsInfo->ShowGoods();
		//查询商品图
		$goods = $goodsPic->ShowPic($goods);
		
		//1F分配数据
		$this->assign($goods);


		//################2F商品展示#######################
		//查询2F商品
		$Secgoods = $goodsInfo->SecGoods();
		
		//查询商品图
		$twoFgoods = $goodsPic->SecondPic($Secgoods);
	
		//2F分配数据
		$this->assign($twoFgoods);


		//################3F商品展示#######################

		$ThreeGoods = $goodsInfo->ThrGoods();
	
		//查询商品图
		$threeFgoods = $goodsPic->ThreePic($ThreeGoods);
		
		//3F分配数据
		
		$this->assign($threeFgoods);
		


		//################4F商品展示#####################

		$FourGoodsInfo = $goodsInfo->fourGoods();
		
		//查询商品图
		$FourFgoods = $goodsPic->FourPic($FourGoodsInfo);
		
		//4F分配数据
		
		$this->assign($FourFgoods);

		
		//##################取得Home顶级分类导航#####################
		$TopCategory = $this->topClassification();
	
		$this->assign($TopCategory);

		//##################取得友情连接#########################
		$FriendsLink = $this->Links();
		$this->assign($FriendsLink);
		

		//接收返回的底部的商品信息
		$bottomPic = $this->showJsPic();
	
		//分配底部信息
		$this->assign($bottomPic);
		//展示模版
		$this->display();
	}

	//展示底部 Picture
	private function showJsPic()
	{
		$goodsInfo = D('goods');
		$goods = $goodsInfo->bottomGoods();

		$goodsPic = D('goodspicture');
		$goods = $goodsPic->bottomPic($goods);
		return $goods;
		
	}

	//################查找顶级分类###################
	private function topClassification()
	{
		$Category = D('Category');
		$TopCategory = $Category->unLimited();

		return $TopCategory;
	}

	//获得友情连接信息
	private function Links()
	{
		$link = D('blogroll');
		$FriendsLink = $link->getLink();
	
		return $FriendsLink;
	}
	



}
