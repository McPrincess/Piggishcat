<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:Cong                       
      | 最后修改时间:                                
      +------------------------------------------------+
     */
namespace Home\Model;

use Think\Model;

class AdvertisingModel extends Model
{
	public function showAdv()
	{
		$map['status'] = ['eq',2];
		$data = $this->order('addtime desc')->where($map)->limit(2)->select();
		return ['AdvPicture'=>$data];
	}
}
