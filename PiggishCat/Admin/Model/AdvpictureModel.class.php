<?php
namespace Admin\Model;
use Think\Model;
class AdvpictureModel extends Model
{

	public function showAdvPic()
	{
		$page = new \Think\Page($this->count(),15);
		$data = $this->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();
		$status = [1=>'禁用',2=>'启用'];
		foreach($data as &$val){
			$val['addtime'] = date('Y-m-d H:i',$val['addtime']);
			$val['status'] = $status[$val['status']];
		}
		return ['showAdv'=>$data]; 
	}
	public function uploadPic($post)
	{
		$post['addtime'] = time();
		$res = $this->add($post);
		if($res){
			$image = new \Think\Image(); 
			$image->open('./Public/image/Advpicture/'.$post['picture']);
			// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
			$image->thumb(740,401)->save('./Public/image/Advpicture/'.'homeAdv_'.$post['picture']);
			//只保留一张js效果图
			unlink('./Public/image/Advpicture/'.$post['picture']);
			return 1;
		}else{
			unlink('./Public/image/Advpicture/'.$post['picture']);
			return 2;
		}
	}

	//AJAX修改状态
	public function proStatus()
	{
		$get = I('get.');

		$data['status'] = $get['status'];
		$map['id'] = ['eq',$get['id']];
		$res = $this->where($map)->field('status')->filter('strip_tags')->save($data);
		if($res){
			return 1;
		}else{
			return 2;
		}

	}

	public function proDelete()
	{
		$get = I('get.');
		
		$map['id'] = ['eq',$get['id']];
		$data = $this->where($map)->find();

		$res = $this->where($map)->delete();
		if($res){
			unlink('./Public/image/Advpicture/homeAdv_'.$data['picture']);
			return 1;
		}else{
			return 2;
		}

	}
}
