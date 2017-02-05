<?php
/*+------------------------------------------------+
      | 购物车模块控制器 
      +------------------------------------------------+                   
      | 作者:黄梓鑫                        
      | 最后修改时间:                                
      +------------------------------------------------+
 */
namespace Home\Controller;

use Think\Controller;

class ShoppingcartController extends CommonController
{
	public function shopcart()
	{
		// echo __METHOD__.'<br>';
		// 实例化对象
		$shopcart = D('shoppingcart');
		// 数据处理
		$list = $shopcart->shtList();
		$this->assign('list',$list);
		$this->display();
	}

	// 购物车商品添加
   	public function add(){
		
		// echo __METHOD__.'<br>';

		// 判断是否登录
		$data['clt_id'] = $_SESSION['homeuser']['clt_id'];

		if(empty($data['clt_id'])){
			$this->success('请先登录!',U('Home/Login/index'),2);
			exit; 
		}else{
			// 登录 添加到购物车
			// 实例化对象
			$shoppingcart = D('shoppingcart');
			// 数据处理
			$result = $shoppingcart->shtAdd();

			// 对返回值进行判断处理
			if($result['status']){
	            $this->success('添加成功！');
				// alert(添加成功);,U('Admin/Firstpage/index')
	        }else{
	            $this->error('添加失败！'.$result['msg']);
	            // alert(添加失败);,U('Admin/News/add'),5
	        }	
		}


	}
	
	// 跳转结算
	public function cartConfirm(){
		if(I('post.gos_id') == ''){
			$this->error('请选择购买商品!!!',U('Home/Shoppingcart/shopcart'),2);
		}else{
			// 实例化对象
			$address = D('address');
			// 数据处理
			$addList = $address->searchAd();
			// dump($addList);

			// 实例化对象
			$shopcart = D('shoppingcart');
			// 数据处理
			$res = $shopcart->shtSel();
	        	
			$this->assign($res);
			$this->assign('addList',$addList);
			$this->display();
		}

	}


	// 购物车数量减1
	public function jian(){
		

		$shoppingcart = D('shoppingcart');
		$res = $shoppingcart->jianNum();

		if($res){
			
			$this->redirect('shoppingcart/shopcart');
		}

	}

	// 购物车数量加1
	public function addUpdate(){
		
		$shoppingcart = D('shoppingcart');
		$res = $shoppingcart->addNum();

		if($res){
			
			$this->redirect('shoppingcart/shopcart');
		}

	}

	// ajax 删除购物车商品
	public function delShopcar()
	{	
		// 实例化对象
		$delCar = D('shoppingcart');

		$res = $delCar->delGoods();
		if($res == 1){
			$this->ajaxReturn($res);
		}else{
			$this->ajaxReturn($res);
		}
	}


	// ajax 添加到我的收藏
	public function addenshrine()
	{
		$addene = D('enshrine');
		$res = $addene->addene();

		if($res == 1){
			$this->ajaxReturn($res);
		}else{
			$this->ajaxReturn($res);
		}
	}



	// 订单确认 数据处理
	public function cartSubmit(){
		if( I('post.ads_id') == ''){
			$this->error('请选择收货地址!!!',U('Home/Shoppingcart/shopcart', array('gos_id'=>I('post.gos_id'))),2);
		}else{
			// 实例化对象
			$Connection = D('orderform');
			// 调用shopinsert方法
			$res = $Connection->shopinsert();

			// 实例化对象
			$Connection3 = D('shoppingcart');
			// 调用searchshopping方法
			$result = $Connection3->searchshopping();

			// 实例化对象
			$Connection2 = D('orderdetails');
			// 调用shopdetailss方法
			$data = $Connection2->shopdetailss($result,$res);
			
			// 商品销量 库存的加减
			$carGoods = D('goods');
			$carGoods->shtGos($result);
			
			
			// 购物车商品的删除
			if($data > 0){
				// 实例化对象
				$shoppingcart = D('shoppingcart');
				// 数据处理
				$resList = $shoppingcart->shtDelete();

				if($resList > 0){
					// 分配数据
					$this->assign('res',$res);
					$total = I('post.orm_total');
					$this->assign('total',$total);
					
					// 显示模板
					$this->display();
				}else{
					$this->error('订单提交失败！请稍后再试!!',U('Home/Shoppingcart/shopcart'),5);
				}

			}else{
				$this->error('订单提交失败！请稍后再试!!',U('Home/Shoppingcart/shopcart'),5);
			}
		}
	}
}
