<?php
namespace Home\Model;
use Think\Model;
class ParametersModel extends Model
{
	public function getParam($gos_id)
	{
		$map['gos_id'] = ['eq',$gos_id];
		$data = $this->where($map)->find();
		if(!empty($data)){
			return $data;
		}
	}
}
