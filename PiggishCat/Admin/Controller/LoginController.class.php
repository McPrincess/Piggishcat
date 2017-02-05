<?php
/*+------------------------------------------------+
      | 用户登陆模块控制器 
      +------------------------------------------------+            
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Controller;

use Think\Controller;

class LoginController extends EmptyController 
{
	//登陆操作方法
    public function login()
    {
        //检测验证码是否正确
             if(IS_GET){
                    $this->display();
                  }
                  if(IS_POST){
                        $code = I('post.code');
                // dump($code);
                if(!$this->CheckVerity($code)){
                  $this->error('验证码错误');
                }
                
                $admin = D('admin');
                $admin->proLogin();
              }
        
      
    }
     //生成验证码
    public function code()
    {
        // $config = [
        //  'length'   => 4,
      //               ''
        // ];
        $Verify = new \Think\Verify();
            $Verify->fontttf = '4.ttf'; 
            $Verify->fontSize = 20;
            $Verify->length   = 4;
            $Verify->useNoise = false;
            $Verify->entry();
        //实例化验证码类
      // $Verify = new \Think\Verify($config);
      // $Verify->useImgBg = true; 
      // $Verify->entry();
    }
    //检测验证码
    public function CheckVerity($code)
    {
    		$verify = new \Think\Verify();
    		return $verify->check($code);
    }


     //退出登录时操作
    public function outLogin()
    {
        session('adminInfo',null);
        $this->redirect('Admin/Login/login');
    }
     
}
