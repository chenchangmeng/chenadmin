<?php

class MemberController extends BaseController {

	private $member;

	public function __construct(){
		parent::__construct();
		$this->member = new Member;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getMemberIndex()
	{
		$this->cVariable['total'] = $this->member->getMemberCount();

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['memberData'] = $this->member->getMemberData();

        $this->cVariable['memberTypeData'] = $this->member->getMemberType();
		
		return View::make('Member.MemberIndex', $this->cVariable);
	}

	public function postMemberPage(){

		$xss = new Xss;
		$query = array();

		$email = $this->str_escape(Input::get("email"));

		$query['email'] = $xss->clean($email);
		$query['fromType'] = Input::get('fromType');
		$query['memberType'] = Input::get('memberType');

		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['email'] = $query['email'];
        $data['filter']['fromType'] = $query['fromType'];
        $data['filter']['memberType'] = $query['memberType'];

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->member->getMemberCount($query);
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $newsData = $this->member->getMemberData($query, $offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>邮箱名称</th>";
        $html .= "<th>会员分类</th>";
        $html .= "<th>来源</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($newsData)){
			foreach ($newsData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td>{$value->email}</td>";
	        	$html .= "<td>{$value->memberType}</td>";
	        	$html .= "<td>{$value->fromType}</td>";
	        	$html .= "<td>{$value->created_at}</td>";
	        	$html .= "<td>";
	        	$html .= "aa";
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

	public function getMemberImport(){
		return View::make('Member.MemberImport', $this->cVariable);
	}  

	public function getMemberExport(){
		$this->cVariable['memberTypeData'] = $this->member->getMemberType();
		return View::make('Member.MemberExport', $this->cVariable);
	}

	public function postDealMemberExport(){
		$xss = new Xss;
		$query = array();

		$email = $this->str_escape(Input::get('email'));

		$query['email'] = $xss->clean($email);
		$query['fromType'] = Input::get('fromType');
		$query['memberType'] = Input::get('memberType');

		$this->member->memberExport($query);

		//echo json_encode($query);
	}

	public function postDealMemberImport(){
		//导入数据
		$this->member->memberImport();
		//跳转到会员列表页
		return Redirect::to("member/member-index");
	}

	public function getMemberSendEmail(){
		$v = $this->member->sendEmail();
		var_dump($v);
	}


	


}
