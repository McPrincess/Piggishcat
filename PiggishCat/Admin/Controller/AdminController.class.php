<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                 
      +------------------------------------------------+
     */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends CommonController 
{
	//管理员列表显示
    public function index()
    {
    	//实例化管理员表
    	$admin = D('admin');
    	//处理数据
    	$data = $admin->ShowAdmin();
     //分配数据
    	$this->assign($data);
    	//分配模板
    	$this->display();
    	// dump(I('session.'));

    }


     //管理员删除操作
    // public function del()
    // {

    		// // 接收id
    		// $adn_id = I('get.adn_id');
    		// // dump($adn_id);
    		// // exit;
    		// //实例化对象 
    		// $user = D('admin');
    		// //通过where条件
    		// $map['adn_id'] = ['eq', $adn_id];
    		// //实现操作
    		// $res = $user->where($map)->delete();
    		// //判断是否删除成功
    		// if ( $res  > 0) {
	    	// 	$this->success('删除成功',U('Admin/Admin/Index'),1);
	    	// }else{
	    	// 	$this->error('删除失败',U('Admin/Admin/Index'),2);
	    	// }
    // }

    //管理员添加操作
    public function add()
      {		

	    	if (IS_GET) {
	    		// $post = I('post.');

	    		$this->display();
	    	}
	    	if (IS_POST) {
	    		// $post = I('post.');
	    		$user = D('admin');
	    		//接收model返回来的数据
	    		$result = $user->adnAdd();
	    		if($result['msg']==1){
	                $this->success('添加成功！',U('Admin/admin/index'),1);
	            }else{
	                $this->error('添加失败！'.$result['msg'],U('Admin/admin/add'),5);
	            }
	    	}
	}

	//管理员修改操作处理 
	public function save()
	{
		if(IS_GET){
			//接收id
	    		// $get = I('get.');
	    		// dump($get);
	    		$admin = D('admin');
	    		//接收model返回来的数据
			$data = $admin->adn_Save();
			// dump($data);
			$this->assign('data',$data);
	    		// $this->assign('adn_id',$get['adn_id']);

			$this->display();
		}
		if(IS_POST){

		$admin = D('admin');
		$res = $admin->adnSave();
		// dump($data);
		//判断是否插入成功
		if($res>0){
	                $this->success('修改成功！',U('Admin/admin/index'),1);
	            }else{
	                $this->error('修改失败！'.$result['msg'],U('Admin/admin/save'),5);
	            }
		}
		
	}
	
	//管理员修改页面操作
	public function saveList()
	{
		$admin = D('admin');
		//接收model返回来的数据
		$data = $admin->adn_Save();
		$this->assign('data',$data);
		$this->display();
	}
	
	//ajax删除管理员
	public function delete()
	{
		$id = I('get.adn_id');

		$delete = D('admin');
		$res = $delete->B_delete($id);
		$this->ajaxReturn($res);
	}

	//ajax修改管理员权限
	public function Savestuu()
	{
		$admin = D('admin');
		$res = $admin->adstatus();
		// dump($res);
		if($res) {
			$this->ajaxReturn($res);
		}else{
			echo 2;
		}
	}
}
