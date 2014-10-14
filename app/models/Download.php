<?php
class Download extends Eloquent{

	public function getDownloadBasicInfo($type = 'career'){
		$sql =" SELECT
					t1.*
				FROM
					eta_basic t1
				WHERE 
					t1.type = '".$type."' ";

		$result = DB::select($sql);

		return $result;
	}

	public function getSoftCount(){

		$sql =" SELECT
					count(1) as c
				FROM
					eta_soft t1 ";
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getSoftData($offset = 0, $perPageSize = 10){
		$condition = " ";

		$sql =" SELECT
					t1.*,
					t2.name as softTypeName
				FROM
					eta_soft t1
				LEFT JOIN eta_taxonomy_term_data t2 ON t1.softType = t2.tid
				ORDER BY  t1.sort  DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";

		$result = DB::select($sql);
		
		return $result;
	}

	public function getSoftOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_soft t1
				WHERE 
					t1.id = "  . intval($id);

		$result = DB::select($sql);

		return $result;
	}



}