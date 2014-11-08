<?php
class Role extends Eloquent{

	/**
	 * 每个新增角色添加默认的节点
	 */
	public function setDefaultProv($roleId){
		$provIndex = array();
		$provNode = DB::table('prov_node')->where('isDele', '=', 0)->get();
		foreach ($provNode as $key => $value) {
			$provIndex[] = array(
				'roleId' => $roleId,
				'provId' => $value->id,
				'isProv' => 0
			);
		}
		$InsertBool = DB::table('prov_index')->insert($provIndex);

		return $InsertBool;
	}
	
	/**
	 * 获取角色授权与未授权的节点
	 */
	public function getRoleProvData($roleId){
		$tempData = array();
		$provIDS = array(); //已授权ID
		$unProvIDS = array(); //未授权ID
		$sql = "SELECT
					t1.*,
				IF (t2.isProv, 1, 0) AS roleProv
				FROM
					eta_prov_node t1
				LEFT JOIN eta_prov_index t2 ON t1.id = t2.provId AND t2.roleId = {$roleId}
				WHERE
					t1.isDele = 0 ";
		$result = DB::select($sql);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				if($value->roleProv == 1){
					array_push($provIDS, $value->id);
				}else{
					array_push($unProvIDS, $value->id);
				}
				$tempData[] = array(
					'id' => $value->id,
					'provNode' => $value->provNode,
					'provNodeName' => $value->provNodeName,
					'roleProv' => $value->roleProv
				);
			}
		}

		$data = array(
			'provIDS' => implode(',', $provIDS),
			'unProvIDS' => implode(',', $unProvIDS),
			'tempData' => $tempData
		);

		return $data;
	}

	public function changeProvNode($cancelNode, $roleId, $isProv){
		$nodeStr = implode(',', $cancelNode);
		if(!$nodeStr){
			return false;
		}
		$sql ="UPDATE 
					eta_prov_index 
				set isProv = {$isProv} 
				WHERE roleId = {$roleId} 
				AND provId IN({$nodeStr})";
				//echo $sql;
		$bool = DB::update($sql);

		return $bool;
	}
}