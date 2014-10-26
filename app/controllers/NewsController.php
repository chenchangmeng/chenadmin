<?php

class NewsController extends BaseController {

	private $news;

	public function __construct(){
		parent::__construct();
		$this->news = new News;
		//$this->beforeFilter('csrf', array('only'=>array('')));

		// php composer.phar install
	}

	public function getNewsIndex(){

		$this->cVariable['total'] = $this->news->getNewsCount();

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['newsData'] = $this->news->getNewsData();

        //var_dump($this->cVariable['newsData']);

		return View::make('News.NewsIndex', $this->cVariable);
	}

	public function postNewsPage(){
		$xss = new Xss;
		$query = array();

		$title = $this->str_escape(Input::get("title"));

		$query['title'] = $xss->clean($title);
		$query['published'] = Input::get('published');
		$query['promote'] = Input::get('promote');
		$query['sticky'] = Input::get('sticky');
		
		$page = Input::get('page');
        $page_size = Input::get('page_size');
		
		$curPage = ($page !== FALSE && $page > 1) ? $page : 1;
        $perPageSize = ($page_size !== FALSE && is_numeric($page_size)) ? $page_size : 10;

        $data['filter']['page'] = $curPage;
        $data['result_counts'] = $this->news->getNewsCount($query);
        $data['page_count'] = ceil($data['result_counts'] / $perPageSize); //总页数	

        $offset = ($curPage - 1) * $perPageSize;

        $newsData = $this->news->getNewsData($query, $offset, $perPageSize);

        $html = "<table class='table'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>标题</th>";
        $html .= "<th>发布人</th>";
        $html .= "<th>状态</th>";
        $html .= "<th>推荐幻灯片</th>";
        $html .= "<th>推荐头条</th>";
        $html .= "<th>创建时间</th>";
        $html .= "<th>操作</th>";
		$html .= "</tr>";			
		$html .= "</thead>";
		$i = 0;	
		if(!empty($newsData)){
			foreach ($newsData as  $value) {
	        	$html .= $i == 1 ? "<tr class='active'>" : "<tr>";
	        	$html .= "<td><a href='#' title='".$value->title."'>{$value->showTitle}</a></td>";
	        	$html .= "<td>{$value->userName}</td>";
	        	$html .= "<td>{$value->showPublish}</td>";
	        	$html .= "<td>{$value->showPromote}</td>";
	        	$html .= "<td>{$value->showSticky}</td>";
	        	$html .= "<td>{$value->created_at}</td>";
	        	$html .= "<td>";
				$html .= "<a href='".URL::to('news/news-update/'.$value->nid)."'><em class='glyphicon glyphicon-edit'></em>编辑</a>/";
				$html .= "<a href='javascript:void(0);' onclick='DeleteNews(".$value->nid.")'><em class='glyphicon glyphicon-remove'></em>删除</a>";
				$html .= "</td>";
				$html .= "</tr>";
				$i = 1 - $i;
	        }
		}else{
			$html .= "<tr><td colspan='7'>没有找到相关数据</td></tr>";
		}
		$html .= "</table>";

        $data['html'] = $html;
        echo json_encode($data);
	}


	/**
	 * 添加新闻
	 */
	public function getNewsAdd(){
		
		//$upload = new Upload;

		//echo $upload->uploadImg();
		
		return View::make('News.NewsAdd', $this->cVariable);
	}


	public function getNewsUpdate($nid){
		
		$this->cVariable['resultData'] = $this->news->getNewsOne($nid);

		return View::make('News.NewsUpdate', $this->cVariable);
	}

	public function getNewsDelete($nid){
		$action = "news/news-index";
		if(is_numeric($nid)){
			DB::beginTransaction();
				$newsData = DB::table('node')->where('nid', '=', $nid)->get();
				$bool = DB::table('node')->where('nid', '=', $nid)->delete();
				$bool &= DB::table('node_content')->where('nid', '=', $nid)->delete();
			if($bool){
				DB::commit();
				
				$this->log('删除新闻：'.$newsData[0]->title);
			}else{
				DB::rollback();
			}
		}
		return Redirect::to($action);
	}

