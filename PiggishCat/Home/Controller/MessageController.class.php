<?php
/*+------------------------------------------------+
      | 个人中心我的留言模块控制器 
      +------------------------------------------------+                   
      | 作者:黄梓鑫                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class MessageController extends CommonController
{	
	// 留言内容遍历
	public function index()
	{
		
		// 实例化对象
		$message = D('message');
		// 数据处理
		$list = $message->meeList();
		// 数据分配
		$this->assign('list',$list);
		$this->display();
	}

	// 回复内容遍历
	public function reply()
	{
		
		// 实例化对象
		$reply = D('reply');
		// 数据处理
		$list = $reply->reyList();
		// 数据分配
		$this->assign('list',$list);
		$this->display();
	}

	// 留言添加
	public function addupdate()
	{
		// 根据不同的传值方式执行不同的区间
		if(IS_GET){
			
			$this->display();
		}
		
		if(IS_POST){
			// 实例化对象
			$message = D('message');
			// 数据处理
			$result = $message->meeAdd();
			// 根据返回值执行判断跳转
			if($result['status']){
                $this->success('添加成功！',U('Home/Message/index'));
            }else{
                $this->error('添加失败！'.$result['msg'],U('Home/message/addupdate'),5);
            }
		}
	}


	// 留言删除
	public function delMessage(){

		// 实例化留言对象
		$delmee = D('message');
		//进行数据处理
		$res = $delmee->meeDel();
		
		// 对返回值进行判断处理
		if($res == 1){

			//实例化回复对象
			$delrey = D('reply');

			//进行数据处理
			$res = $delrey->reyDel();

			// 对返回值进行判断处理
			if($result == 1){
				$this->ajaxReturn($res);
			}else{
				$this->ajaxReturn($res);
			}
			
		}else{
			$this->ajaxReturn($res);
		}
	}
}
