<?php
/*+------------------------------------------------+
      | 公告模块控制器 
      +------------------------------------------------+                   
      | 作者:黄梓鑫                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class BulletinController extends EmptyController
{
	public function index()
	{
		// echo __METHOD__.'<br>';
		// dump(I('get.'));
		// 实例化对象
		$bunDetails = D('bulletin');
		 // 数据处理
		$data = $bunDetails->bunDet();

		// dump($data);
		$this->assign($data);
		$this->display();
	}

	
}
