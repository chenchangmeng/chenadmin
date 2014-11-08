<?php

class RoleController extends BaseController {

	private $role;

	public function __construct(){
		parent::__construct();
		//$this->beforeFilter('csrf', array('only'=>array('postRoleAdd')));
		$this->role = new Role;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getRoleIndex()
	{		
		$roles = DB::table('role')->where('isDele', '0')->orderBy('created_at', 'desc')->skip(0)->take(10)->get();
		
		$this->cVariable['total'] = DB::table('role')->where('isDele', '0')->count();
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
        $data['result_counts'] = DB::table('role')->where('isDele', '0')->count();
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
				$html .= "<td>";
				if($value->roleId != 1){
					$html .= "<a href='".URL::to('role/role-prov-index/'.$value->roleId)."' >授权/</a>";
					$html .= "<a href='javascript:void(0);' onclick='DeleteRole(".$value->roleId.")'>删除</a>";
				}
				
				
				$html .= "<td>";
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
		$xss = new Xss;

		//添加默认的权限属性
		$roleName = $xss->clean(Input::get('roleName'));
		if(!$roleName){
			echo 'fail';
			exit;
		}
		$roleData = array(
			'roleName' => $roleName,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);
		if(!($roleDt = DB::table('role')->where('roleName', $roleName)->where('isDele', '=', 0)->first())){
			DB::beginTransaction();
				$roleId = DB::table('role')->insertGetId($roleData);
				$insertBool = $this->role->setDefaultProv($roleId);
			if($roleId && $insertBool){
				DB::commit();
				echo 'succ';
				exit;
			}else{
				DB::rollback();
			}
		}
		
		echo 'fail';
		exit;
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

	/**
	 * 授权信息
	 */
	public function getRoleProvIndex($roleId){
		$this->cVariable['roleId'] = $roleId;
		$this->cVariable['roleProvData'] = $this->role->getRoleProvData($roleId);

		return View::make('Role.RoleProvIndex', $this->cVariable);
	}

	public function postRoleProvData(){
		$roleId = Input::get('roleId');
		//原有授权的节点
		$provIDS = Input::get('provIDS');
		$OprovIDS = $provIDS ? explode(',', $provIDS) : array();
		//原有未授权的节点
		$unProvIDS = Input::get('unProvIDS');
		$OunProvIDS = $unProvIDS ? explode(',', $unProvIDS) : array();

		//当前授权的节点
		$ids = Input::get('ids');
		$ids = is_array($ids) ? $ids : array();
		//$Aids = explode(',', $ids);

		//找出取消授权的节点
		$cancelNode = array_diff($OprovIDS, $ids);
		//print_r($OprovIDS);
		$cancelBool = true;
		DB::beginTransaction();
		if(!empty($cancelNode)){
			$cancelBool = $this->role->changeProvNode($cancelNode, $roleId, 0);
		}

		//添加更改当前授权的节点
		$provBool = true;
		$provNode = array_diff($ids, $OprovIDS);
		if(!empty($provNode)){
			$provBool = $this->role->changeProvNode($provNode, $roleId, 1);
		}

		if($cancelBool && $provBool){
			DB::commit();
		}else{
			DB::rollback();
		}

		return Redirect::to('role/role-index');


	}


	


}
