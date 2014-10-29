<?php

class RoleController extends BaseController {

	public function __construct(){
		parent::__construct();
		//$this->beforeFilter('csrf', array('only'=>array('postRoleAdd')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getRoleIndex()
	{		
		$roles = DB::table('role')->where('isDele', '0')->orderBy('created_at', 'desc')->skip(0)->take(10)->get();
		
		$this->cVariable['total'] = DB::table('role')->count();
        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['roleData'] = $roles;

		return View::make('Role.RoleIndex', $this->cVariable);
	}

	public function postRolePage(){
		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = DB::table('role')->count();
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $roles = DB::table('role')->where('isDele', '0')->orderBy('created_at', 'desc')->skip($offset)->take($perPageSize)->get();
        
        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>角色名</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($roles)){
			foreach ($roles as  $value) {
				$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
				$html .= "<td id=\"roleContent_{$value->roleId}\"><a href='javascript:void(0);' onclick=\"modifyRoleName(".$value->roleId.",'".$value->roleName."')\">{$value->roleName}</a></td>";
				$html .= "<td>{$value->created_at}</td>";
				$html .= "<td><a href='javascript:void(0);' onclick='DeleteRole(".$value->roleId.")'>操作</td>";
				$html .= "</tr>";
				$i = 1 - $i;
			}
		}else{
			$html .= "<tr colspan='3'>没有找到相关数据</tr>";
		}

        $html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);
	}

	public function postRoleAdd(){
		$role = new Role;

		$role->roleName = trim(Input::get('roleName'));

		if(!($user = DB::table('role')->where('roleName', $role->roleName)->first())){
			$role->save();
			echo 'succ';
			exit;
		}else{
			echo 'fail';
			exit;
		}
	}

	public function postRoleUpdate(){

		$id = trim(Input::get('id'));
		$name = trim(Input::get('name'));

		$roles = DB::table('role')
					->where('roleID', '<>', $id)
					->where('roleName', '=', $name)
					->get();
		if(!$roles){
			DB::table('role')
			->where('roleId',$id)
			->update(array('roleName'=>$name));
		}		
	}

	public function getRoleDelete($id){
		$action = "role/role-index";
		if(is_numeric($id)){
			DB::table('role')
			->where('roleId',$id)
			->update(array('isDele'=>1));
			
		}
		return Redirect::to($action);
	}


	


}
