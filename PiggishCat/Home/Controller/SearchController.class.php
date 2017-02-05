<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends EmptyController {

	public function Searchgoods()
	{
		$get = I('get.');
		$Search = D('goods');
		$goods = $Search->SearchGoods($get);
		
		$goods['data'] = $this->goodsPic($goods['data']);
		$goods['JsGoods'] = $this->goodsPic($goods['JsGoods']);

		$goods['AdvGoods'] = $this->goodsPic($goods['AdvGoods']);

		//将模糊搜索的条件分配下去,
		$this->assign('name',$get['gos_name']);
		
		$this->assign($goods);

		//##################取得Home顶级分类导航#####################
		$TopCategory = $this->topClassification();
	
		$this->assign($TopCategory);


		$this->display();
	}

	private function goodsPic($goods)
	{	
		$goodsPicture = D('goodspicture');
		$Allgoods = $goodsPicture->hotPicture($goods);
		return $Allgoods;

	}

	public function abc()
	{
		dump(I('get.'));
	}


	private function topClassification()
	{
		$Category = D('Category');
		$TopCategory = $Category->unLimited();

		return $TopCategory;
	}
}
