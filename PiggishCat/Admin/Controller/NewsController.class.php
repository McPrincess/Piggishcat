<?php

    /*+------------------------------------------------+
      | 站内信模块控制器
      +------------------------------------------------+                   
      | 作者:黄梓鑫                         
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Controller;

use Think\Controller;

class NewsController extends CommonController {
	
		
	// 信息留言显示
	public function index(){

		// 去管理员表查询管理员id 管理员姓名
		$admin = D('admin');
		$list = $admin->nesCheak();
		// dump($list);
		$listEgation = $admin->nesEgation();
		// dump($listEgation);
		// 实例化对象
        $news = D('news');
        // 数据处理
        $data = $news->nesList($list,$listEgation);


        // dump($data);
        // 分配数据
		$this->assign($data);  
		$this->display();
		
	}

	// 信息留言添加
	public function add(){
		
		// 如果是以get方式传入		
		if(IS_GET){
			// 直接显示模板
			$this->display();
		}

		// 以post方式传人
		if(IS_POST){

			// 接收数据
			$news = D('news');
			// 数据处理
            $result = $news->nesAdd();
            
            if($result['status']){
                $this->success('添加成功！',U('Admin/Firstpage/index'));
            }else{
                $this->error('添加失败！'.$result['msg'],U('Admin/News/add'),5);
            }
		}
		
	}

	// 信息留言删除

	public function delete(){
		// 实例化对象
		$news = D('news');
		// 数据处理
		$data = $news->nesDelete();

		// 判断是否成功
		if($data){
                $this->success('删除成功！',U('Admin/News/index'));
            }else{
                $this->error('删除失败！',U('Admin/News/index'));
            }
	}
}
