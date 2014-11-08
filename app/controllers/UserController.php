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
		//当不是超级管理员时 只显示本人用户信息
		$query = array();
		if($this->cVariable['userInfo']->id != 17){
			$query['id'] = $this->cVariable['userInfo']->id;
		}
		
		$this->cVariable['total'] = $this->user->getUserCount($query);

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['userData'] = $this->user->getUserData($query);

		return View::make('User.UserIndex', $this->cVariable);
	}

	public function postUserPage(){
		$query = array();
		$query['sRealName'] = $this->str_escape(Input::get("sRealName"));
		if($this->cVariable['userInfo']->id != 17){
			$query['id'] = $this->cVariable['userInfo']->id;
		}
		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->user->getUserCount($query);
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $userData = $this->user->getUserData($query, $offset, $perPageSize);

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
				$html .= "<td>";
				$html .= "<a href='".URL::to('user/user-update/'.$value->id)."'><em class='glyphicon glyphicon-edit'></em>编辑</a>/";
				if($this->cVariable['userInfo']->id == $value->id){
					$html .= "<span style='color:red;'><em class='glyphicon glyphicon-hand-right'></em>当前用户/</span>";
				}else{
					$html .= "<a href='javascript:void(0);' onclick='DeleteUser(".$value->id.")'><em class='glyphicon glyphicon-remove'></em>删除/</a>";
				}
				if($this->cVariable['userInfo']->id == 17 && $value->id != 17){
					$html .= "<a href='javascript:void(0);'  onclick='restPass(".$value->id.")'><em class='glyphicon glyphicon-sort'></em>重置密码</a>";
				}
				$html .= "</td>";
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
		$this->cVariable['roles'] = DB::table('role')->where('isDele', 0)->orderBy('created_at', 'desc')->get();
		return View::make('User.UserAdd', $this->cVariable);
	}

	/**
	 * update Admin
	 */
	public function getUserUpdate($id){
		$this->cVariable['roles'] = DB::table('role')->where('isDele', 0)->orderBy('created_at', 'desc')->get();
		//var_dump($this->cVariable['roles']);
		$this->cVariable['userData'] = $this->user->getUserAdmin($id);
		//var_dump($this->cVariable['userData']);
		return View::make('User.UserUpdate', $this->cVariable);
	}

	public function getUserUpdatePass(){
		return View::make('User.UserUpdatePass', $this->cVariable);
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
				$action = $this->cVariable['userInfo']->id == 17 ?'user-index' : 'user-update/' . $inputData['id'];
			}
		}

		return Redirect::to('user/'.$action);	
	}

	public function postUserUnique(){
		$data = Input::all();

		$flag = $this->user->userIsUnique($data);

		echo $flag;
	}

	public function getUserDelete($id){
		$action = "user/user-index";
		if(is_numeric($id) && $this->cVariable['userInfo']->id != $id){
			$this->log('删除用户ID：'.$id);
			DB::table('users')
			->where('id',$id)
			->update(array('isDele'=>1));
		}
		return Redirect::to($action);
	}

	public function postUserResetPass(){
		$id = Input::get('id');
		if(is_numeric($id) && $this->cVariable['userInfo']->id != $id){
			$this->log('重置用户密码ID：'.$id);
			$bool = DB::table('users')
					->where('id',$id)
					->update(array('password'=> Hash::make('eta123456'), 'updated_at'=>date('Y-m-d H:i:s')));
			if($bool){
			   echo 'succ';
			   exit;
			}
		}
		echo 'fail';
		exit;
	}

	/**
	 * 确认原密码是否正确
	 */
	public function postUserPassConfirm(){
		$password = Input::get('password');
		$oldPass = DB::table('users')->where('id', $this->cVariable['userInfo']->id)->pluck('password');
		
		if (Hash::check($password, $oldPass)){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	
	public function postUserUpdatePassData(){
		$action = "user/user-index";

		$this->log('修改用户密码ID：'.$this->cVariable['userInfo']->id);
		DB::table('users')
			->where('id',$this->cVariable['userInfo']->id)
			->update(array('password'=>Hash::make(Input::get('newPassword'))));

		return Redirect::to($action);
	}

}
