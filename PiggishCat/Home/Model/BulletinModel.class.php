<?php
/*+------------------------------------------------+
      | 公告model类
      +------------------------------------------------+                   
      | 作者:黄梓鑫                   
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;
use Think\Model;

class BulletinModel extends Model
{
    // 前台公告展示
    public function indexList()
    {
        // echo __METHOD__.'<br>';
        // 需要符合的条件
        $map['bun_place'] = '2';
        $map['bun_status'] = '1';
       
        // 根据需要获取信息
        return $res = $this->where($map)->order('bun_id desc')->select();
        
       
    }

    // 公告详情遍历
    public function bunDet()
    {
        // echo __METHOD__.'<br>';
       // echo __METHOD__.'<br>';
        
        // 需要符合的条件
        $map['bun_place'] = '2';
        $map['bun_status'] = '1';
        $mapList = $map;
        $mapList['bun_id'] = I('get.bun_id');
        // dump($mapList);
       
        // 根据需要获取信息
        $bunList = $this->field('bun_id,bun_title')->where($map)->order('bun_id desc')->limit(13)->select();
         // dump($res);

        $bunDetails = $this->field('bun_title,bun_detail,bun_addtime')->where($mapList)->select();

        // 发布时间格式转换
        foreach($bunDetails as $key => &$val){
            $val['bun_addtime'] = date('Y-m-d H:i:s',$val['bun_addtime']);
        }
         
        // 返回数组
        return['bunList'=>$bunList,'bunDetails'=>$bunDetails];
    }
}



