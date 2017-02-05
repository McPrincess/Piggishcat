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

    class NewsModel extends Model{

        // 信息添加处理
        public function nesAdd(){
            $_validate = [
                // 进行数据认证
                ['nes_detail','require','请填写信息内容!!',1],
                ['nes_detail', '1,255', '内容必须在1-255位之间' , 1 , 'length'],
                
            ];
            // 接收数据
            $list = I('post.');
             // 添加时间字段
            $list['nes_time'] = time();

            // 从session数据中拿出管理员id
            // 添加管理员id  
            $res = I('session.adminInfo');
            $list['adn_id'] = $res['adn_id'];
            
            // 准备数组接收返回值
            $result['status'] = true;
            $result[ 'msg' ] = "";

            if(!$this->validate($_validate)->create($list)){
                // 失败返回错误信息
                $result['status'] = false;
                $result[ 'msg' ] = $this->getError();

            }else{
                // 插入数据
                $list = $this->add();
                $result[ 'status' ] = true;
                $result[ 'msg' ] = '添加成功';
                
                
            }
            // 就数据返回控制器
            return $result;
        }

        // 信息后台遍历显示
        public function nesList($list,$listEgation){
           
            // 搜索
            // 接收数据
            $get = I('get.');
            // dump($get);
            // exit;
            // 分类搜索
            $map = [];
            switch ($get['search']) {
                case 'nes_id':
                    $map[ $get['search'] ] = [ 'eq', $get['content'] ];
                    break;

                case 'nes_detail':
                    $map[ $get['search'] ] = [ 'LIKE' , '%' . $get['content'] . '%' ];
                    break;

                case 'adn_id':
                    
                    $get['content'] = $listEgation[$get['content']];
                    $map[ $get['search'] ] = [ 'eq' , $get['content'] ];
                    break;
            }
            // dump($map);
            // 实例化分页类
            $page = new \Think\Page($this->where($map)->count(),10);
            $res = $this->where($map)->order('nes_id desc')->limit($page->firstRow.','.$page->listRows)->select();
           
          
            // 将管理员id 转换为 管理员姓名显示 
            foreach($res as $key => &$val){
                $val['adn_id'] = $list[ $val['adn_id'] ];
            }

            // 发布时间格式转换
            foreach($res as $key => &$val){
                $val['nes_time'] = date('Y-m-d H:i:s',$val['nes_time']);
            }
            
            // foreach ($res as $key => $val) {
            //     $res = $val;
            // }

            $num = $this->where($map)->count();
            // 得到分页
            $show = $page->show();
            return ['res' => $res, 'show' => $show, 'num' => $num];
        }

        //信息留言删除
        public function nesDelete(){

            // 接收删除id
            $get = I('get.nes_id');

            // 处理删除
            return $res = $this->delete($get);
            
        }

        // 信息后台首页遍历显示
        public function nesErgodic($list){
            // echo __METHOD__.'<br>';
            // dump($list);

            // 实例化分页类
            $page = new \Think\Page($this->count(),3);
            $res = $this->order('nes_id desc')->limit($page->firstRow.','.$page->listRows)->select();
           
          
            // 将管理员id 转换为 管理员姓名显示 
            foreach($res as $key => &$val){
                $val['adn_id'] = $list[ $val['adn_id'] ];
            }

            // 发布时间格式转换
            foreach($res as $key => &$val){
                $val['nes_time'] = date('Y-m-d H:i:s',$val['nes_time']);
            }
            
            // foreach ($res as $key => $val) {
            //     $res = $val;
            // }

            // $num = $this->count();, 'num' => $num
            // 得到分页
            $show = $page->show();
            // dump($res);
            return ['res' => $res, 'show' => $show];
        }

    }
