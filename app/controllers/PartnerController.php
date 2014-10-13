<?php

class PartnerController extends BaseController {

	private $partner;

	public function __construct(){
		parent::__construct();
		$this->partner = new Partner;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getPartnerIndex()
	{
		$this->cVariable['total'] = $this->partner->getPartnerCount();

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['partnerData'] = $this->partner->getPartnerData();

        //var_dump($this->cVariable['newsData']);

		return View::make('Partner.PartnerIndex', $this->cVariable);
	}

	public function postPartnerPage(){
		$xss = new Xss;
		$query = array();

		$brandName = $this->str_escape(Input::get("brandName"));

		$query['brandName'] = $xss->clean($brandName);

		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->partner->getPartnerCount($query);
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $newsData = $this->partner->getPartnerData($query, $offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>伙伴名称</th>";
        $html .= "<th>Logo</th>";
        $html .= "<th>排序</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($newsData)){
			foreach ($newsData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td><a href='#' title='".$value->brandName."'>{$value->showbrandName}</a></td>";
	        	$html .= "<td>";
	        		if($value->logoImgUrl){
	        			$html .= "<img src='".$value->logoImgUrl."' width='80' height='40' alt='".$value->brandName."' />";
	        		}
	        	$html .= "</td>";
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
			$html .= "<tr><td colspan='5'>没有找到相关数据</td></tr>";
		}
		$html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);

	}

	public function getPartnerAdd(){
		return View::make('Partner.PartnerAdd', $this->cVariable);
	}

	public function getPartnerUpdate($id){
		$this->cVariable['resultData'] = $this->partner->getPartnerOne($id);

		return View::make('Partner.PartnerUpdate', $this->cVariable);
	}

	public function postPartnerAddData(){
		//xss 过滤
		$xss = new Xss;

		$partInfo = array(
			'brandName' => $xss->clean(Input::get('brandName')),
			'logoImgUrl' => Input::get('partnerUrl'),
			'info' => Input::get('content'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort')
		);
		$action = "partner/partner-index";
		$insertId = DB::table('partner')->insertGetId($partInfo);
		$this->log('添加合作伙伴：'.$partInfo['brandName']);

		if(!$insertId){
			$action = "partner/partner-add";
		}

		return Redirect::to($action);
	}

	public function postPartnerUpdateData(){
		//xss 过滤
		$xss = new Xss;
		$id = Input::get('id');
		$partInfo = array(
			'brandName' => $xss->clean(Input::get('brandName')),
			'logoImgUrl' => Input::get('partnerUrl'),
			'info' => Input::get('content'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort')
		);

		$bool = DB::table('partner')
		            ->where('id', $id)
		            ->update($partInfo);
		$action = "partner/partner-index";

		if(!$bool){
			$action = "partner/partner-update/".$id;
		}
		return Redirect::to($action);
	}

	public function getPartnerDelete($id){
		$action = "partner/partner-index";
		if(is_numeric($id)){
			$newsData = DB::table('partner')->where('id', '=', $id)->get();
			$bool = DB::table('partner')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除伙伴：'.$newsData[0]->brandName);
			}
		}
		return Redirect::to($action);
	}

	public function postPartnerDealImg(){
		$typeImg = Input::get('typeImg');

		$upload = new Upload;
		//var_dump('expression');
		//var_dump($_FILES);
		//echo 'aaa';
		$upload->uploadImg($typeImg, "partner");
		exit(0);
	}


}
