<?php
namespace Home\Controller;
use Think\Controller;
class LinkController extends EmptyController
{

	public  function index()
	{
		$link = D('link');
		$UserRecording = $link->browsingHistory();
		// if($UserRecording){
			$goodsInfo = D('goods');
			$User_GoodsInfo['goodsInfo'] = $goodsInfo->findRecording($UserRecording);	
		// }
		

		$this->assign($User_GoodsInfo);
		$this->display();
	}
}
