<?php
namespace Admin\Controller;
use Think\Controller;
class GoodspictureController extends CommonController {
	public function Upload()
	{
		// 实例化上传类    
		$upload = new \Think\Upload();
		// 设置附件上传大小
		$upload->maxSize = 3145728;
		// 设置附件上传类型    
		$upload->exts = array('jpg','png','jpeg','gif');
		// 设置附件上传目录    
		$upload->savePath = './image/goods/'; 
		// 上传文件     
		$info = $upload->upload();    
		if(!$info){
			// 上传错误提示错误信息     
			$this->error('上传连接失败!!!',U('Admin/Goods/Details'),5);
		}else{
			//接收表单信息
			$GoodsPic = D('goodspicture');
			$post = I('post.');  
			$res = $GoodsPic->addGoodspic($info,$post);
			//判断返回信息
			if($res == 1){
				$this->success('添加成功！',U('Admin/Goods/Details/gos_id/'.$post['gos_id']),0);

			}else{
				$this->error('添加失败！! ! 请检查文件类型或与技术员联系',U('Admin/Goods/Details/gos_id/'.$post['gos_id']),5);
			}
		}
	}

	public function ajaxDel(){
		// echo 1;
		$goodsPic = D('Goodspicture');
		$res = $goodsPic->delPic();
		if($res){
			$this->ajaxReturn($res);
		}
	}

	public function ajaxStatus()
	{
		$PicStatus = D('goodspicture');
		$res = $PicStatus->changeStatus();
		if($res < 2){
			$this->ajaxReturn($res);
		}

	}
}
