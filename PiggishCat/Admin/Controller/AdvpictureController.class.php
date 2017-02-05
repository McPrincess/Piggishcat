<?php
namespace Admin\Controller;
use Think\Controller;
class AdvpictureController extends CommonController 
{

	public function index()
	{
		$advPic = D('Advpicture');
		$result = $advPic->showAdvPic($post);
	
		$this->assign($result);
		$this->display();
	}

	public function addForm()
	{
		$this->display();
	}

	public function upload()
	{
		// 实例化上传类    
		$upload = new \Think\Upload();
		// 设置附件上传大小
		$upload->maxSize = 3145728;
		// 设置附件上传类型    
		$upload->exts = array('jpg','png','jpeg');
		// 设置附件上传目录    
		$upload->savePath = './image/Advpicture/'; 
		// 上传文件     
		$info = $upload->upload();    
		if(!$info){
			// 上传错误提示错误信息     
			$this->error('上传连接失败!!!',U('Admin/Advpicture/addForm'),5);
		}else{
			//接收表单信息
			
			$post = I('post.');
			$post['picture'] = $info['picture']['savename'];
		
			$home_advpic = D('Advpicture');
			$result = $home_advpic->uploadPic($post);
		
			// 判断返回信息
			if($result == 1){
				$this->success('添加成功！',U('Admin/Advpicture/index'),3);
			}else{
				$this->error('添加失败！! ! 请联系渣渣管理',U('Admin/Advpicture/addForm'),5);
			}
		}
	}

	//AJAX修改首页轮播图状态
	public function changeStatus()
	{
		// dump(I('get.'));
		$change = D('Advpicture');
		$res = $change->proStatus();
		if($res < 2){
			$this->ajaxReturn($res);
		}
	}

	//AJAX删除轮播图
	public function deleteAdv()
	{
		$delete = D('Advpicture');
		$res = $delete->proDelete();
		if($res == 1){
			$this->ajaxReturn($res);
		}
		
	}
}
