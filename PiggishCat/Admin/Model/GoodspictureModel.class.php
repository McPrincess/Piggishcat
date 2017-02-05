<?php
namespace Admin\Model;
use Think\Model;
class GoodspictureModel extends Model {

	public function showPic()
	{
		// dump(I('get.'));
		$id = I('get.gos_id');
		$map['gos_id'] = ['eq' , $id];
		$res = $this->where($map)->select();
		$status = ['禁用','启用'];
		if($res){
			foreach($res as &$val){
				$val['goe_status'] = $status[$val['goe_status']];
			}
			return ['picInfo'=>$res];
		}
	}

	public function addGoodspic($info,$post)
	{
		$path = $info['goodsFile']['savename'];
		$post['goe_path'] = $path;
		$post = $this->create($post);

		$res = $this->add($post);
		if($res){
			$image = new \Think\Image(); 
			$image->open('./Public/image/goods/'.$path);
			// // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
			$image->thumb(185, 155)->save('./Public/image/goods/'.'home_'.$info['goodsFile']['savename']);
			$image->open('./Public/image/goods/'.$path);
			$image->thumb(750,420)->save('./Public/image/goods/'.'details_'.$info['goodsFile']['savename']);
			$image->open('./Public/image/goods/'.$path);
			$image->thumb(58,58)->save('./Public/image/goods/'.'small_'.$info['goodsFile']['savename']);
			return 1;
		}else{
			unlink($post['goe_path']);
			return 2;
		}
	}

	public function delPic()
	{
		// dump(I('get.'));
		if(I('get.param') == 'del') {
			$id = I('get.goe_id');
			$map['goe_id'] = ['eq',$id];
			$picInfo = $this->where($map)->find();
			unlink('./Public/image/goods/home_'.$picInfo['goe_path']);
			unlink('./Public/image/goods/details_'.$picInfo['goe_path']);
			unlink('./Public/image/goods/'.$picInfo['goe_path']);
			$res = $this->where($map)->delete();
			if($res) {
				return 1;
			}else{
				return 2;
			}
		}else{
			return 2;
		}
	}

	public function changeStatus()
	{
		// dump(I('get.'));
		$get = I('get.');
		$id = $get['goe_id'];
		$data['goe_status'] = $get['goe_status'];
		$map['goe_id'] = ['eq',$id];
		$res = $this->where($map)->field('goe_status')->filter('strip_tags')->save($data);
		if($res){
			return 1;
		}else{
			return 2;
		}

	}
}
