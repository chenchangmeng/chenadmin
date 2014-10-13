<?php

class ProductController extends BaseController {
	private $product;

	public function __construct(){
		parent::__construct();
		$this->product = new Product;
	}

	public function getProductDetail($tid, $vid){

		//var_dump($this->cVariable['userInfo']);

		if(is_numeric($tid) && is_numeric($vid)){
			//获取分类基本信息
			$pData = $this->product->getBasicInfo($tid);
			if(empty($pData)){
				$this->backToDashboard();
			}
			//获取产品详细信息
			$pBasicData = $this->product->getProductBasicInfo($tid);
			if(empty($pBasicData)){
				//第一次添加商品
				$this->cVariable['newFlag'] = 0;
			}else{
				//已经添加过商品
				$this->cVariable['newFlag'] = 1;
				$this->cVariable['pBasicData'] = $pBasicData;
			}

			$this->cVariable['pData'] = $pData;

			//获取商品的属性
			$detailData = $this->product->getProductDetailInfos($tid);
			$this->cVariable['detailData'] = $detailData;

			// echo "<pre>";
			// print_r($detailData);
			// echo "</pre>";
			
			return View::make('Product.ProductDetail', $this->cVariable);
		}else{
			$this->backToDashboard();
		}	
	}

	public function postProductBasicData(){
		$newFlag = Input::get("newFlag");
		$tid =  Input::get('tid');
		$productInfo = array(			
			'productInfo' => Input::get('v'),
			'isPromote' => Input::get('isPromote'),
			'promoteUrl' => Input::get('promoteUrl'),
			'isRecommend' => Input::get('isRecommend'),
			'recommendUrl' => Input::get('recommendUrl'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$bool = false;
		if(isset($newFlag) && is_numeric($tid) && $newFlag == 1){
		   //修改数据
		   $bool = DB::table('product')
            		->where('tid', $tid)
            		->update($productInfo);
		}else{
			$productInfo['tid'] = $tid;
			$productInfo['created_at'] = date('Y-m-d H:i:s');
			$bool = DB::table('product')->insert($productInfo);
		}
		if($bool){
		   echo "success";
		   exit();
		}else{
		   echo "fail";
		   exit();
		}		
	}

	/**
	 * 添加产品属性
	 */
	public function getProductInfo($tid, $vid){
		if(is_numeric($tid) && is_numeric($vid)){
			$this->cVariable['tid'] = $tid; 
			$this->cVariable['vid'] = $vid; 

			//获取当前分类的名称
			$taxonomy = new Taxonomy;
			$termData = $taxonomy->getTermData($tid);
			if(!empty($termData) && isset($termData[0])){
				$this->cVariable['tagMenu'] = $termData[0]->name;
			}else{
				$this->cVariable['tagMenu'] = "产品与服务";
			}

			return View::make('Product.ProductInfo', $this->cVariable);
		}else{
			$this->backToDashboard();
		}		
	}

	/**
	 * 修改产品属性
	 */
	public function getProductInfoUpdate($id, $tid, $vid){
		if(is_numeric($id) && is_numeric($vid)){
			//获取当前分类的名称
			$taxonomy = new Taxonomy;
			$termData = $taxonomy->getTermData($tid);
			if(!empty($termData) && isset($termData[0])){
				$this->cVariable['tagMenu'] = $termData[0]->name;
			}else{
				$this->cVariable['tagMenu'] = "产品与服务";
			}

			$this->cVariable['productInfo'] = $this->product->getProductOneInfo($id); 
			$this->cVariable['vid'] = $vid; 
			return View::make('Product.ProductInfoUpdate', $this->cVariable);
		}else{
			$this->backToDashboard();
		}
	}

	public function postProductInfoData(){
		$tid = intval(Input::get('tid'));
		$vid = intval(Input::get('vid'));
		$xss = new Xss;
		if($tid){
			$productInfoData = array(
				'tid' => $tid,
				'infoName' => $xss->clean(Input::get('infoName')),
				'infoContent' => Input::get('infoContent'),
				'type' => Input::get('type'),
				'sort' => Input::get('sort'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			);
			$action = "product/product-detail/{$tid}/{$vid}";
			$insertId = DB::table('product_info')->insertGetId($productInfoData);

			if($insertId){
			   $this->log('添加商品属性：'.$productInfoData['infoName']);
			}else{
			   $action = "product/product-info/{$tid}/{$vid}";
			}

			return Redirect::to($action);
		}else{
			$this->backToDashboard();
		}
	}

	public function postProductInfoUpdateData(){
		$id = intval(Input::get("id"));
		$tid = intval(Input::get('tid'));
		$vid = intval(Input::get('vid'));
		$xss = new Xss;
		if($id){
			$productInfoData = array(
				'infoName' => $xss->clean(Input::get('infoName')),
				'infoContent' => Input::get('infoContent'),
				'sort' => Input::get('sort'),
				'updated_at' => date('Y-m-d H:i:s')
			);
			$action = "product/product-detail/{$tid}/{$vid}";
			
			$bool = DB::table('product_info')
		            ->where('id', $id)
		            ->update($productInfoData);

			if($bool){
			   $this->log('修改商品属性：'.$productInfoData['infoName']);
			}else{
			   $action = "product/product-info/{$id}";
			}

			return Redirect::to($action);
		}else{
			$this->backToDashboard();
		}
	}

	public function getProductInfoDelete($id, $tid, $vid){
		$action = "product/product-detail/{$tid}/{$vid}";
		if(is_numeric($id)){
			$productInfo = $this->product->getProductOneInfo($id); 
			$bool = DB::table('product_info')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除商品属性：'.$productInfo->infoName);
			}
		}
		return Redirect::to($action);
	}


	public function postProductDealImg(){
		$typeImg = Input::get('typeImg');
		$upload = new Upload;
		//var_dump('expression');
		//var_dump($_FILES);
		//echo 'aaa';
		$upload->uploadImg($typeImg, 'product');
		exit(0);
	}
	
}
