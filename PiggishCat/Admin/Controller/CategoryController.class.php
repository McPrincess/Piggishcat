<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends CommonController {
	public function index()
	{

		$Category = D('category');
		$data = $Category->Category();
		$this->assign($data);
		$this->display();
	}

	//添加顶级分类
	public function Addcate()
	{	
		if(IS_GET){
			$this->display();
		}else if(IS_POST){
			$post = I('post.');
			$Category = D('category');
			$result = $Category->Addcategory($post);
			if($result['msg'] == '1'){
				$this->success('添加成功！',U('Admin/Category/index'),5);
			}else{
				$this->error('添加失败！'.$result['msg'],U('Admin/Category/index'),5);
			}
		}
	}

	//添加子分类
	public function Subcategories()
	{

		if(IS_POST)
		{
			$Category = D('category');
			$result = $Category->Addsuncate();
			// $error = $result['msg'];
			if($result['msg'] == '1'){
			$this->success('添加成功！',U('Admin/Category/index'),5);
			exit;
		}else{
			$this->error('添加失败！',U('Admin/Category/index'),5);
			}
		}
		//############################
		//接收ID
		if(IF_GET){
			$data= I('get.');
			$this->assign('goy_id',$data['goy_id']);
			$this->assign('goy_path',$data['goy_path']);
			$this->display();
		}
	}

	//删除分类
	public function del()
	{
		$delete = D('category');
		$res = $delete->cate_del();
	}

	//修改分类名
	public function saveCate()
	{
		
		if(IS_POST)
		{
			$Category = D('category');
			$result = $Category->Upsave();
			if($result){
			$this->success('修改成功!',U('Admin/Category/index'),5);
			exit;
		}else{
			$this->error('添加失败！',U('Admin/Category/index'),5);
			}
		}

		if(IF_GET){
			$data= I('get.');
			$this->assign('goy_id',$data['goy_id']);
			$this->display();
		}
	}

}
