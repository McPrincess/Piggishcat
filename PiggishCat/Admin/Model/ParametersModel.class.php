<?php
namespace Admin\Model;
use Think\Model;
class ParametersModel extends Model
{
	protected $_validate = array(     
		array('origin','require','产地不能为空'),   
		array('gos_id','','不能重复添加参数，请到详情页去修改！！',0,'unique',1),  
		array('manufacturer','require','生产商不能为空'),   
		array('productiondate','require','生产日期不能为空'),   
		array('shelflife','require','保质期不能为空'),   
		array('type','require','产品类型不能为空'),   
		array('package','require','包装信息不能为空'),   
		array('ingredients','require','配料表不能为空'),   
	);



	public function addParam()
	{

		$post = I('post.');
		$post = $this->create($post);
		$result = []; 
		if($post){
			$insertId = $this->add($post);
			$result['status'] = $insertId;
			$result['msg'] = 1;
		}else{	
			$result['msg'] = $this->getError();
		}
		return $result;
	}

	public function findParam($gos_id)
	{
		$map['gos_id'] = ['eq',$gos_id];
		$info[] = $this->where($map)->find();
		return $info;
	}
	
	public function saveParaminfo()
	{
		$post = I('post.');

		$map['gos_id'] = ['eq',$post['gos_id']];
		$data['origin'] = $post['origin'];
		$data['manufacturer'] = $post['manufacturer'];
		$data['productiondate'] = $post['productiondate'];
		$data['shelflife'] = $post['shelflife'];
		$data['type'] = $post['type'];
		$data['package'] = $post['package'];
		$data['ingredients'] = $post['ingredients'];
		$int = $this->where($map)->filter('strip_tags')->save($data); 
		return $int;
	}
}
