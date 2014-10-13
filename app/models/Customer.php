<?php

class Customer extends Eloquent{

	public function getCustomerCount($tid, $query = array()){
		$condition = "WHERE t1.otid = {$tid} ";
		if(isset($query['name']) && $query['name']){
		   $condition .= " AND name LIKE '%".$query['name']."%' ";
		}

		$sql =" SELECT
					count(1) as c
				FROM
					eta_customer t1 " . $condition;
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getCustomerData($tid, $query = array(), $offset = 0, $perPageSize = 10){
		$condition = "WHERE t1.otid = {$tid} ";
		if(isset($query['name']) && $query['name']){
		   $condition .= " AND t1.name LIKE '%".$query['name']."%' ";
		}
		
		$condition .= " ";

		$sql =" SELECT
					t1.*,
					t2.name as typeName
				FROM
					eta_customer t1
				LEFT JOIN eta_taxonomy_term_data t2 ON t1.tid = t2.tid
				{$condition}
				ORDER BY  t1.sort  DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";
				//echo $sql;
		$result = DB::select($sql);
		// if(!empty($result)){
		//    foreach ($result as $key => $value) {
		//    		$result[$key]->showbrandName = strlen($value->brandName) > 6 ? $this->utf8Substr($value->brandName, 0, 6).'...' : $value->brandName;
		//    }
		// }
		return $result;
	}

	public function getCustomerOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_customer t1
				WHERE 
					t1.id = "  . intval($id);

		$result = DB::select($sql);

		return $result;
	}



}