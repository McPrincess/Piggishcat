<?php 
namespace Home\Widget;
use Think\Controller;
class CategoryWidget extends Controller {   
	 public function menu()
	 {        
	 	$Category = D('Category');
	 	$TopCategory = $Category->unLimited();
	 	// $TopCategory = $this->topClassification();
		
		$this->assign($TopCategory);
	 	$this->display('Widget/menu');
	 	// echo '<pre>';
	 	// 	print_r($TopCategory);
	 	// echo '</pre>';
	 }

	 //################查找顶级分类###################
	// private function topClassification()
	// {
	// 	$Category = D('Category');
	// 	$TopCategory = $Category->unLimited();

	// 	return $TopCategory;
	// }
 }
