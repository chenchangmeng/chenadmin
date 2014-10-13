<?php
class Taxonomy extends Eloquent{

	/**
	 * 获取分类词根信息
	 */
	public function getVocabularyInfo($vid){
		return DB::table('taxonomy_vocabulary')->where('vid', '=', $vid)->get();
	}


	/**
	 * 获取分类列表
	 */
	public function getTermsData($vid, $level = ""){

		$sql = "SELECT 
					t1.*
				FROM eta_taxonomy_term_data t1
				WHERE 
					t1.vid = {$vid}
				AND t1.isDele = 0
				ORDER BY concat(t1.path, '_', t1.tid) ";
		$result = DB::select($sql);
		foreach ($result as $key => $value) {
			//$level = count(explode('_', $value->path))+1;
			$result[$key]->level = count(explode('_', $value->path));
			$result[$key]->path_level = str_repeat("&nbsp;&nbsp;&nbsp;", $result[$key]->level + 1);
		}

		return $result;
	}

	/**
	 * 获取所有子类
	 */
	public function getChildTermsData($pid){
		$sql = "SELECT 
					t1.*
				FROM eta_taxonomy_term_data t1
				WHERE 
					t1.pid = {$pid}
				AND t1.isDele = 0
				ORDER BY concat(t1.path, '_', t1.tid) ";
		$result = DB::select($sql);
		foreach ($result as $key => $value) {
			//$level = count(explode('_', $value->path))+1;
			$result[$key]->level = count(explode('_', $value->path));
			$result[$key]->path_level = str_repeat("&nbsp;&nbsp;&nbsp;", $result[$key]->level);
		}

		return $result;
	}

	/**
	 * 获取单个子类
	 */
	public function getTermData($tid){
		$sql = "SELECT 
					t1.*
				FROM eta_taxonomy_term_data t1
				WHERE 
					t1.tid = {$tid}
				AND t1.isDele = 0 ";

		$result = DB::select($sql);

		return $result;
	}

	/**
	 * 验证分类的唯一性
	 */
	public function taxonomyIsUnique($data){
		$where = " Where isDele = 0 ";
		if(isset($data['vid'])){
			$where .= " AND vid = " . intval($data['vid']);
		}

		if(isset($data['tid'])){
			$where .= " AND tid <> " . intval($data['tid']);
		}

		if(isset($data['name'])){
			$where .= " AND name = '".$data['name']."' ";
		} 

		$sql = "SELECT 
					*
				FROM eta_taxonomy_term_data 
				" . $where;
		$result = DB::select($sql);
		$flag = 'false';
		if(empty($result)){
			$flag = 'true';
		}

		return $flag;
	}
	
}