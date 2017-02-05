<?php
	  /*+------------------------------------------------+
      | 个人中心我的留言model类
      +------------------------------------------------+                   
      | 作者:黄梓鑫                   
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;
use Think\Model;

class MessageModel extends Model
{   
    // 留言查询
    public function meeList()
    {   
        // 从session中获取用户id
        $session = I('session.homeuser');
        $map['clt_id'] = $session['clt_id'];

        // 执行查询
        $res = $this->where($map)->order('mee_id desc')->limit(15)->Select();

        // 进行数据转换
        $type = ['1'=>'未回复' ,'2'=>'已回复'];
        foreach ($res as $key => &$val){
            $val['mee_addtime'] = date('Y-m-d H:i:s',$val['mee_addtime']);
            $val['mee_status'] = $type[$val['mee_status']];
        }
        
        // 返回数据
        return $res;

    }

    // 留言添加
    public function meeAdd()
    {   
        // 自动验证
        $_validate = [
            // 进行数据认证
            ['mee_detail','require','请填写留言内容!!',1],
            ['mee_detail', '1,255', '留言内容必须在1-255位之间' , 1 , 'length'],
            
        ];

        // 获取session数据
        $session = I('session.homeuser');
        
        // 进行数组处理
        $map = I('post.');
        $map['clt_id'] = $session['clt_id'];
        $map['mee_addtime'] = time();

        // 准备数组接收返回值
        $result['status'] = true;
        $result[ 'msg' ] = "";

        // 判断验证
        if(!$this->validate($_validate)->create($map)){
                // 失败返回错误信息
                $result['status'] = false;
                $result[ 'msg' ] = $this->getError();

            }else{
                // 插入数据
                $map = $this->add();
                $result[ 'status' ] = true;
                $result[ 'msg' ] = '添加成功';
                
                
            }
            // 就数据返回控制器
            return $result;
    }

    // 删除留言
    public function meeDel()
    {
        
        // 获取参数
        $get = I('get.');
        // 处理条件
        $map['mee_id'] = ['eq',$get['mee_id']];

        // 进行操作
        $res = $this->where($map)->delete();
        if($res > 0){
            return 1;
        }else{
            return 2;
        }
    }
}



