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

	public function getPropertyData($vid){
		$taxonomy = new Taxonomy;
		//获取当前分类的属性
		$propetyData = array();
		$propertyMenu = array();
		if($vid == 4){
		   //产品属性
		   $propetyData = $taxonomy->getTermsData(10);
		}else if($vid == 6){
		   //服务属性
		   $propetyData = $taxonomy->getTermsData(11);
		}
		if(!empty($propetyData)){
			foreach ($propetyData as $key => $value) {
				if($value->pid == 0){
					$propertyMenu[$value->tid]['name'] = $value->name;
					$propertyMenu[$value->tid]['sort'] = $value->weight;
					$propertyMenu[$value->tid]['tid'] = $value->tid;
				}
			}
			sort($propertyMenu);
			$c = count($propertyMenu);
			for($i=0; $i<$c;$i++){
				for($j=$c-1; $j>$i; $j--){
					if($propertyMenu[$j]['sort'] > $propertyMenu[$j-1]['sort']){
						$tmp = $propertyMenu[$j];
						$propertyMenu[$j] =  $propertyMenu[$j-1];
						$propertyMenu[$j-1] = $tmp;
					}
				}
			}
		}

		return $propertyMenu;
	}

}