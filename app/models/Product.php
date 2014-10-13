<?php
class Product extends Eloquent{

	/**
	 * 获取基本信息
	 */
	public function getBasicInfo($tid){
		$data = DB::table('taxonomy_term_data')
				->where('tid', '=', $tid)
				->first();
		return $data;
	}

	/**
	 * 获取产品信息
	 */
	public function getProductBasicInfo($tid){
		$data = DB::table('product')
				->where('tid', '=', $tid)
				->first();
		return $data;
	}

	public function getProductOneInfo($id){
		$data = DB::table('product_info')
				->where('id', '=', $id)
				->first();
		return $data;
	}

	public function getProductDetailInfos($tid){
		$data = DB::table('product_info')
				->where('tid', '=', $tid)
				->orderBy('sort', 'desc')
				->get();
		$newData = array();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$newData[$value->type][] = $data[$key];
			}
		}
		return $newData;
	}

}