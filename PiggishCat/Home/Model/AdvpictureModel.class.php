<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:cong                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */

namespace Home\Model;

use Think\Model;

class AdvpictureModel extends Model
{
	public function showAdvpic()
	{
		$map['status'] = ['eq',2];
		$data = $this->order('addtime desc')->where($map)->limit(6)->select();
		return ['JsAdvpic'=>$data];
	}
}
