<?php
namespace Home\Controller;
use Think\Controller;
class GoodsdetailsController extends EmptyController {
	public function index()
	{	
		$goodsInfo = D('goods');
		//商品数据详情
		$data = $goodsInfo->showDetails();
	
		$this->assign('data',$data);
	
		//取对应的商品图片信息
		$goodsPic = D('Goodspicture');
		$list = $goodsPic->goodPic($data['gos_id']);
		//商品参数
		$param = D('Parameters');
		$list['paramInfo'][] = $param->getParam($data['gos_id']);
		$this->assign($list);

		//因为控制器不同,将数据再获得一次顶级分类 
		// 注意 : 必须要跟前面能分配下去的名字一致!
		$category = D('category');
		$categoryName['TopCate'] = $category->TopCategory();
		//商品详情页的面包屑
		$categoryName['bread']= $category->BreadCate($data['goy_id']);
	
		
		// 遍历用户的评论
		$evaluate = D('evaluate');
		$list = $evaluate->Showcomment();
		
		
		// 分配数据到模板
		$this->assign('list',$list);

		$this->assign($categoryName);

		//展示模版
		$this->display();
	}

	
}
