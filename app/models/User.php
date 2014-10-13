<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	private $rules = array(
		'user_name' => array('required', 'regex:/^[0-9 a-zA-Z]+$/'),
		'real_name' => array('required', 'regex:/^[\x{4e00}-\x{9fa5}A-Z a-z0-9_]+$/u'),
		'password' => 'required',
		'email' => 'required|email'
	);

	public function validate($input, $type=""){
		if($type == "update"){
			unset($this->rules['password']);
		}
		return Validator::make($input, $this->rules);
	}

	public function getUserAdmin($id){
		return DB::table('users')->where('id', '=', $id)->get();
	}

	public function getUserCount($sRealName = ""){
		// $count = DB::table('users')
		// 			->join('role', 'role.roleId', '=', 'users.roleId')
		// 			->select('users.*','role.roleName')
		// 			->where(function($query){
		// 				if($sRealName){
		// 					$query->where('isDele', '=', '0')->where('realName', '=', $sRealName);
		// 				}else{
		// 					$query->where('isDele', '=', '0');
		// 				}
						
		// 			})
		// 			->count();
		// return $count;
		$condition = "WHERE isDele = 0 ";
		if($sRealName){
		   $condition .= " AND realName LIKE '%".$sRealName."%' ";
		}
		$sql = "SELECT 
					count(1) as c 
				FROM 
					eta_users  t1
				LEFT JOIN eta_role t2 ON t1.roleId = t2.roleId " . $condition;
		$result = DB::select($sql);

		return $result[0]->c;
	}

	public function getUserData($sRealName = "", $offset = 0, $perPageSize = 10){
		// $user = DB::table('users')
		// 			->join('role', 'role.roleId', '=', 'users.roleId')
		// 			->select('users.*','role.roleName')
		// 			->where(function($query){
		// 				if($sRealName){
		// 					$query->where('isDele', '=', '0')->where('realName', '=', $sRealName);
		// 				}else{
		// 					$query->where('isDele', '=', '0');
		// 				}
		// 			})
		// 			->orderBy('users.created_at', 'desc')
		// 			->skip(0)
		// 			->take(10)
		// 			->get();
		// return $user;
		$condition = "WHERE isDele = 0 ";
		if($sRealName){
		   $condition .= " AND realName LIKE '%".$sRealName."%' ";
		}
		$sql = "SELECT 
					t1.*, t2.roleName 
				FROM 
					eta_users  t1
				LEFT JOIN eta_role t2 ON t1.roleId = t2.roleId 
				{$condition}
				ORDER BY t1.created_at DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";
		$result = DB::select($sql);
		return $result;
	}


	public function addData($inputData){
		$this->userName =$inputData['user_name'];
		$this->realName = $inputData['real_name'];
		$this->password = Hash::make($inputData['password']);
		$this->roleId = $inputData['role_id'];
		$this->email = $inputData['email'];

		// $insertData = array(
		// 	'userName' => $inputData['user_name'],
		// 	'realName' => $inputData['real_name'],
		// 	'password' => Hash::make($inputData['password']),
		// 	'roleId' => $inputData['role_id'],
		// 	'email' => $inputData['email'],
		// );
		// return DB::table('users')->insert($insertData);
		return $this->save();
	}

	public function updateData($inputData){
		return DB::table('users')
				->where('id', $inputData['id'])
				->update(
					array(
						'userName' => $inputData['user_name'],
						'realName' => $inputData['real_name'],
						'roleId' => $inputData['role_id'],
						'email' => $inputData['email'],
						'updated_at' => date('Y-m-d H:i:s')
					)
				);
	}

	public function userIsUnique($data){
		$where = " Where isDele = 0 ";

		if(isset($data['id'])){
			$where .= " AND id <> " . intval($data['id']);
		}

		if(isset($data['userName'])){
			$where .= " AND userName = '".$data['userName']."' ";
		} 

		$sql = "SELECT 
					*
				FROM eta_users 
				" . $where;
		$result = DB::select($sql);
		$flag = 'false';
		if(empty($result)){
			$flag = 'true';
		}

		return $flag;
	}


}
