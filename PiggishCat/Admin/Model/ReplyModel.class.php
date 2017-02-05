<?php

    /*+------------------------------------------------+
      | 公告模块控制器
      +------------------------------------------------+                   
      | 作者:黄梓鑫                         
      | 最后修改时间:                                
      +------------------------------------------------+
     */

    namespace Admin\Model;
    
	use Think\Model;

	class ReplyModel extends Model{

		// 处理留言回复
		public function reyAdd(){
			// echo __METHOD__.'<br>';
			$_validate = [
                // 进行数据认证
                ['rey_detail','require','请填写信息内容!!',1],
            ];

			// 接收传参
			$data = I('post.');

			// 通过session获取管理员字段
			$list = I('session.adminInfo');
			$data['adn_user'] = $list['adn_user'];

			// 添加回复时间
			$data['rey_addtime'] = time();

			// 准备数组接收数据
			$result['status'] = true;
			$result['msg'] = "";

			if($this->validate($_validate)->create($data)){
				// 插入数据
				$list = $this->add($data);
				$result[ 'status' ] = true;
                $result[ 'msg' ] = '添加成功';
			}else{
				// 失败返回错误信息
                $result['status'] = false;
                $result[ 'msg' ] = $this->getError();
			}
			// 将数据返回控制器
			return $result;
		}

		// 获取回复信息
		public function reySelect(){
			
			// 获取参数 
	    	$get = I('get.');
	    	$id = $get['mee_id'];

	    	// 处理查询数据
	    	$list = $this->where("mee_id = $id")->field('adn_user,rey_detail,rey_addtime')->order('rey_id desc')->select();

	    	// 设置添加时间
	    	foreach($list as $key=>&$val){
                $val['rey_addtime'] = date('Y-m-d H:i:s',$val['rey_addtime']);
	    	}

	    	
	    	// 返回数据
	    	return $list;

		}
	    
	}
