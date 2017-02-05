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

class GoodspictureModel extends Model
{

	//################热卖商品图 (可多次调用)####################
	public function hotPicture($data)
	{
		foreach($data as &$val){
			$map['gos_id'] = ['eq',$val['gos_id']];
			$map['goe_status'] = ['eq',1];
			$pic= $this->where($map)->select();
			$val['goe_path'] = $pic[0]['goe_path'];
		}

		return $data;
	}


	//################1F商品图####################
	public function ShowPic($data)
	{

		foreach($data as &$val){
			$map['gos_id'] = ['eq',$val['gos_id']];
			$map['goe_status'] = ['eq',1];
			$pic= $this->where($map)->select();
			$val['goe_path'] = $pic[0]['goe_path'];
		}
		
		return ['goodsInfo'=>$data];
	}

	//################2F商品图####################
	public function SecondPic($data)
	{
		foreach($data as &$val){
			$map['gos_id'] = ['eq',$val['gos_id']];
			$map['goe_status'] = ['eq',1];
			$pic= $this->where($map)->select();
			$val['goe_path'] = $pic[0]['goe_path'];
		}
		
		return ['secGoods'=>$data];
	}


	//################3F商品图####################
	public function ThreePic($data)
	{
		foreach($data as &$val){
			$map['gos_id'] = ['eq',$val['gos_id']];
			$map['goe_status'] = ['eq',1];
			$pic= $this->where($map)->select();
			$val['goe_path'] = $pic[0]['goe_path'];
		}
		
		return ['Thrgoods'=>$data];
	}


	//################4F商品图####################
	public function FourPic($data)
	{
		foreach($data as &$val){
			$map['gos_id'] = ['eq',$val['gos_id']];
			$map['goe_status'] = ['eq',1];
			$pic= $this->where($map)->select();
			$val['goe_path'] = $pic[0]['goe_path'];
		}
		
		return ['Fourgoods'=>$data];
	}


	//################底部商品图#############################
	public function bottomPic($data)
	{

		foreach($data	as &$val){
			$map['gos_id'] = ['eq',$val['gos_id']];
			$map['goe_status'] = ['eq',1];
			$pic= $this->where($map)->select();
			$val['goe_path'] = $pic[0]['goe_path'];
		}
		$count = count($data);
		
		$Billing[] = $data[mt_rand(1,$count)];
		$Billing[] = $data[mt_rand(6,$count)];
		$Billing[] = $data[mt_rand(11,$count)];
		$Billing[] = $data[mt_rand(11,$count)];
		$Billing_two[] = $data[mt_rand(1,$count)];
		$Billing_two[] = $data[mt_rand(6,$count)];
		$Billing_two[] = $data[mt_rand(11,$count)];
		$Billing_two[] = $data[mt_rand(11,$count)];
		$Billing_three[] = $data[mt_rand(1,$count)];
		$Billing_three[] = $data[mt_rand(6,$count)];
		$Billing_three[] = $data[mt_rand(11,$count)];
		$Billing_three[] = $data[mt_rand(11,$count)];
		
		return ['bottomPic'=>$data,'Billing'=>$Billing,'Billing_two'=>$Billing_two,'Billing_three'=>$Billing_three];
	}


	//商品详情页
	public function goodPic($id)
	{
		$map['gos_id'] = ['eq',$id];
		$map['goe_status'] = ['eq',1];
		$data = $this->where($map)->select();
		return ['picDetails'=>$data];
	}


	//################分类商品图片展示####################
	public function AllgoodsPic($picture)
	{
		// echo __METHOD__ . '<br />';
		
		foreach($picture['allProducts'] as $val){
			foreach($val as $v){

				$map['gos_id'] = ['eq',$v['gos_id']];
				$map['goe_status'] = ['eq',1];
				$pic= $this->where($map)->select();

				$v['goe_path'] = $pic[0]['goe_path'];
				//处理价格
				$v['gos_price'] = $v['gos_price'] / 100;

				$AllgoodsInfo[] = $v;
			}
			
			
		}
		

		return ['allCategorysGoods'=>$AllgoodsInfo,'show'=>$picture['show']];
	}

}
