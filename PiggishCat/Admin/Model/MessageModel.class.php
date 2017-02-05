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

	class MessageModel extends Model{
		// 处理显示列表
	    public function meeList($res){
	        // 搜索
	        // 接收数据
	        $get = I('get.');
	        
	        // 分类搜索
	        $map = [];
	        switch ($get['search']) {
	        	// 根据不同的搜索内容 执行不同的区间 
	            case 'mee_id':
	                $map[ $get['search'] ] = [ 'eq', $get['content'] ];
	                break;

	            case 'mee_detail':
	                $map[ $get['search'] ] = [ 'LIKE' , '%' . $get['content'] . '%' ];
	                break;

	            case 'mee_status':
                    $type = ['未回复'=>'1','已回复'=>'2'];
                    $get['content'] = $type[$get['content']];
                    $map[ $get['search'] ] = [ 'eq' , $get['content'] ];
                    break;
	        }

	        // 实例化分页类
	        $page = new \Think\Page($this->where($map)->count(),8);

	        // 分页查询
	        $list = $this->where($map)->order('mee_id desc')->limit($page->firstRow.','.$page->listRows)->select();

	        // 转换公告显示位置
	        $type = ['1'=>'未回复', '2'=>'已回复'];

	        // 变量替换
            foreach($list as $key=>&$val){
                $val['mee_status'] = $type[ $val['mee_status'] ];
            }

	        // 变量替换
            foreach($list as $key=>&$val){
                $val['clt_id'] = $res[ $val['clt_id'] ];
            }

            // 发布时间格式转换
            foreach($list as $key=>&$val){
                $val['mee_addtime'] = date('Y-m-d H:i:s',$val['mee_addtime']);
            }

            // 得到数据总数
            $num = $this->where($map)->count();

	        // 得到分页
	        $show = $page->show();
	        return ['list' => $list, 'show' => $show, 'num' => $num];
	    }

	    // 在Reply控制器中回复成功后 跳转到这里修改留言状态
	    public function meeUpdate(){
	    	// 修改的状态
	    	$data['mee_status'] = 2;

	    	// 执行修改
	    	return $res = $this->where(I('get.'))->save($data);
	    }

	    // 回复查看遍历
	    public function meeSelect(){

	    	// 获取参数 
	    	$get = I('get.');
	    	$id = $get['mee_id'];

	    	// 处理查询数据
	    	$list = $this->where("mee_id = $id")->field('mee_detail,mee_addtime')->select();

	    	// 设置添加时间
	    	foreach($list as $key=>&$val){
                $val['mee_addtime'] = date('Y-m-d H:i:s',$val['mee_addtime']);
	    	}

	    	// 添加用户帐号
	    	$list[0]['clt_user'] = $get['clt_id'];

	    	// 返回数据
	    	return $list;

	    }
	}
