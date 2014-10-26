<?php

class DownloadController extends BaseController {
	private $download;

	public function __construct(){
		parent::__construct();
		$this->download = new Download;
		//$this->beforeFilter('csrf', array('only'=>array('')));

		// php composer.phar install
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getSoftInfo($type)
	{
		$this->cVariable['softBasicData'] = $this->download->getDownloadBasicInfo('soft');


		$this->cVariable['total'] = $this->download->getSoftCount();

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['softData'] = $this->download->getSoftData();



		return View::make('Download.SoftIndex', $this->cVariable);
	}

	public function postSoftPage(){

		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->download->getSoftCount();
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $newsData = $this->download->getSoftData($offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>软件名称</th>";
        $html .= "<th>软件版本</th>";
        $html .= "<th>软件类型</th>";
        $html .= "<th>发布时间</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($newsData)){
			foreach ($newsData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td>{$value->softName}</td>";
	        	$html .= "<td>{$value->softVersion}</td>";
	        	$html .= "<td>{$value->softTypeName}</td>";
	        	$html .= "<td>{$value->softPublishDate}</td>";
	        	$html .= "<td>{$value->created_at}</td>";
	        	$html .= "<td>";
				$html .= "<a href='".URL::to('download/soft-update/'.$value->id)."'><em class='glyphicon glyphicon-edit'></em>编辑</a>/";
				$html .= "<a href='javascript:void(0);' onclick='DeleteSoft(".$value->id.")'><em class='glyphicon glyphicon-remove'></em>删除</a>";
				$html .= "</td>";
				$html .= "</tr>";
				$i = 1 - $i;
	        }
		}else{
			$html .= "<tr><td colspan='6'>没有找到相关数据</td></tr>";
		}
		$html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);

	}

