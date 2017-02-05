<?php
namespace Admin\Controller;
use Think\Controller;
class InformationController extends CommonController {
	public function index()
	{
		$CateInfo = D('Category');
		$data = $CateInfo->cateInfo();
		if($data == 3){
			$this->threeCate();
		}else{
			$this->assign($data);
			$this->display();
		}
		

	}

	private function threeCate()
	{
		$goodsInfo = D('goods');
		$data = $goodsInfo->threeGoods();
		$this->assign($data);
		$this->display('threeCate');

	}
}
