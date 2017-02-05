<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        //公告内容遍历(黄梓鑫)
        // 大D一下Bulletin类
        $Bulletin = D('Bulletin');
        $res = $Bulletin->proErgodic();
        // 将得到的公告信息分配到首页
        $this->assign('res',$res);

    	
    	$this->display();
    }
}
