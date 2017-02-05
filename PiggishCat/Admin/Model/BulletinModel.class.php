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

	class BulletinModel extends Model{

		/*
	    自动验证
	    */
	    protected $_validate = [
	    	// 进行数据认证

	        ['bun_detail','require','请填写公告内容!!',1],
	        ['bun_title','require','请填写公告标题!!',1],
	        
	        ['bun_title', '1,255', '公告标题必须在1-255位之间' , 1 , 'length'],
	        ['bun_place','0,1,2','请选择公告位置',1,'in'],
	    ];
			
		// 处理显示列表
	    public function proList(){
	        // 搜索
	        // 接收数据
	        $get = I('get.');
	        // dump($get);
	        // exit;
	        // 分类搜索
	        $map = [];
	        switch ($get['search']) {
	        	// 根据接收到的参数 执行不同的区间
	            case 'bun_id':
	                $map[ $get['search'] ] = [ 'eq', $get['content'] ];
	                break;

	            case 'bun_title':
	                $map[ $get['search'] ] = [ 'LIKE' , '%' . $get['content'] . '%' ];
	                break;

	            case 'bun_detail':
	                $map[ $get['search'] ] = [ 'LIKE' , '%' . $get['content'] . '%' ];
	                break;

	            case 'bun_place':
	            	if($get['content'] == '后台'){
	                	$get['content'] = 1;
	                }else if($get['content'] == '前台'){
	                	$get['content'] = 2;
	                }
	                $map[ $get['search'] ] = [ 'eq' , $get['content'] ];
	                break;
	        }

	        // 实例化分页类
	        $page = new \Think\Page($this->where($map)->count(),8);

	        // 分页查询
	        $list = $this->where($map)->order('bun_id desc')->limit($page->firstRow.','.$page->listRows)->select();

	        // 转换公告显示位置
	        $type = ['1'=>'后台', '2'=>'前台'];
	        // 变量替换
            foreach($list as $key=>&$val){
                $val['bun_place'] = $type[ $val['bun_place'] ];
            }

            // 转换公告显示位置
	        $type = ['1'=>'显示', '2'=>'隐藏'];
	        // 变量替换
            foreach($list as $key=>&$val){
                $val['bun_status'] = $type[ $val['bun_status'] ];
            }

            // 发布时间格式转换
            foreach($list as $key=>&$val){
                $val['bun_addtime'] = date('Y-m-d H:i:s',$val['bun_addtime']);
            }

            $num = $this->where($map)->count();
	        // 得到分页
	        $show = $page->show();
	        return ['list' => $list, 'show' => $show, 'num' => $num];
	    }


	    // 删除公告处理
	    public function ProDelete(){
	    	// 接收删除id
		    $id = I('get.bun_id');

		    // 进行删除操作
	        return $list = $this->delete($id);
	        
	    	
	    }

	    // 公告添加处理
	    public function proAdd(){
	    	// 接收数据
	    	$list = I('post.');
	    	
	    	// 添加时间字段
	    	$list['bun_addtime'] = time();
	    	// 插入数据
	    	$list = $this->create($list);

	    	// 对返回的数据进行判断
	    	$result = [];
	        if($list){
	        	// 成功返回添加成功
	            $insertid = $this->add();
	            $result[ 'status' ] = $insertid;
	            $result[ 'msg' ] = '添加成功';
	        }else{
	        	// 失败返回错误信息
	            $result['status'] = $list;
	            $result[ 'msg' ] = $this->getError();
	        }
	        // 就数据返回控制器
	        return $result;
	    }


	    // 遍历一条公告到首页
	    public function proErgodic(){
	    	// 查询最新添加的那一条数据并返回
	    	return $list = $this->where('bun_place = 1')->field('bun_detail')->limit(1)->order('bun_id desc')->select();
	    	
			
	    }

	    // 公告的显示和隐藏
		public function adstatus()
		{
			// 接收参数
			$post = I('post.');
			
			// 处理参数
			$map['bun_id'] = ['eq',$post['bun_id']];
			$data['bun_status'] = $post['bun_status'];

			// 执行操作
			$res = $this->where($map)->field('bun_status')->filter('strip_tags')->save($data);
			
			// 根据返回值 作出判断
			if ($res) {
			 	return 1;
			}else{
			 	return 2;
			}
			
		}
	}
