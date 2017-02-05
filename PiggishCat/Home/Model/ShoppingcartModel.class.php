<?php
/*+------------------------------------------------+
      | 购物车model类
      +------------------------------------------------+                   
      | 作者:黄梓鑫                   
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;
use Think\Model;

class ShoppingcartModel extends Model
{
    public function shtList()
    {
        // echo __METHOD__.'<br>';
        $session = I('session.homeuser');
        $map['clt_id'] = $session['clt_id'];
        // dump($map);

        return $res = $this->where($map)->Select();
       
    }

 

    // 添加购物车
    public function shtAdd(){
        // 获取参数
        $data = I('post.');
    
        $_validate = [

            // 进行数据自动认证
            ['sht_num','require','请填写购买数量!!',1],
            ['sht_num','number','请填写正确的购买数量!!',1],
            ['sht_compare','number','购买数量过大,请联系客服!!',1],

        ];
        
        // 对添加商品的数量和库存量比较
        $data['sht_compare'] = $data['gos_inventory'] - $data['sht_num'];
        
        // 从session中获取用户id
        $session = I('session.homeuser');
        $data['clt_id'] = $session['clt_id'];

        // 添加添加时间字段
        $data['sht_addtime'] = time();

        // 准备数组接收返回值
        $result['status'] = true;
        $result[ 'msg' ] = "";


        // 接收自动验证数据
        if(!$this->validate($_validate)->create($data)){
            // 失败返回错误信息
            $result['status'] = false;
            $result[ 'msg' ] = $this->getError();

        }else{

            // 查询购物车是否存在添加商品
            $map['gos_id'] = $data['gos_id'];
            $map['clt_id'] = $data['clt_id'];
            $res = $this->where($map)->select();
            

            // 插入数据
            if($res){
                // 如果存在添加商品 将购买数量相加
                $shtNum['sht_num'] = $res[0]['sht_num'] + $data['sht_num'];

                // 将购买数量插入购物车
                $res = $this->data($shtNum)->where($map)->save();
                $result[ 'status' ] = true;
                $result[ 'msg' ] = '添加成功';

            }else{

                // 如果不存在 直接将商品添加
                $data = $this->data($data)->add();
                
                $result[ 'status' ] = true;
                $result[ 'msg' ] = '添加成功';
            }
            
        }
        // 就数据返回控制器
        return $result;

    }

    // 执行购物车商品数量减1
    public function jianNum(){
        // echo __METHOD__.'<br>';
        // 获取商品id
        $gos_id = I('get.gos_id');
        // 将购买商品数量减1
        $map['sht_num'] = I('get.sht_num') - 1;

        if($map['sht_num'] < 1){
            // 商品数量小于 1 则不插入
            return $res = '1';
        }else{
            // 执行处理
            return $res = $this->data($map)->where("gos_id = '$gos_id'")->save();
        }
          
    }  

    // 执行购物车商品数量加1
    public function addNum(){
        // echo __METHOD__.'<br>';
        // 获取商品id
        $gos_id = I('get.gos_id');
        // 将购物车商品数量加一
        $map['sht_num'] = I('get.sht_num') + 1;
        // 执行处理
        return $res = $this->data($map)->where("gos_id = '$gos_id'")->save();  
    }


    // 订单确认页
    public function shtSel(){
        
         $session = I('session.homeuser');
        // 获取传递过来的商品id
        $map['gos_id'] = array('in',I('post.gos_id'));
        $map['clt_id'] = $session['clt_id'];
       
        // 遍历要购买商品的信息
        $res = $this->where($map)->Select();

        // 要购买的商品的总价格
        $money = 0;
        foreach($res as $val){
            $money += $val['gos_price']*$val['sht_num'];

        }
        return ['res'=>$res , 'money'=>$money];
    }

    //删除购物车单条数据
    public function delGoods()
    {
        // dump(I('get.'));
        // 获取参数
        $get = I('get.');
        // 处理条件
        $map['sht_id'] = ['eq',$get['sht_id']];

        // 进行操作
        $res = $this->where($map)->delete();
        if($res > 0){
            return 1;
        }else{
            return 2;
        }

    }

    // laohan 获取购物车商品信息
    public function searchshopping(){
        // echo __METHOD__.'<br>';

        // 获取参数
        $post = I('post.');
        $session = I('session.homeuser');
        $data[] = $post['sht_id'];

        // 赋值
        $sht_id = $post['sht_id'];
        $gos_id = $post['gos_id'];
        $map['sht_id'] = array('in',$sht_id);
        $map['gos_id'] = array('in',$gos_id);

        // 执行查询
        $result = $this->where($map)->select();
        
        // 返回值
        return $result;
    }


    // 订单添加成功后 删除购物车订单
    public function shtDelete()
    {   
        // dump(I('post.'));
        // 获取参数
        $sht_id = I('post.sht_id');
            
        // 数据处理
        $map['sht_id'] = array('in',$sht_id);
        
        // 执行操作
        return $res = $this->where($map)->delete();
        
    }
    
}



