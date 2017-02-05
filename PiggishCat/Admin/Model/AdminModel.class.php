<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */

namespace Admin\Model;

use Think\Model;

class AdminModel extends Model
{
	//自动验证 
	protected $_validate =array(
			//1这些字段就是用户表单提交的字段 
			//2.验证条件：0存在字段就验证(默认)，1 必须验证，2值不为空的时候验证
			array('adn_user','require','用户名不能为空'),
			array('adn_name','require','管理员姓名不能为空'),
			// array('adn_user', '/^[a-zA-Z][a-zA-Z0-9_]{6,16}+$/','用户名格式不正确'),
			array('adn_user','6,16','用户名请输入6-16位',1,'length'),
			array('adn_pass','require','密码不能为空',1),
			array('adn_identity','require','身份证不能为空',1),
			array('adn_identity','18,18','身份证长度不足18',1,'length'),
			array('adn_pass','repwd','两次密码不一致',1,'confirm'),
			array('adn_user','','用户名已存在','0','unique',self::MODEL_INSERT),
			array('adn_name','','管理员性名已存在','0','unique',self::MODEL_INSERT),
			array('adn_phone','/^1[34578]\d{9}$/','手机格式错误！',1,'regex'),
		);

		//自动完成
		protected $_auto = [
			['adn_pass','foo',3,'callback'],
		];
		public function foo($var)
		{
			//必须返回值
			return password_hash($var,PASSWORD_DEFAULT);
		}
		//管理员添加操作处理
		public function adnAdd($post)
		{
			//获取提交的数据
			$post = I('post.');

			$post =$this->create($post);
			// dump($post);
			// exit;
			$result = [];
			if($post){
				// dump($post);

				$insertid = $this->add();
				$result['status'] = $insertid;
				$result['msg'] = 1;
			}else{
				$result['status'] = $post;
				$result['msg'] = $this->getError();
			}
			return $result;
		}

	//管理员修改操作方法 
	public function adnSave()
	{

		$post = I('post.');
		if ($post['adn_pass'] == $post['repwd']) {
			$post['adn_pass']=password_hash($post['adn_pass'],PASSWORD_DEFAULT);
		}else{
			echo '两次密码不一样';
		}
	    		// dump($post['adn_pass']);
         	$map['adn_id'] = ['eq',$post['adn_id']];
		$data['adn_name'] = $post['adn_name'];
		$data['adn_pass'] = $post['adn_pass'];
		$data['adn_phone'] = $post['adn_phone'];
		// dump($data);
		$res = $this->where($map)->save($data);
		// dump($res);
	      return $res;
      }
      //管理员页面处理
      public function adn_Save()
            {
                 $id =  I('get.adn_id');                
                 $map['adn_id'] = ['eq',$id];
                $res =  $this->where($map)->select();
                foreach ($res as $key => $val) {
                    $res = $val;
                }
                // dump($res);
                 return $res;
         }
                

	//展示管理员列表
	public function ShowAdmin()
	{
		// $session = I('session.adminInfo');
		$page = new \Think\Page($this->count(),5);
		$show = $page->show();
		$list = $this->where($map)->order('adn_id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$show = $page->show();
		$type = [0=>'超级管理员',1=>'管理员'];
		$status = [1=>'启用中',2=>'禁用中'];
		foreach($list as $key=>&$val){
			$val['adn_grade'] = $type[ $val['adn_grade'] ];
			$val['adn_addtime'] = date('Y-m-d',$val['adn_addtime']);
			$val['adn_status'] = $status[ $val['adn_status'] ];
			
		}
		return ['list'=>$list,'show'=>$show];
	}

	//管理员登陆处理
	public function proLogin()
    {

    		if (IS_POST) {
    			//接收id
	    		$post = (I('post.'));
	    		$password = $post['adn_pass'];
	    		$map['adn_user'] = $post['adn_user'];
	    		// $admin = D('admin');
	    		$info = $this->where($map)->find();
	    		//判断管理员状态
	    		
	    		// dump($info);
	    		if(empty($info)) {
				redirect(U('Admin/Login/login'), 1, '用户名或密码错误...');
	    		}else{
	    			//判断是否账号被禁用
	    			if($info['adn_status'] != 1) {
	    				redirect(U('Admin/Login/index'), 1, '你的账号已被禁用,请联系超级管理员...');
	    			}
	    			$hash = $info['adn_pass'];
	    			
				if (password_verify($password, $hash)) {
				   		 session('adminInfo',$info);
						 redirect(U('Admin/Index/index'), 1, '登陆成功...');
				} else {
					redirect(U('Admin/Login/login'), 1, '密码错误...');
				    
				}

	    		}
    		}
    }


    /**
     	 * 删除管理员处理 
	 * @param  [int] [管理员ID]
	 */
	public function B_delete($id){
		$map['adn_id'] = ['eq',$id];
		$res = $this->where($map)->delete();
		if($res){
			return '1';
		}else{
			return '2';
		}
	}
	
	//管理员禁用与处理
	public function adstatus()
	{
		// print_r(I('post.'));
		$post = I('post.');
		
		$map['adn_id'] = ['eq',$post['adn_id']];
		$data['adn_status'] = $post['adn_status'];
		$res = $this->where($map)->field('adn_status')->filter('strip_tags')->save($data);
		/// dump($res);
		if ($res) {
		 	return 1;
		}else{
		 	return 2;
		}
		
	}

		//查询管理员id 和管理员姓名 (黄梓鑫)
	public function nesCheak(){
		return $list = $this->getField('adn_id,adn_name');
	}

	//查询管理员id 和管理员姓名 (黄梓鑫)
	public function nesEgation(){
		return $list = $this->getField('adn_name,adn_id');
	}

	//查询管理员id 和管理员姓名 (黄梓鑫)
	// 后台首页显示
	public function nesPage(){
		return $list = $this->getField('adn_id,adn_name');
	}	
	
}
