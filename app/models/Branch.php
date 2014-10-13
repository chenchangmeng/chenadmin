<?php
class Branch extends Eloquent{

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

	public function getBranchCount($query = array()){

		$sql =" SELECT
					count(1) as c
				FROM
					eta_branch t1 ";
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getBranchData($query = array(), $offset = 0, $perPageSize = 10){
		$condition = " ";

		$sql =" SELECT
					t1.*
				FROM
					eta_branch t1
				{$condition}
				ORDER BY  t1.sort  DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";

		$result = DB::select($sql);
		if(!empty($result)){
		   foreach ($result as $key => $value) {
		   		$result[$key]->showBranchName = strlen($value->branchName) > 15 ? $this->utf8Substr($value->branchName, 0, 15).'...' : $value->branchName;
		   }
		}
		return $result;
	}

	public function getBranchOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_branch t1
				WHERE 
					t1.id = "  . intval($id);

		$result = DB::select($sql);

		return $result;
	}



	private function utf8Substr($str, $from, $len){ 
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
		'$1',$str); 
	} 




	
}