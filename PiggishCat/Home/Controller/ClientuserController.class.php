<?php
/*+------------------------------------------------+
      | 用户个人中心用户信息模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class ClientuserController extends CommonController
{
	public function index()
	{	
		//判断用户是否登录
		// if(!I('session.homeuser')){
		// 	$this->redirect("Home/Login/index");
		// 	die();
		// }
		$client = D('client');
		$res = $client->ClientList();

		$this->assign('userInfo',$res);
		// dump($res);
		$this->display();
	}

	public function info()
	{
		$this->display();
	}
	//我的收藏 
	public function msaa()
	{
		$this->display();
	}
	//账户安全手机修改
	public function safe()
	{	
		if(IS_GET){
			$this->display();
		}

		if(IS_POST){
			$client = D('client');
			$res = $client->cltSavephone();
			
			if ($res > 0) {
				 $this->success('修改成功！',U('Home/Clientuser/index'),1);
			}else{
				$this->error('修改失败！'.$result['msg'],U('Home/Clientuser/safe'),5);
			}
		}
		
		
	}
	//用户修改密码查询原密码是否正确
	public function savePass()
	{
		$client = D('client');
		$result = $client->ajaxRepass();
		$this->ajaxReturn($result);
	}
	//用户修改密码方法
	public function orginPass()
	{
		$client = D('client');
		$res = $client->Repass();
		// dump($res);
		if ($res > 0) {
				 $this->success('修改成功,下次使用时生效！',U('Home/Clientuser/index'),1);
			}else{
				$this->error('修改失败！'.$result['msg'],U('Home/Clientuser/safe'),5);
			}
	}
	//用户完善资料是填写身份证信息 
	public function usermessage()
	{	
		if(IS_GET) {
		$this->display();
		}
		if(IS_POST) {
			$client = D('client');
			$res = $client->AddIdname();
			if($res['mg']==1){
	                $this->success('添加成功！',U('Home/Clientuser/index'),1);
	            }else{
	                $this->error('添加失败！'.$res['mg'],U('Home/Clientuser/usermessage'),5);
	            }
		}
	}
	//用户上传头像
	public function Upphoto()
	{
		$file = $_FILES;		
		 $config = array(
		        'maxSize'    =>    3145728,
		        'rootPath'   =>    './Public/image/Clientpic/',
		        'saveName'   =>    array('uniqid',''),
		        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),    
		        'autoSub'    =>    false,
		   );

	    $up = new \Think\Upload($config);// 实例化上传类 
	    $res = $up->upload($file); 
	    if($res){
	    	$client = D('client');
		$pic = $client->inconList($res);
	    	$this->ajaxReturn($pic);
	    	// print_r($pic);
	    }
		
		
	}


	//退出登录时操作
	public function outLogin()
	{
		session('homeuser',null);
		$this->redirect('Home/Index/index');
	}
   
}
