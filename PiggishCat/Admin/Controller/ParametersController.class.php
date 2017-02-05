<?php
namespace Admin\Controller;
use Think\Controller;
class ParametersController extends EmptyController 
{
	public function index()
	{
		
		$get = I('get.');
		$this->assign('id',$get['gos_id']);
		$this->display();
	}

	public function proParam()
	{
		$Param = D('Parameters');
		$result = $Param->addParam();
		// 判断返回信息 
		if($result['msg'] == 1){
			$this->success('添加成功！！',U('Admin/goods/index'),5);
		}else{
			$this->error('添加失败！'.$result['msg'],U('Admin/Parameters/index'),5);
		}
	}

	public function saveForm()
	{
		if(IS_GET){
			$get = I('get.');
			$this->assign('id',$get['gos_id']);
			$this->display();
		}
	}

	public function saveParam()
	{
		
		$param = D('parameters');

		$int = $param->saveParaminfo();
		if($int){
			$this->success('修改成功!!!',U('Admin/goods/index'),5);
		}else{
			$this->error('修改失败!!!',U('Admin/Parameters/saveForm'),5);
		}
	}
}
