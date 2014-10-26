<?php
class Company extends Eloquent{

	public function getCompanyBasicInfo($type = 'career'){
		$sql =" SELECT
					t1.*
				FROM
					eta_basic t1
				WHERE 
					t1.type = '".$type."' ";

		$result = DB::select($sql);

		return $result;
	}

	public function getBranchData($offset = 0, $perPageSize = 5){
		$condition = " ";

		$sql =" SELECT
					t1.*
				FROM
					eta_branch t1
				WHERE t1.`branchImgUrl` <> ''
				ORDER BY  t1.sort  DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";

		$result = DB::select($sql);
		
		return $result;
	}

}