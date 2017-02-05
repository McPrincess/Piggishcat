<?php
namespace Admin\Model;
use Think\Model;
class BlogrollModel extends Model{

	protected $_validate = array(     
		array('bll_name','require','站名必须填写'), 
		array('bll_name','','站名已经存在！',0,'unique',1),  

		array('bll_address','require','网址必须填写'),   
		array('bll_address','','连接已经存在！',0,'unique',1),  
		array('bll_phone','/^1[34578]\d{9}$/','手机格式错误！',1,'regex',),
		array('bll_contacts','require','联系人不能为空'), 
	);

	public function Blogroll()
	{
		// $page = new \Think\Page($this->count(),8);
		// $show = $page->show();
		$list = $this->select();
		$type = ['1'=>'停用','2'=>'启用'];	
		foreach($list as $key=>&$val){
			$val['bll_status'] = $type[ $val['bll_status'] ];
			// $val['bll_pic'] = substr($val['bll_pic'],8);
		}
		// $show = $page->show();
		return ['list'=>$list];
	}

	/**
	 * @param  [int] [友情连接的ID]
	 */
	public function B_delete($id){
		$map['bll_id'] = ['eq',$id];
		$res = $this->where($map)->delete();
		if($res){
			return '1';
		}else{
			return '2';
		}
	}
	public function SaveStatus($get){
		// echo $get['bll_status'];
		// $get = $this->create($get);
		$map['bll_id'] = ['eq',$get['bll_id']];
		// 这里是2 的 
		$data['bll_status'] =$get['bll_status'];
		//修改后  数据库那边的状态 居然是 0 
		$res = $this->where($map)->field('bll_status')->filter('strip_tags')->save($data); 
		return $res;
	}

	public function proAdd($post,$path)
	{
		
		//拼接完整路径信息
		$post['bll_pic'] = $path;
		$post['bll_status'] = 1;
		$post = $this->create($post);
		$result = [];
		if($post){
			$insertId = $this->add($post);
			$result['status'] = $insertId;
			$result['msg'] = '1';
		}else{	
			//验证失败!失败则删除已上传的文件
			$result['msg'] = $this->getError();
			unlink('./Public/'.$path);
		}
		return $result;
	}
}
