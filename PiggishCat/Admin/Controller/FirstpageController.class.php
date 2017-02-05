<?php
namespace Admin\Controller;
use Think\Controller;
class FirstpageController extends CommonController {
    public function index()
    {
    	// 去管理员表查询管理员id 管理员姓名(黄梓鑫)
		$admin = D('admin');
		$list = $admin->nesPage();

    	// 留言信息遍历(黄梓鑫)
    	$news = D('news');
    	$res = $news->nesErgodic($list);
    	// 分配数据
    	$this->assign($res);

        $this->display();
    }
}
