<?php
	  /*+------------------------------------------------+
      | 个人中心我的回复留言model类
      +------------------------------------------------+                   
      | 作者:黄梓鑫                   
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;
use Think\Model;

class ReplyModel extends Model
{
    // 回复内容查询
    public function reyList()
    {
        // 获取session数据
        $session = I('session.homeuser');
        $map['clt_user'] = $session['clt_user'];
        
        // 进行数据处理
        $res = $this->where($map)->order('rey_id desc')->limit(15)->Select();

        // 进行数据转换
        foreach ($res as $key => &$val){
            $val['mee_addtime'] = date('Y-m-d H:i:s',$val['mee_addtime']);
        }

        // 返回数据
        return $res;

    }

    // 删除回复
    public function reyDel()
    {
        // 获取参数
        $get = I('get.');
        // dump($get);
        // 处理条件
        $map['mee_id'] = ['eq',$get['mee_id']];

        // 执行查询是否存在回复
        $result = $this->where($map)->Select();
        
        // 判断是否为空 再执行不同区间
        if(!$result == null){
            // 如果存在进行删除操作
            $res = $this->where($map)->delete();
            // dump($res);
            if($res > 0){
                // 成功返回 1
                return 1;
              }else{
                // 失败返回 2
                return 2;
              }
            
        }else{
            // 如果不存在直接返回
            return 1;
        }
    }
}



