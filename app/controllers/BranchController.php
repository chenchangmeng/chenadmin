<?php

class BranchController extends BaseController {

	private $branch;

	public function __construct(){
		parent::__construct();
		$this->branch = new Branch;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getBranchIndex()
	{
		$this->cVariable['companyBasicData'] = $this->branch->getCompanyBasicInfo('company');

		$this->cVariable['total'] = $this->branch->getBranchCount();

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['branchData'] = $this->branch->getBranchData();

        //var_dump($this->cVariable['newsData']);

		return View::make('Branch.BranchIndex', $this->cVariable);
	}

	public function postCompanyBasicData(){

		$careerInfo = array(
			'type' => 'company',
			'content' => Input::get('content'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$bool = DB::table('basic')
		            ->where('id', intval(Input::get('id')))
		            ->update($careerInfo);
		if($bool){
			$this->log('保存招聘信息成功');
			echo 'success';
		}else{
			echo 'fail';
		}
	}


	public function getBranchAdd(){
		return View::make('Branch.BranchAdd', $this->cVariable);
	}

	public function getBranchUpdate($id){
		$resultData = $this->branch->getBranchOne($id);
		if(empty($resultData)){
			return Redirect::to("branch/branch-index");
		}
		$this->cVariable['resultData'] = $resultData;

		return View::make('Branch.BranchUpdate', $this->cVariable);
	}

	public function postBranchAddData(){
		//xss 过滤
		$xss = new Xss;

		$branchInfo = array(
			'branchName' => $xss->clean(Input::get('branchName')),
			'branchImgUrl' => Input::get('branchUrl'),
			'code' =>  $xss->clean(Input::get('code')),
			'mobile' =>  $xss->clean(Input::get('mobile')),
			'fax' =>  $xss->clean(Input::get('fax')),
			'email' =>  $xss->clean(Input::get('email')),
			'url' =>  $xss->clean(Input::get('url')),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort'),
			'address' =>  $xss->clean(Input::get('address'))
		);
		$action = "branch/branch-index";
		$insertId = DB::table('branch')->insertGetId($branchInfo);
		$this->log('添加分支机构：'.$branchInfo['branchName']);

		if(!$insertId){
			$action = "branch/branch-add";
		}

		return Redirect::to($action);
	}

	public function postBranchUpdateData(){
		$xss = new Xss;

		$id = Input::get('id');

		$branchInfo = array(
			'branchName' => $xss->clean(Input::get('branchName')),
			'branchImgUrl' => Input::get('branchUrl'),
			'code' =>  $xss->clean(Input::get('code')),
			'mobile' =>  $xss->clean(Input::get('mobile')),
			'fax' =>  $xss->clean(Input::get('fax')),
			'email' =>  $xss->clean(Input::get('email')),
			'url' =>  $xss->clean(Input::get('url')),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort'),
			'address' =>  $xss->clean(Input::get('address'))
		);
		$action = "branch/branch-index";
		$bool = DB::table('branch')
		            ->where('id', $id)
		            ->update($branchInfo);
		$this->log('修改分支机构：'.$branchInfo['branchName']);

		if(!$bool){
			$action = "branch/branch-update/".intval($id);
		}

		return Redirect::to($action);
	}

	public function getBranchDelete($id){
		$action = "branch/branch-index";
		if(is_numeric($id)){
			$newsData = DB::table('branch')->where('id', '=', $id)->get();
			$bool = DB::table('branch')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除分支机构：'.$newsData[0]->branchName);
			}
		}
		return Redirect::to($action);
	}

	public function postBranchDealImg(){
		$typeImg = Input::get('typeImg');

		$upload = new Upload;
		//var_dump('expression');
		//var_dump($_FILES);
		//echo 'aaa';
		$upload->uploadImg($typeImg, "branch");
		exit(0);
	}

	/**
	 * 名人箴言
	 */
	public function getSloganIndex(){
		$this->cVariable['sloganData'] = $this->branch->getSloganData();
		return View::make('Branch.SloganIndex', $this->cVariable);
	}

	public function getSloganAdd(){
		return View::make('Branch.SloganAdd', $this->cVariable);
	}

	public function getSloganUpdate($id){
		$resultData = $this->branch->getSloganOne($id);
		if(empty($resultData)){
			return Redirect::to("branch/slogan-index");
		}
		$this->cVariable['resultData'] = $resultData;
		return View::make('Branch.SloganUpdate', $this->cVariable);
	}

	public function postSloganAddData(){
		//xss 过滤
		$xss = new Xss;

		$sloganInfo = array(
			'name' => $xss->clean(Input::get('name')),
			'sloganUrl' => Input::get('sloganUrl'),
			'position' =>  $xss->clean(Input::get('position')),
			'company' =>  $xss->clean(Input::get('company')),
			'slogan' =>  $xss->clean(Input::get('slogan')),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort')
		);
		$action = "branch/slogan-index";
		$insertId = DB::table('slogan')->insertGetId($sloganInfo);
		$this->log('添加名人名言：'.$sloganInfo['name']);

		if(!$insertId){
			$action = "branch/slogan-add";
		}

		return Redirect::to($action);
	}

	public function postSloganUpdateData(){
		//xss 过滤
		$xss = new Xss;
		$id = Input::get('id');
		$sloganInfo = array(
			'name' => $xss->clean(Input::get('name')),
			'sloganUrl' => Input::get('sloganUrl'),
			'position' =>  $xss->clean(Input::get('position')),
			'company' =>  $xss->clean(Input::get('company')),
			'slogan' =>  $xss->clean(Input::get('slogan')),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort')
		);
		$action = "branch/slogan-index";
		$bool = DB::table('slogan')
		            ->where('id', $id)
		            ->update($sloganInfo);
		$this->log('修改名人名言：'.$sloganInfo['name']);

		if(!$bool){
			$action = "branch/slogan-update/".intval($id);
		}

		return Redirect::to($action);
	}

	public function getSloganDelete($id){
		$action = "branch/slogan-index";
		if(is_numeric($id)){
			$bool = DB::table('slogan')->where('id', '=', $id)->delete();
			if($bool){				
				//$this->log('删除分支机构：'.$newsData[0]->branchName);
			}
		}
		return Redirect::to($action);
	}

	public function postSloganDealImg(){
		$typeImg = Input::get('typeImg');

		$upload = new Upload;
		//var_dump('expression');
		//var_dump($_FILES);
		//echo 'aaa';
		$upload->uploadImg($typeImg, "slogan");
		exit(0);
	}

}
