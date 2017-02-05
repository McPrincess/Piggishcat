<?php
namespace Home\Controller;
use Think\Controller;
class ClassificationgoodsController extends EmptyController {
	//无限级分类导航,三级分类的商品展示
	public function index()
	{
		//将URL携带的参数先分配下去,方面之后做搜索之后的分页
		$get = I('get.');
		$this->assign('param',$get['goy_id']);
		//获取商品信息
		$Categoods = D('goods');
		$data = $Categoods->ThreeCategorygoods($get);

		//将图片信息压入到数组当中
		$GoodsPic = D('goodspicture');
		//返回的是带有图片名的数组
		$data['goodsInfo'] = $GoodsPic->hotPicture($data['goodsInfo']);

		
		//顶级横向导航
		$category = D('category');
		//因为控制器不同,将数据再获得一次顶级分类 
		// 注意 : 必须要跟前面能分配下去的名字一致!
		$catgoryName['TopCate'] = $category->TopCategory();
		$this->assign($catgoryName);

		//面包屑
		$data['CategoryName'][] = $this->BreadCrumbs($get['goy_id']);


		//将所有数据分配下去
		$this->assign($data);

		$this->display();
	}

	//面包屑的获取方法
	private function BreadCrumbs($goyId)
	{
		// echo $goyId;
		$Bread = D('category');
		$res = $Bread->BreadCate($goyId);
		return $res;
	}
}
