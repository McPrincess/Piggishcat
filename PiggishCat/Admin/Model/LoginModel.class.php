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

	public function proLogin()
    {

    	if(IS_POST){
    		$post = (I('post.'));
    		$password = $post['adn_pass'];
    		$map['adn_user'] = $post['adn_user'];
    		// $admin = D('admin');
    		$info = $this->where($map)->find();
    		dump($info);
    		if(empty($info)) {
    			$this->error('用户名或密码错误');
    		}else{
    			$hash = $info['adn_pass'];
    			
			if (password_verify($password, $hash)) {
			   		 session('admin_login',$info);
					 $this->success('登录成功',U('Admin/Index/index'),3);
			} else {
			    $this->display('index');
			}

    		}
    	}
    }

}
