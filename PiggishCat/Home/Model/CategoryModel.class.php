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

class CategoryModel extends Model
{
	public function  showCate()
	{	
		$get = I('get.');
		// $map['goy_pid'] = ['eq',$get['goy_id']];
		$data = $this->where($map)->select();
		// $this->searchGoods($data);
		$TopCate = [];
		// $SecCate = [];
		foreach($data as $val){
			if($val['goy_pid'] == 0){
				$TopCate[]  = $val;
				// $id = $val['goy_id'];
				// $map['goy_pid'] = ['eq',$id];
				// $SecCate = $this->where($map)->select();
			}	
		}
		return ['TopCate'=>$TopCate];
	}

	//查询所有三级分类
	public function ThreeCate($get)
	{
		// echo __METHOD__ . '<br />';
		
		$TopId = $get['goy_id'];
		$map['goy_pid'] = ['eq',$TopId];

		$goodsInfo = $this->where($map)->select();

		foreach($goodsInfo as $val){
			$map['goy_pid'] = ['eq',$val['goy_id']];
			$allGoods[] = $this->where($map)->select();
		}
	
		return $allGoods;
	}

	//找出顶级分类
	public function  TopCategory()
	{
		$map['goy_pid'] = ['eq',0];
		$data = $this->where($map)->select();

		return $data;
	}


	//首页无限级分类处理
	public function  unLimited()
	{	
		$get = I('get.');
		$map['goy_pid'] = ['eq',0];
		//找出所有顶级分类
		$data['TopCate'] = $this->where($map)->select();

		//循环遍历,查询出二级分类
		foreach($data['TopCate'] as $key => $val){
			// 以顶级分类的自增ID作为条件 去查找他的子分类
			$map['goy_pid'] = ['eq',$val['goy_id']];
			//找出二级分类 以顶级分类的ID作为 $data['SecCate'] 数组中的key 
			$data['SecCate'][$val['goy_id']] = $this->where($map)->select();
			foreach($data['SecCate'][$val['goy_id']] as $values){
				// 以二级级分类的自增ID作为条件 去查找他的子分类
				$map['goy_pid'] = ['eq',$values['goy_id']];
				//找出三级分类 以二级级分类的ID作为 $data['ThreeCate'] 数组中的key 
				$data['ThreeCate'][$values['goy_id']] = $this->where($map)->select();
			}
		}
	
		return $data;
	}

	//面包屑
	public function BreadCate($goyId)
	{
		// dump($goyId);
		$map['goy_id'] = ['eq',$goyId];
		//根据ID找出路径
		$result = $this->where($map)->find();
		$path = rtrim($result['goy_path'],','); 

		// in 查询将所有父级找出来
		$map['goy_id'] = ['in' , $path];
		$category = $this->where($map)->select();
		//遍历数据讲分类名装起来
		foreach($category as $val){
			$CategoryName[] = $val['goy_name'];
			$CategoryName[] = $val['goy_id'];
		}
		
		//将三级分类名装到数组最后
		$CategoryName[] = $result['goy_name'];
		$CategoryName[] = $result['goy_id'];

		return $CategoryName;
	} 
}
