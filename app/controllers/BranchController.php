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

}
