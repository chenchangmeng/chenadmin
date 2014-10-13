function trim( text ) {
	if (typeof(text) == "string"){
		return text.replace(/^\s*|\s*$/g, "");
	}
	else{
		return text;
	}
}

function isInt(val){
	if (val == ""){
		return false;
	}
	var reg = /\D+/;
	return !reg.test(val);
};

function getEvent(e){
	var evt = (typeof e == "undefined") ? window.event : e;
	return evt;
};

var pagelist = new Object;
pagelist.filter = new Object;
pagelist.mUrl = location.href.lastIndexOf("?") == -1 ? location.href
: location.href.substring(0, location.href.lastIndexOf("?"));
pagelist.mUrl += "?is_ajax=1";

/* 构造请求参数 */
pagelist._bulidFilter = function(objParams){
	if ( objParams == null || typeof objParams != "object" ){
		return null;
	}
	var args = "";
	for (var i in objParams){
		if (typeof objParams[i] != "function" && typeof objParams[i] != "undefined"){
			args += "&" + i + "=" + encodeURIComponent(objParams[i]);
		}
	}
	if (args != ""){
		args = args.substring(1);
	}
	return args;
};

/* 切换排序方式 */
pagelist.sort = function(sort_by, sort_order){
	if (this.filter["sort_by"] == sort_by) {
		this.filter["sort_order"]= ( this.filter["sort_order"] == "DESC" ? "ASC" : "DESC" );
	} else {
		this.filter["sort_by"] = sort_by;
		this.filter["sort_order"] = "DESC";
	}
	this.mUrl = this._bulidUrl("sort_by", sort_by) + "&sort_order=" + sort_order;
	// TODO AJAX
};

/* 载入页面 */
pagelist.loadPage = function(){
	// TODO AJAX
	ajax.post(this.mUrl, this.pageCallback, this._bulidFilter(this.filter));
};

/* 翻页 */
pagelist.toPage = function(page){
	if (page != null){
		page = ( page > this.pageCount ? 1 : page );
		this.filter["page"] = page;
	}
	this.filter["page_size"] = this.getPageSize();
	this.loadPage();
};

/* 首页 */
pagelist.firstPage = function(){
	if (this.filter["page"] > 1) {
		this.toPage(1);
	}
};

/* 末页 */
pagelist.endPage = function(){
	if (this.filter["page"] < this.pageCount) {
		this.toPage(this.pageCount);
	}
};

/* 上一页 */
pagelist.lastPage = function(){
	if (this.filter["page"] > 1) {
		this.toPage(parseInt(this.filter["page"]) - 1);
	}
};

/* 下一页 */
pagelist.nextPage = function(){
	if (this.filter["page"] < this.pageCount) {
		this.toPage(parseInt(this.filter["page"]) + 1);
	}
};

/* 改变页数 */
pagelist.changePage = function(e, frm){
	var evt = getEvent(e);
	if (evt.keyCode != 13){
		return false;
	}

	if (frm) {
		// 禁止提交表单
		frm.onsubmit = function(){
			return false;
		};
	}

	var page = document.getElementById("page");
	if ( ! isInt(page.value) || parseInt(page.value) > this.pageCount ){
		alert("输入页数错误");
		page.value = this.filter["page"];
		return false;
	}
	this.toPage(page.value);
};

/* 改变每页显示数 */
pagelist.changePageSize = function(val){
	this.toPage(1);
};

/* 回调函数 */
pagelist.pageCallback = function(result){
	try {
		alert(result);
	} catch (e) {
		alert(e.message);
	}
};

/* 获取每页记录数 */
pagelist.getPageSize = function(){
	var ps = document.getElementById("pageSize").value;
	if (ps) {
		document.cookie = "static[page_size]=" + ps + ";";
	}else{
		ps = 15;
	}
	return ps;
};