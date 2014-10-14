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
		$xss = new Xss;

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
			$this->log('保存软件信息简介成功');
			echo 'success';
		}else{
			echo 'fail';
		}
	}

	public function getSoftAdd(){
		//获取软件分类
		$taxonomy = new Taxonomy;
		//$softMenu = array();
		$this->cVariable['softMenu'] = $taxonomy->getTermsData(8);

		return View::make('Download.SoftAdd', $this->cVariable);
	}

	public function getSoftUpdate($id){
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
				$this->log('删除分支机构：'.$newsData[0]->softName);
			}
		}
		return Redirect::to($action);
	}

}
