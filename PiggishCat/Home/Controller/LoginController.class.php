<?php
/*+------------------------------------------------+
      | 用户登录模块控制器 
      +----------------------------------------------- 
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------
 */
namespace Home\Controller;

use Think\Controller;

class LoginController extends EmptyController
{
	//显示登录页面
	public function index()
	{
		$this->display();
	}

	//用户登录操作方法
	public function userLogin()
	{
		//检测验证码是否正确
    		$code = I('post.code');
    		// dump($code);
    		if(!$this->CheckVerity($code)){
    			$this->error('验证码错误');
    		}
		$client = D('client');
		$client->userList();
	}
	 //生成验证码  
      public function code()
      {

            $Verify = new \Think\Verify();
            $Verify->fontttf = '4.ttf'; 
            $Verify->fontSize = 20;
            $Verify->length   = 4;
            $Verify->useNoise = false;
            $Verify->entry();
      }
       //检测验证码
      public function CheckVerity($code)
	{
	      $verify = new \Think\Verify();
	      return $verify->check($code);
	}

	//ajax查询用户登录时账号是否存在
	public function ajaxName()
	{
		$client = D('client');
		$res = $client->findUser();
		$this->ajaxReturn($res);
	}
	//ajax查询用户登录时账号和密码是否匹配
	public function ajaxDyz()
	{
		$client = D('client');
		$res = $client->ajaxDopass();
		$this->ajaxReturn($res);
	}

	
}
