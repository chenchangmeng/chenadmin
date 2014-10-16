<?php
/**
 *  git remote add origin https://github.com/chenchangmeng/eta.git
 *  558182  密码
 *  git push origin master
 *  ntpdate us.pool.ntp.org
 */
class BaseController extends Controller {

	/**
	 * 变量
	 */
	protected $cVariable = array();

	public function __construct(){
		$this->beforeFilter('auth');
	
		//检查登录情况
		$this->initLogin();

		$this->initProduct();

		$this->initService();

		$this->initCustomer();

		$this->initCController();

		$this->initTemplate();

		
		
	}

	private function initLogin(){
		if (Auth::check()){
		    // The user is logged in...
		    $userInfo = Session::get('userInfo');
		    //var_dump($userInfo);
		    $this->cVariable['userInfo'] = unserialize($userInfo);
		}else{
			return Redirect::guest('login');
		}
	}

	/**
	 * 初始化模版
	 */
	private function initTemplate(){
		$this->cVariable['header'] = View::make('header');
		$this->cVariable['menu'] = View::make('menu', $this->cVariable);
		$this->cVariable['footer'] = View::make('footer');
	}

	private function initCController(){
		$CCName = Route::currentRouteAction();
		$CCName = substr($CCName, 0, stripos($CCName, '@', 0));
		$UPath = Request::path();
		if(stripos($UPath, '/', 0) !== false){
		   $UArr = explode('/', $UPath);
		   if(!empty($UArr) && count($UArr) > 2){
		   	  $CCName = $CCName . '_' . $UArr[2];
		   }
		}
		$this->cVariable['CCName'] = $CCName;
		//echo $this->cVariable['CCName'];
	}

	/**
	 * 获取产品分类
	 */
	private function initProduct(){
		$taxonomy = new Taxonomy;
		$productMenu = array();
		$tempData = $taxonomy->getTermsData(4);
		// echo "<pre>";
		// print_r($tempData);
		// echo "</pre>";
		if(!empty($tempData)){
			foreach ($tempData as $key => $value) {
				if($value->pid == 0){
					$productMenu[$key]['name'] = $value->name;
					$productMenu[$key]['url'] = URL::to('product/product-detail/'.$value->tid.'/'.$value->vid);
					$productMenu[$key]['sort'] = $value->weight;
					$productMenu[$key]['tid'] = $value->tid;
					$productMenu[$key]['vid'] = 4;
				}
			}
			sort($productMenu);
			//冒泡排序
			$c = count($productMenu);
			for($i=0; $i<$c;$i++){
				for($j=$c-1; $j>$i; $j--){
					if($productMenu[$j]['sort'] > $productMenu[$j-1]['sort']){
						$tmp = $productMenu[$j];
						$productMenu[$j] =  $productMenu[$j-1];
						$productMenu[$j-1] = $tmp;
					}
				}
			}
		}


		//array_multisort($productMenu, SORT_DESC, $sortNum);
		$this->cVariable['productMenu'] = $productMenu;

		// echo "<pre>";
		// print_r($productMenu);
		// echo "</pre>";
	}

	/**
	 * 获取产品分类
	 */
	private function initService(){
		$taxonomy = new Taxonomy;
		$serviceMenu = array();
		$tempData = $taxonomy->getTermsData(6);
		// echo "<pre>";
		// print_r($tempData);
		// echo "</pre>";
		if(!empty($tempData)){
			foreach ($tempData as $key => $value) {
				if($value->pid == 0){
					$serviceMenu[$value->tid]['name'] = $value->name;
					$serviceMenu[$value->tid]['url'] = URL::to('product/product-detail/'.$value->tid.'/'.$value->vid);
					$serviceMenu[$value->tid]['sort'] = $value->weight;
					$serviceMenu[$value->tid]['tid'] = $value->tid;
					$serviceMenu[$value->tid]['vid'] = 6;
					if(!isset($serviceMenu[$value->tid]['child'])){
						$serviceMenu[$value->tid]['child'] = array();
					}
				}else{
					if(isset($serviceMenu[$value->pid]['child'])){
						$serviceMenu[$value->pid]['child'][] = array(
							'name' => $value->name,
							'url' => URL::to('product/product-detail/'.$value->tid.'/'.$value->vid),
							'sort' => $value->weight,
							'tid' => $value->tid
						);
					}else{
						$serviceMenu[$value->pid]['child'] = array();
					}
				}
			}
			//冒泡排序
			$serviceMenu = $this->Msort($serviceMenu);
			
		}

		// echo "<pre>";
		// print_r($serviceMenu);
		// echo "</pre>";
		
		$this->cVariable['serviceMenu'] = $serviceMenu;
	}

	protected function Msort($serviceMenu){
		sort($serviceMenu);
		$c = count($serviceMenu);
		for($i=0; $i<$c;$i++){
			for($j=$c-1; $j>$i; $j--){
				if($serviceMenu[$j]['sort'] > $serviceMenu[$j-1]['sort']){
					$tmp = $serviceMenu[$j];
					$serviceMenu[$j] =  $serviceMenu[$j-1];
					$serviceMenu[$j-1] = $tmp;
				}
			}
			if(isset($serviceMenu[$i]['child']) && !empty($serviceMenu[$i]['child'])){
				//递归
				$serviceMenu[$i]['child'] = $this->Msort($serviceMenu[$i]['child']);
			}
		}

		return $serviceMenu;
	}

	/**
	 * 获取客户信息
	 */
	private function initCustomer(){
		$taxonomy = new Taxonomy;
		$customerMenu = array();
		$tempData = $taxonomy->getTermsData(5);

		if(!empty($tempData)){
			foreach ($tempData as $key => $value) {
				if($value->pid == 0){
					$customerMenu[$key]['name'] = $value->name;
					$customerMenu[$key]['url'] = URL::to('customer/customer-index/'.$value->tid.'/'.$value->vid);
					$customerMenu[$key]['sort'] = $value->weight;
					$customerMenu[$key]['tid'] = $value->tid;
				}
			}
			sort($customerMenu);
			//冒泡排序
			$c = count($customerMenu);
			for($i=0; $i<$c;$i++){
				for($j=$c-1; $j>$i; $j--){
					if($customerMenu[$j]['sort'] > $customerMenu[$j-1]['sort']){
						$tmp = $customerMenu[$j];
						$customerMenu[$j] =  $customerMenu[$j-1];
						$customerMenu[$j-1] = $tmp;
					}
				}
			}
		}


		//array_multisort($productMenu, SORT_DESC, $sortNum);
		$this->cVariable['customerMenu'] = $customerMenu;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function str_escape($str){
		if($str){
		   $str = htmlspecialchars($str);
		   $str = str_replace(array('_', '%', '#'), '', $str);
		}
		return $str;
	}

	/**
	 * 记录日志
	 */
	public function log($message){
		$mess = array(
			'uid' => 1,
			'ip' => Request::getClientIp(),
			'message' => $message,
			'created_at' => date('Y-m-d H:i:s')
		);

		DB::table('log')->insert($mess);
	}

	/**
	 * 发生错误时 返回面板页
	 */
	protected function backToDashboard(){
		return Redirect::to("career/career-index");
	}

	
}
