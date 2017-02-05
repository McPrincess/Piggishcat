<?php
/*+------------------------------------------------+
      | 用户注册模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class RegistController extends EmptyController
{
      //用户注册显示	
      public function index()
      {
            if (IS_GET) {
                  $this->display();
            }
            if (IS_POST) {
                  $client = D('client');
                  $result = $client->addList();
                  if($result['msg']==1){
                      $this->success('注册成功,！',U('Home/Login/index'),1);
                  }else{
                      $this->error('注册失败！'.$result['msg'],U('Home/Regist/index'),2);
                  }
            }

            
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
    //ajax查询数据库用户名
    public function ajaxUser()
    {
        $client = D('client');
        $res = $client->findUser();
        $this->ajaxReturn($res);
    }

  
}
