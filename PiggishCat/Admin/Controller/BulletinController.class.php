<?php

    /*+------------------------------------------------+
      | 公告模块控制器
      +------------------------------------------------+                   
      | 作者:黄梓鑫                         
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Controller;

use Think\Controller;

class BulletinController extends CommonController {
    
    // 公告列表
    public function index(){
        // 实例化对象
        $bulletin = D('bulletin');
        // 数据处理
        $data = $bulletin->proList();
        // 分配数据

        $this->assign($data);
        $this->display();
    }


    // 公告添加
    public function add(){

      if(IS_GET){

            // 获取管理员的权限
            $map = I('session.adminInfo');

            // 判断是否为超级管理员
            if($map['adn_grade'] == '0'){
                // 是 就显示添加页面
                $this->display();
            }else{
                // 否 就提示错误
                $this->error('权限等级不够！'.$result['msg'],U('Admin/Bulletin/index'),5);
            }
        }

        if(IS_POST){
            // 实例化对象
            $Bulletin = D('Bulletin');
            $result = $Bulletin ->proAdd();
           
           // 处理返回参数 判断是否成功
            if($result['status']){
                $this->success('添加成功！',U('Admin/Bulletin/index'));
            }else{
                $this->error('添加失败！'.$result['msg'],U('Admin/Bulletin/add'),5);
            }

        }
    }

    // 删除公告
    public function Delete(){
       
        // 实例化对象
        $bulletin = D('bulletin');
        // 数据处理
        $data = $bulletin->proDelete();

         if($data){
                $this->success('删除成功！',U('Admin/Bulletin/index'));
            }else{
                $this->error('删除失败！',U('Admin/Bulletin/index'));
            }
    }

    //ajax修改管理员权限
    public function Savestuu()
    {   
        // dump(I('post.'));
        // 实例化对象
        $bulletin = D('bulletin');
        $res = $bulletin->adstatus();
        
        if($res) {
            $this->ajaxReturn($res);
        }else{
            echo 2;
        }
    }
}
