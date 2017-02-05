<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */

namespace Home\Model;

use Think\Model;

class ClientModel extends Model
{
	//自动验证 
	protected $_validate =array(
			array('clt_user','require','用户名不能为空'),
			array('clt_user', '/^[a-zA-Z][a-zA-Z0-9_]{6,16}+$/','用户名格式不正确'),
			array('clt_user','6,16','用户名请输入6-16位',1,'length'),
			array('clt_user','','用户名已存在','0','unique',self::MODEL_INSERT),	
			array('clt_phone','require','手机号码不能为空'),
			array('clt_class','require','手机号码不能为空'),
			array('clt_pass', '/^[a-zA-Z]\w{5,21}$/','请输入6-20个以字母开头、可带数字、“_”的密码'),
			array('clt_phone','/^1[34578]\d{9}$/','手机格式错误！',1,'regex'),
			array('clt_phone','','手机号已存在','0','unique',self::MODEL_INSERT),
		);
	//自动完成
	protected $_auto = [
		['clt_pass','foo',3,'callback'],
	];
	public function foo($var)
	{
		//必须返回值 
		return password_hash($var,PASSWORD_DEFAULT);
	}
	//用户注册处理
	public function addList()
	{
		//获取提交过来的数据
		$post = I('post.');
		// dump($post);
		$post = $this->create($post);

		$result = [];
		if ($post) {
			$post['clt_addtime'] =time();
			$insert = $this->add($post);
			$result['status'] = $insert;
			$result['msg'] = 1;
		}else{
			$result['status'] = $post;
			$result['msg'] = $this->getError();
		}
		return $result;
	}

	
	//ajax查询一条用户数据,用于验证用户名
	public function findUser()
	{
		$data['clt_user'] = ['eq',I('get.clt_user')];
		$res = $this->where($data)->find();
		if ($res) {
			return 1;
		}else{
			return 2;			
		}
	}
	//ajax查询一条用户数据,用于验证用户名和密码不匹配
	public function ajaxDopass()
	{
		$map['clt_user'] = ['eq',I('post.clt_user')];
		$password = I('post.clt_pass');
		// dump($password);
		$res = $this->where($map)->find();
		
		if(!$res) {
			return 2;
		}else{
			$hash = $res['clt_pass'];
			$result = password_verify($password,$hash);
			if($result) {
				return 1;
			}
		}	 
	}

	

	//用户登录处理
	public function userList()
	{
		if (IS_POST) {
			//接收id
			$post = I('post.');
			// dump($post);
			$map['clt_user'] = ['eq',$post['clt_user']];
			$pass = $post['clt_pass'];
			$info = $this->where($map)->find();
			//判断账号密码
			if (empty($info)) {
				redirect(U('Home/Login/index'),1,'用户名或密码错误...');
			}else{
				//判断账号是否正常
				if ($info['clt_status'] !=2) {
					redirect(U('Home/Login/index'),1,'您的账号存以被封，详情请联系商家...');
				}
				//接触hash密码
				$hash = $info['clt_pass'];
				if (password_verify($pass,$hash)) {
					session('homeuser',$info);
					 redirect(U('Home/Index/index') );
				}else {
					redirect(U('Home/Login/index'), 1, '密码错误...');
				}
			}
		}		
	}

	//用户跟人中心显示处理 
	public function ClientList()
	{
		$userInfo = I('session.homeuser');
		$userInfo['clt_addtime'] = date('Y-m-d',$userInfo['clt_addtime'] );
		return $userInfo;
	}

	//用户修改手机 
	public function cltSavephone()
	{
		$userInfo = I('session.homeuser');
		$map['clt_id'] = ['eq',$userInfo['clt_id']];
		// dump($userInfo);
		// dump($map);
		$data['clt_phone'] = I('post.clt_phone');
		$data['clt_phone'] = $this->phone($data['clt_phone']);

		if (!$data['clt_phone']) {
			return false;
		}

		$res = $this->where($map)->save($data);
		if($res) {
				//清空存储在session里面的用户数据session
			session('homeuser',null);
			//查询更新后的用户数据
			$result =  $this->where($map)->find();
			//重新赋值
			session('homeuser',$result);  
		}
		return $userInfo;
	}

	//$tel用户输入的
	private function phone($tel)
	{
		if(!is_numeric($tel) || strlen($tel) != 11){
			return false;
		}else{
			$map['clt_phone'] = ['eq',$tel];
			$res = $this->where($map)->find();

			if($res){
				return false;
			}else{
				return $tel;
			}
		}
	}
	//ajax查询一条用户数据,用于用户修改密码 
	public function ajaxRepass()
	{
		$post = I('post.');
		$map['clt_id'] = ['eq',$post['clt_id']];
 		// dump($map);
		$password = I('post.clt_pass');
		$res = $this->where($map)->find();
			
			// 
		if($res) {
			$hash = $res['clt_pass'];
			$result = password_verify($password,$hash);
			if($result) {
				return 1;
			}else{
				return 3;
			}
		}else{
			return 5;
			// echo '<pre>';
			// 	print_r($res);
			// echo '</pre>';
		}	 
	}
	//用户修改密码操作方法
	public function Repass()
	{
		$post = I('post.');
		// dump($post);
		// exit;
		unset($post['pass']);
		if($post['clt_pass'] != $post['repass']){
			return false;
		}
		$data['clt_pass'] =password_hash($post['clt_pass'],PASSWORD_DEFAULT);
		// dump($data);
		// dump($post);
		$map['clt_id'] = ['eq',$post['clt_id']];
		$resq = $this->where($map)->field('clt_pass')->filter('strip_tags')->save($data);
		// dump($data);
		if($resq) {
				//清空存储在session里面的用户数据session
			session('homeuser',null);
			//查询更新后的用户数据
			$result =  $this->where($map)->find();
			//重新赋值
			session('homeuser',$result);  
			return $resq;
		}
	}
	//用户填写身份证和真实姓名
	public function AddIdname()
	{
		
		//获取提交过来的数据
		$info = I('session.homeuser');
		$map['clt_id'] = $info['clt_id'];
		// dump($map);
		$post = I('post.');
		// dump($post);
		// $post = $this->create($post);

		$result = [];
		if ($post) {
			unset($post['clt_id']);
			$insert = $this->where($map)->field('clt_identity,clt_realname')->save($post);
			$result['statu'] = $insert;
			$result['mg'] = 1;
		}else{
			$result['statu'] = $post;
			$result['mg'] = $this->getError();
		}
		if($result) {
			//清空存储在session里面的用户数据session
			session('homeuser',null);
					//查询更新后的用户数据
			$res =  $this->where($map)->find();
			//重新赋值
			session('homeuser',$res);  
			return $result;
		}
	}

	//用户修改头像
	public function inconList($res)
	{
		$pic = $res['avatar_file']['savename'];
		$post = I('session.homeuser');
		// dump($post);
		$map['clt_id'] = ['eq',$post['clt_id']];
		// dump($map);
		$data['clt_pic'] = $pic;
		$insert = $this->where($map)->field('clt_pic')->save($data);

		if($insert) {
			$image = new \Think\Image(); 
			$image->open('./Public/image/Clientpic/'.$pic);
			// // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
			$image->thumb(120,300)->save('./Public/image/Clientpic/'.$pic);
			//清空存储在session里面的用户数据session
			session('homeuser',null);
					//查询更新后的用户数据
			$res =  $this->where($map)->find();
			//重新赋值
			session('homeuser',$res);  
			return $pic;
		}
		
		
	}
	
}

