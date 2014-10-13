<?php
/**
 * 行业客户
 */
class CustomerController extends BaseController {

	private $customer;

	public function __construct(){
		parent::__construct();
		$this->customer = new Customer;
	}

	public function getCustomerIndex($tid, $vid){
		$taxonomy = new Taxonomy;
		$termData = $taxonomy->getTermData($tid);
		if(!empty($termData) && isset($termData[0])){
			$this->cVariable['tagMenu'] = $termData[0]->name;
		}else{
			$this->cVariable['tagMenu'] = "行业客户";
		}

		$this->cVariable['tid'] = $tid;

		$this->cVariable['total'] = $this->customer->getCustomerCount($tid);

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['customerData'] = $this->customer->getCustomerData($tid);

		return View::make('Customer.CustomerIndex', $this->cVariable);
	}

	public function postCustomerPage(){
		$xss = new Xss;
		$query = array();

		$tid = intval(Input::get("tid"));
		$name = $this->str_escape(Input::get("name"));

		$query['name'] = $xss->clean($name);

		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->customer->getCustomerCount($tid, $query);
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        // $data['filter']['name'] = $name;
        // $data['filter']['tid'] = $tid;

        $offset = ($curPage - 1) * $perPageSize;

        $newsData = $this->customer->getCustomerData($tid, $query, $offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>客户名称</th>";
        $html .= "<th>Logo</th>";
        $html .= "<th>行业分类</th>";
        $html .= "<th>排序</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($newsData)){
			foreach ($newsData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td><a target='_blank' href='".$value->url."' title='".$value->name."'>{$value->name}</a></td>";
	        	$html .= "<td>";
	        		if($value->customerUrl){
	        			$html .= "<img src='".$value->customerUrl."' width='80' height='40' alt='".$value->name."' />";
	        		}
	        	$html .= "</td>";
	        	$html .= "<td>{$value->typeName}</td>";
	        	$html .= "<td>{$value->sort}</td>";
	        	$html .= "<td>{$value->created_at}</td>";
	        	$html .= "<td>";
				$html .= "<a href='".URL::to('news/news-update/'.$value->id)."'><em class='glyphicon glyphicon-edit'></em>编辑</a>/";
				$html .= "<a href='javascript:void(0);' onclick='DeletePartner(".$value->id.")'><em class='glyphicon glyphicon-remove'></em>删除</a>";
				$html .= "</td>";
				$html .= "</tr>";
				$i = 1 - $i;
	        }
		}else{
			$html .= "<tr><td colspan='6'>没有找到相关数据</td></tr>";
		}
		$html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);
	}

	public function getCustomerAdd($tid){
		if(is_numeric($tid)){
			$this->cVariable['tid'] = $tid;
			$taxonomy = new Taxonomy;
			$termData = $taxonomy->getTermData($tid);
			if(!empty($termData) && isset($termData[0])){
				$this->cVariable['tagMenu'] = $termData[0]->name;
			}else{
				$this->cVariable['tagMenu'] = "行业客户";
			}

			//判断当前分类是否有子类
			$this->cVariable['childData'] = $taxonomy->getChildTermsData($tid);

			//var_dump($childData);

			return View::make('Customer.CustomerAdd', $this->cVariable);
		}else{
			//echo 'bbb';
			$this->backToDashboard();
		}
	}

	public function getCustomerUpdate($id, $tid){
		if(is_numeric($tid)){
			$this->cVariable['tid'] = $tid;
			$taxonomy = new Taxonomy;
			$termData = $taxonomy->getTermData($tid);
			if(!empty($termData) && isset($termData[0])){
				$this->cVariable['tagMenu'] = $termData[0]->name;
			}else{
				$this->cVariable['tagMenu'] = "行业客户";
			}

			//判断当前分类是否有子类
			$this->cVariable['childData'] = $taxonomy->getChildTermsData($tid);

			//当前客户详细信息
			$this->cVariable['currData'] = $this->customer->getCustomerOne($id);
			if(empty($this->cVariable['currData'])){
				//没有数据
				return Redirect::to("customer/customer-index/" . $tid . '/0');
			}

			//var_dump($childData);

			return View::make('Customer.CustomerUpdate', $this->cVariable);
		}else{
			//echo 'bbb';
			$this->backToDashboard();
		}
	}

	public function postCustomerAddData(){
		$tid = Input::get("otid");
		//xss 过滤
		$xss = new Xss;

		$customerInfo = array(
			'name' => $xss->clean(Input::get('name')),
			'customerUrl' => Input::get('customerUrl'),
			'url' => Input::get('url'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort'),
			'tid' => Input::get("typeId"),
			'otid' => $tid
		);
		$action = "customer/customer-index/" . $tid . '/0';
		$insertId = DB::table('customer')->insertGetId($customerInfo);
		$this->log('添加行业客户：'.$customerInfo['name']);

		if(!$insertId){
			$action = "customer/customer-add";
		}

		return Redirect::to($action);
	}

	public function postCustomerUpdateData(){
		$tid = Input::get("otid");
		$id = Input::get("id");
		//xss 过滤
		$xss = new Xss;

		$customerInfo = array(
			'name' => $xss->clean(Input::get('name')),
			'customerUrl' => Input::get('customerUrl'),
			'url' => Input::get('url'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort'),
			'tid' => Input::get("typeId"),
		);
		$action = "customer/customer-index/" . $tid . '/0';
		$bool = DB::table('customer')
		            ->where('id', $id)
		            ->update($customerInfo);
		
		if(!$bool){
			$action = "customer/customer-update/".$id.'/'.$tid;
		}else{
			$this->log('修改行业客户：'.$customerInfo['name']);
		}

		return Redirect::to($action);
	}

	public function getCustomerDelete($id, $tid){
		$action = "customer/customer-index/" . $tid . '/0';
		if(is_numeric($id)){
		    $newsData = DB::table('customer')->where('id', '=', $id)->get();
			$bool = DB::table('customer')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除客户：'.$newsData[0]->name);
			}

		}
		return Redirect::to($action);
	}



	public function postCustomerDealImg(){
		$typeImg = Input::get('typeImg');

		$upload = new Upload;
		//var_dump('expression');
		//var_dump($_FILES);
		//echo 'aaa';
		$upload->uploadImg($typeImg, "customer");
		exit(0);
	}


}
