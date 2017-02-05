<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{

	public function Category(){


			$post = I('post.');
			$cate = M('category');
			$search = $post['search'];
			$content = $post['content'];
		
		switch($search){
			case 'goy_id':
				$map['goy_id'] = ['eq',$content];
				break;
			case 'goy_name':
				$map['goy_name'] = ['eq',$content];
				break;
			case 'goy_pid':
				$map['goy_pid'] = ['eq',$content];
				break;
			default:
				$map = [];
				break;
		}
		// 实例化分页类
		$page = new \Think\Page($this->where($map)->count(),10);
		// 分页查询
		$list = $cate->where($map)->order('concat(`goy_path`,`goy_id`) asc')->limit($page->firstRow.','.$page->listRows)->select();
		$show = $page->show();
	
		return ['list' => $list, 'show' => $show];
	}

	//顶级分类数据处理
	public function Addcategory($post)
	{
		$post = $this->create($post);
		$result = [];
		if($post){
			$insertId = $this->add($post);
			$result['status'] = $insertId;
			$result['msg']	= '1';
		}else{	
			$result['msg'] = $this->getError();
		}
		return $result;
	}

	//子分类数据处理
	public function Addsuncate($post)
	{

		$post = I('post.');
		//判断是否三层分类
		if(substr_count($post['goy_path'],',') >= 3){
			redirect(U('Admin/Category/index'), 3, '已经是三级分类了...');
		}else{
			$res = $this->find_name($post['goy_name']);
			if($res){
				redirect(U('Admin/Category/index'), 3, '分类名已存在...');
			}
			
		}
		//创建数据
		$post = $this->create($post);
		//处理pid
		$post['goy_pid'] = $post['goy_id'];
		//去掉路径,自己拼接
		$post['goy_path'] = rtrim($post['goy_path'],',');
		//拼接路径
		$post['goy_path'] = $post['goy_path'].','.$post['goy_pid'].','; 
		$result = [];
		if($post){
			//把传递过来的ID删除掉!
			unset($post['goy_id']);
			$insertId = $this->add($post);
			$result['status'] = $insertId;
			$result['msg']	= '1';
		}else{	
			$result['msg'] = $this->getError();
		}
		return $result;
	}

	//根据用户传递的值,查询一次数据,验证值是否存在!
	protected function find_name($GoyName)
	{
		$map['goy_name'] = ['eq',$GoyName];
		$res = $this->where($map)->find();
		if($res){
			return true;
		}
	}

	public function cate_del()
	{
		$get = I('get.');
		$map['goy_pid'] = ['eq',$get['goy_id']]; 
		$res = $this->where($map)->find();
		if($res){
			redirect(U('Admin/Category/index'), 3, '该分类还存在子分类...');
		}else{
			$goods = D('goods');
			$map['goy_id'] = ['eq',$get['goy_id']];
			$data = $goods->where($map)->find();
			if(!$data){
				$this->delete($get['goy_id']);
				redirect(U('Admin/Category/index'), 3, '删除成功...');	
			}else{
				redirect(U('Admin/Category/index'), 3, '该分类名下有商品，不能删除...');	
			}
			
		}
	}

	public function Upsave()
	{
		$post = I('post.');
		$res = $this->find_name($post['goy_name']);
		if($res){
			redirect(U('Admin/Category/index'), 3, '分类名已存在...');
		}else{
			$map['goy_id'] = ['eq',$post['goy_id']];
			$data['goy_name'] = $post['goy_name'];
			$res = $this->where($map)->field('goy_name')->filter('strip_tags')->save($data);
			if($res){
			 	return true;
			}else{
				return false;
			}
		}
	}


	//展示关联的分类以及商品
	public function cateInfo()
	{
		$get= I('get.');
		if(substr_count($get['goy_path'],',') == 3){
			// $this->threeCate();
			return 3;
		}
		$map['goy_pid'] = ['eq',$get['goy_id']];
		// 实例化分页类
		$page = new \Think\Page($this->where($map)->count(),10);
		// 分页查询
		$list = $this->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		$show = $page->show();
		return ['list' => $list, 'show' => $show];
	}


	public function AllCategory()
	{
		$data = $this->select();
		return ['list'=>$data];
	}
}
