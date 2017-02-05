<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                 
      +------------------------------------------------+
     */


namespace Home\Controller;


use Think\Controller;


class CommonController extends EmptyController 
{
	 public function __construct()
	{
		parent::__construct();
		
		$adminId = $_SESSION['homeuser'];
		if(empty($adminId)){
			$this->redirect('Home/Login/index');
		}
    }
}