	/**
	 * 处理添加新闻数据
	 */
	public function postNewsAddData(){
		//xss 过滤
		$xss = new Xss;

		$data_info = array(
			'title' => $xss->clean(Input::get('title')),
			'subTitle' => $xss->clean(Input::get('subTitle')),
			'overview' =>  $xss->clean(Input::get('overview')),
			'readNums' => Input::get('readNums'),
			'sort' => Input::get('sort'),
			'author' => $xss->clean(Input::get('author', 'admin')), //如果为空，默认当前用户
			'uid' => $this->cVariable['userInfo']->id, //当前用户ID,
			'publishedTime'	=> Input::get('publishedTime') ? Input::get('publishedTime') : date('Y-m-d'),
			'isComment' => Input::get('isComment'), //默认开启评论
			'promote' => Input::get('promote'), //默认不推送幻灯片
			'sticky' => Input::get('sticky'),	//默认是新闻头条
			'published' => Input::get('published'), //默认直接发布新闻
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			//'pid' => 0
			
		);
		$action = "news/news-index";
		DB::beginTransaction();

		$insertId = DB::table('node')->insertGetId($data_info);

		$data_content = array(
			'content' =>  Input::get('content'),
			'nid' => $insertId,
			'promoteUrl' => Input::get('promoteUrl'),
			'stickyUrl' => Input::get('stickyUrl')
		);

		//处理tags分类
		// $tags = $xss->clean(Input::get('tags', ""));
		// if($tags){
		//    if(stripos($tags, ' ') !== FALSE){
		//       $tagsArr = explode(' ', $tags);
		//       foreach ($tagsArr as  $value) {
		//       	$tagsData[] = array(
		//       		array(

		// 			)
		//       	);
		//       }
		//    }
		// }

		$insertId &= DB::table('node_content')->insertGetId($data_content);

		if($insertId){
			DB::commit();
			$this->log('添加新闻：'.$data_info['title']);
		}else{
			$action = "news/news-add";
			DB::rollback();
		}

		return Redirect::to($action);
	}

	public function postNewsUpdateData(){
		$xss = new Xss;

		$data_info = array(
			'title' => $xss->clean(Input::get('title')),
			'subTitle' => $xss->clean(Input::get('subTitle')),
			'overview' =>  $xss->clean(Input::get('overview')),
			'readNums' => Input::get('readNums'),
			'sort' => Input::get('sort'),
			'author' => $xss->clean(Input::get('author')), //如果为空，默认当前用户
			'publishedTime'	=> Input::get('publishedTime') ? Input::get('publishedTime') : date('Y-m-d'),
			'isComment' => Input::get('isComment'), //默认开启评论
			'promote' => Input::get('promote'), //默认不推送幻灯片
			'sticky' => Input::get('sticky'),	//默认是新闻头条
			'published' => Input::get('published'), //默认直接发布新闻
			'updated_at' => date('Y-m-d H:i:s'),
			//'pid' => 0
			
		);
		$action = "news/news-index";
		DB::beginTransaction();

		$bool = DB::table('node')
		            ->where('nid', Input::get('nid'))
		            ->update($data_info);
		            //var_dump($bool);
		$data_content = array(
			'content' =>  Input::get('content'),
			'promoteUrl' => Input::get('promoteUrl'),
			'stickyUrl' => Input::get('stickyUrl'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		$bool &= DB::table('node_content')
		            ->where('nid', Input::get('nid'))
		            ->update($data_content);


		// var_dump($bool);
		// exit();

		if($bool){
			DB::commit();
			$this->log('修改新闻：'.$data_info['title']);
		}else{
			$action = "news/news-update/".Input::get('nid');
			DB::rollback();
		}

		return Redirect::to($action);

	}

	public function postNewsDealImg(){
		$typeImg = Input::get('typeImg');

		// $laravel_session  = Input::get('laravel_session');
		// if($laravel_session){
		// 	//echo 'kk';
		// 	Session::setId($laravel_session);
		// 	//echo 'kk';
		// }
		// Session::start();
		$upload = new Upload;
		//var_dump('expression');
		//var_dump($_FILES);
		//var_dump($laravel_session);
		$upload->uploadImg($typeImg);
		exit(0);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
