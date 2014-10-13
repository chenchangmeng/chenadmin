<?php

class UserController extends BaseController {

	private $user;


	public function __construct(){
		parent::__construct();
		$this->user = new User;
		$this->beforeFilter('csrf', array('only'=>array('postUserAddData')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getUserIndex()
	{
		
		$this->cVariable['total'] = $this->user->getUserCount();

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['userData'] = $this->user->getUserData("");

		return View::make('User.UserIndex', $this->cVariable);
	}

	public function postUserPage(){

		$sRealName = $this->str_escape(Input::get("sRealName"));
		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->user->getUserCount($sRealName);
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $userData = $this->user->getUserData($sRealName, $offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>用户名</th>";
        $html .= "<th>真实姓名</th>";
        $html .= "<th>角色名</th>";
        $html .= "<th>邮箱</th>";
        $html .= "<th>登录次数</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($userData)){
			foreach ($userData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td>{$value->userName}</td>";
	        	$html .= "<td>{$value->realName}</td>";
	        	$html .= "<td>{$value->roleName}</td>";
	        	$html .= "<td>{$value->email}</td>";
	        	$html .= "<td>{$value->loginNum}</td>";
	        	$html .= "<td>{$value->created_at}</td>";
				$html .= "<td>操作</td>";
				$html .= "</tr>";
				$i = 1 - $i;
	        }
		}else{
			$html .= "<tr><td colspan='7'>没有找到相关数据</td></tr>";
		}
		$html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);
	}

	/**
	 * add Admin
	 */
	public function getUserAdd(){
		$this->cVariable['roles'] = DB::table('role')->orderBy('created_at', 'desc')->get();
		return View::make('User.UserAdd', $this->cVariable);
	}

	/**
	 * update Admin
	 */
	public function getUserUpdate($id){
		$this->cVariable['roles'] = DB::table('role')->orderBy('created_at', 'desc')->get();
		$this->cVariable['userData'] = $this->user->getUserAdmin($id);
		return View::make('User.UserUpdate', $this->cVariable);
	}

	public function postUserAddData(){
		//默认跳转方法
		$action = 'user-add';	
		
		$inputData = Input::all();
		$valid = $this->user->validate($inputData);
		
		if(!$valid->fails()){
			if($this->user->addData($inputData)){
				$action = 'user-index';
			}
		}

		return Redirect::to('user/'.$action);

	}

	public function postUserUpdateData(){
		$inputData = Input::all();
		//默认跳转方法
		$action = 'user-update/' . $inputData['id'];

		$valid = $this->user->validate($inputData, 'update');
		
		if(!$valid->fails()){
			if($this->user->updateData($inputData)){
				$action = 'user-index';
			}
		}

		return Redirect::to('user/'.$action);	
	}

	public function postUserUnique(){
		$data = Input::all();

		$flag = $this->user->userIsUnique($data);

		echo $flag;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
