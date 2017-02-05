<?php
namespace Admin\Controller;
use Think\Controller;
class AdvertisingController extends CommonController {
	//展示页面
	public function index()
	{
		$Show_Adv = D('Advertising');
		$Adv = $Show_Adv->findAdv();
		$this->assign($Adv);

		$this->display();
	}

	//添加页面
	public function addAdvertising()
	{
		
		$this->display();
	}

	public function proAdd()
	{
		// 实例化上传类    
		$upload = new \Think\Upload();
		// 设置附件上传大小
		$upload->maxSize = 3145728;
		// 设置附件上传类型    
		$upload->exts = array('jpg','png','jpeg');
		// 设置附件上传目录    
		$upload->savePath = './image/Advertising/'; 
		// 上传文件     
		$info = $upload->upload();    
		if(!$info){
			// 上传错误提示错误信息     
			$this->error('上传连接失败!!!',U('Admin/Advertising/addAdvertising'),5);
		}else{
			//接收表单信息
			$post = I('post.');  
			
			$post['picture'] = $info['picture']['savename'];
			
			$Adv = D('Advertising');
			$result = $Adv->addAdv($post);
		
			//判断返回信息
			if($result >= 1){
				$this->success('添加成功！',U('Admin/Advertising/index'),5);
			}else{
				$this->error('添加失败！! !请联系渣渣管理',U('Admin/Advertising/addAdvertising'),5);
			}
		}
	}

	//AJAX修改广告图状态
	public function changeStatus()
	{
		// dump(I('get.'));
		$change = D('Advertising');
		$res = $change->proStatus();
		if($res < 2){
			$this->ajaxReturn($res);
		}
	}

	//AJAX删除广告
	public function deleteAdv()
	{
		$delete = D('Advertising');
		$res = $delete->proDelete();
		if($res == 1){
			$this->ajaxReturn($res);
		}
		
	}
}
