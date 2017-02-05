<?php
/*+------------------------------------------------+
      | 用户模块控制器 
      +------------------------------------------------+                   
      | 作者:周敏                        
      | 最后修改时间:                                
      +------------------------------------------------+
     */

namespace Home\Model;

use Think\Model;

class AreasModel extends Model
{
	//查询三级联动信息
	public function selAreas()
	{
		$map['area_type'] = ['eq',1];
		// dump($map);
		$res = $this->where($map)->select();
		return $res;
	}
	//遍历三级联动
	public function Aareas()
	{
		$get = I('get.');
		$map['parent_id'] = ['eq',$get['area_id']];
		$res = $this->where($map)->select();
		return $res;
	}
}