	public function postDownloadBasicData(){
		$softInfo = array(
			'content' => Input::get('content'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$bool = DB::table('basic')
		            ->where('id', intval(Input::get('id')))
		            ->update($softInfo);
		if($bool){
			$this->log('保存软件与文档信息简介成功');
			echo 'success';
		}else{
			echo 'fail';
		}
	}

	public function getSoftAdd(){
		//读取需要绑定的软件
		$this->cVariable['softFile'] = $this->download->getFileList('soft');
		// echo "<pre>";
		// print_r($this->cVariable['softFile']);
		// echo "</pre>";
		//获取软件分类
		$taxonomy = new Taxonomy;
		//$softMenu = array();
		$this->cVariable['softMenu'] = $taxonomy->getTermsData(8);

		return View::make('Download.SoftAdd', $this->cVariable);
	}

	public function getSoftUpdate($id){
		//读取需要绑定的软件
		$this->cVariable['softFile'] = $this->download->getFileList('soft');
		//获取软件分类
		$taxonomy = new Taxonomy;
		//$softMenu = array();
		$this->cVariable['softMenu'] = $taxonomy->getTermsData(8);

		$this->cVariable['currData'] = $this->download->getSoftOne($id);

		return View::make('Download.SoftUpdate', $this->cVariable);
	}

	public function postSoftAddData(){
		//xss 过滤
		$xss = new Xss;

		$softInfo = array(
			'softName' => $xss->clean(Input::get('softName')),
			'softDownloadName' => $xss->clean(Input::get('softDownloadName')),
			'softVersion' => $xss->clean(Input::get('softVersion')),
			'softType' =>  Input::get('softType'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort'),
			'softPublishDate' => Input::get('softPublishDate')
		);
		$action = "download/soft-info/soft";
		$insertId = DB::table('soft')->insertGetId($softInfo);
		$this->log('添加软件：'.$softInfo['softName']);

		if(!$insertId){
			$action = "download/soft-add";
		}

		return Redirect::to($action);
	}

	public function postSoftUpdateData(){
		//xss 过滤
		$xss = new Xss;
		$id = Input::get('id');
		$softInfo = array(
			'softName' => $xss->clean(Input::get('softName')),
			'softDownloadName' => $xss->clean(Input::get('softDownloadName')),
			'softVersion' => $xss->clean(Input::get('softVersion')),
			'softType' =>  Input::get('softType'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort'),
			'softPublishDate' => Input::get('softPublishDate')
		);
		//var_dump($softInfo);
		$action = "download/soft-info/soft";
		$bool = DB::table('soft')
		            ->where('id', $id)
		            ->update($softInfo);
		$this->log('修改软件：'.$softInfo['softName']);

		if(!$bool){
			$action = "download/soft-update/".intval($id);
		}

		return Redirect::to($action);
	}

	public function getSoftDelete($id){
		$action = "download/soft-info/soft";
		if(is_numeric($id)){
			$newsData = DB::table('soft')->where('id', '=', $id)->get();
			$bool = DB::table('soft')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除软件：'.$newsData[0]->softName);
			}
		}
		return Redirect::to($action);
	}


	/**
	 * 手册
	 */
	public function getDocInfo($type){
		$this->cVariable['docBasicData'] = $this->download->getDownloadBasicInfo('doc');


		$this->cVariable['total'] = $this->download->getDocCount();;

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['docData'] = $this->download->getDocData();;

		return View::make('Download.DocIndex', $this->cVariable);
	}

	public function postDocPage(){

		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->download->getDocCount();
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $newsData = $this->download->getDocData($offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>手册名称</th>";
        $html .= "<th>手册类型</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($newsData)){
			foreach ($newsData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td>{$value->docName}</td>";
	        	$html .= "<td>{$value->docTypeName}</td>";
	        	$html .= "<td>{$value->created_at}</td>";
	        	$html .= "<td>";
				$html .= "<a href='".URL::to('download/doc-update/'.$value->id)."'><em class='glyphicon glyphicon-edit'></em>编辑</a>/";
				$html .= "<a href='javascript:void(0);' onclick='DeleteDoc(".$value->id.")'><em class='glyphicon glyphicon-remove'></em>删除</a>";
				$html .= "</td>";
				$html .= "</tr>";
				$i = 1 - $i;
	        }
		}else{
			$html .= "<tr><td colspan='6'>没有找到相关数据</td></tr>";
		}
		$html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);

	}

	public function getDocAdd(){
		//读取需要绑定的软件
		$this->cVariable['docFile'] = $this->download->getFileList('doc');
		
		$taxonomy = new Taxonomy;
		//$softMenu = array();
		$this->cVariable['docMenu'] = $taxonomy->getTermsData(9);

		return View::make('Download.DocAdd', $this->cVariable);
	}

	public function postDocAddData(){
		//xss 过滤
		$xss = new Xss;

		$docInfo = array(
			'docName' => $xss->clean(Input::get('docName')),
			'docDownloadName' => $xss->clean(Input::get('docDownloadName')),
			'docType' =>  Input::get('docType'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort')
		);
		$action = "download/doc-info/doc";
		$insertId = DB::table('doc')->insertGetId($docInfo);
		$this->log('添加手册：'.$docInfo['docName']);

		if(!$insertId){
			$action = "download/doc-add";
		}

		return Redirect::to($action);
	}

	public function getDocUpdate($id){
		//读取需要绑定的软件
		$this->cVariable['docFile'] = $this->download->getFileList('doc');
		//获取软件分类
		$taxonomy = new Taxonomy;
		//$softMenu = array();
		$this->cVariable['docMenu'] = $taxonomy->getTermsData(9);

		$this->cVariable['currData'] = $this->download->getDocOne($id);

		return View::make('Download.DocUpdate', $this->cVariable);
	}

	public function postDocUpdateData(){
		//xss 过滤
		$xss = new Xss;
		$id = Input::get('id');
		$docInfo = array(
			'docName' => $xss->clean(Input::get('docName')),
			'docDownloadName' => $xss->clean(Input::get('docDownloadName')),
			'docType' =>  Input::get('docType'),
			'updated_at' => date('Y-m-d H:i:s'),
			'sort' => (int)Input::get('sort')
		);
		$action = "download/doc-info/doc";
		$bool = DB::table('doc')
		            ->where('id', $id)
		            ->update($docInfo);
		$this->log('修改手册：'.$docInfo['docName']);

		if(!$bool){
			$action = "download/doc-update/".intval($id);
		}

		return Redirect::to($action);
	}

	public function getDocDelete($id){
		$action = "download/doc-info/doc";
		if(is_numeric($id)){
			$newsData = DB::table('doc')->where('id', '=', $id)->get();
			$bool = DB::table('doc')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除手册：'.$newsData[0]->docName);
			}
		}
		return Redirect::to($action);
	}

}
