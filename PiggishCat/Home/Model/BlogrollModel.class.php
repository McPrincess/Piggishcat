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

class BlogrollModel extends Model
{
	public function getLink()
	{
		$map['bll_status'] = ['eq',2];
		$data = $this->where($map)->limit(6)->select();
	
		return ['link'=>$data];
	}
}
