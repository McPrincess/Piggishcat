<?php

    /*+------------------------------------------------+
      | 留言回复模块控制器
      +------------------------------------------------+                   
      | 作者:黄梓鑫                         
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Admin\Controller;

use Think\Controller;

class ReplyController extends CommonController {
    // 留言回复添加
    public function add(){

        // 根据不同的传值方式 执行不同区间
        if(IS_GET){
            // 将数据添加到隐藏域
            $this->assign('get',I('get.'));
            $this->display();
        }


        if(IS_POST){
           
            // 实例化对象
            $reply = D('reply');
            $result = $reply->reyAdd();

            // 对返回数据进行处理
            if($result['status']){

                $this->success('添加成功！',U('Admin/Message/index'));

                // 回复成功后 跳转MessageModel修改留言状态
                $message = D('message');
                $res = $message->meeUpdate();


            }else{
                $this->error('添加失败！'.$result['msg'],U('Admin/Message/index'),5);
            }
        }
    }


    public function select(){
      
      // 实例化对象
      $message = D('message');
      // 数据处理
      $meeList = $message->meeSelect();


      // 实例化对象
      $reply = D('reply');
      // 数据处理
      $reyList = $reply->reySelect();

      // 分配数据
      $this->assign('meeList',$meeList);
      $this->assign('reyList',$reyList);

      // 显示页面
      $this->display();
    }

}
