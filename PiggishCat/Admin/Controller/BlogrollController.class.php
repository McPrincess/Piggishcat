<?php
namespace Admin\Controller;
use Think\Controller;
class BlogrollController extends CommonController {
	public function index()
	{
		$Connection = D('blogroll');
		$data = $Connection->Blogroll();
		$this->assign($data);
		$this->display();
	}

	public function del()
	{
		// dump(I('get.id'));
		$id = I('get.bll_id');

		$delete = D('blogroll');
		$res = $delete->B_delete($id);
		$this->ajaxReturn($res);
	}

	/**
	 * 动态修改数据库中的状态信息
	 */
	public function Save()
	{
		// dump(I('get.id'));
		// $id = I('get.bll_id');
		// $stu = I('get.bll_status');

		$get = I('get.');
		$upload = D('blogroll');
		$res = $upload->SaveStatus($get);
		$this->ajaxReturn($res);
	}

	public function SaveUpload()
	{
		if(IS_GET){
			$this->display();
		}
	}
	public function Upload()
	{
		// 实例化上传类    
		$upload = new \Think\Upload();
		// 设置附件上传大小
		$upload->maxSize = 3145728;
		// 设置附件上传类型    
		$upload->exts = array('jpg','png','jpeg');
		// 设置附件上传目录    
		$upload->savePath = './image/Blogroll/'; 
		// 上传文件     
		$info = $upload->upload();    
		if(!$info){
			// 上传错误提示错误信息     
			$this->error('上传连接失败!!!',U('Admin/Blogroll/index'),5);
		}else{
			//接收表单信息
			$post = I('post.');  
			$path = $info['bll_pic']['savename'];
			$blogroll = D('blogroll');
			$result = $blogroll->proAdd($post,$path);
		
			// 判断返回信息
			if($result['msg'] == '1'){
				$this->success('添加成功！',U('Admin/Blogroll/index'),5);
			}else{
				$this->error('添加失败！'.$result['msg'],U('Admin/Blogroll/index'),5);
			}
		}
	}

}
