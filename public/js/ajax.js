var ajax = new Ajax();

function Ajax(obj) { 
	// 默认出错处理 
	this._eh = Ajax._error;
};
Ajax.debug_enable = false;

// GET 请求 （URL, 回调函数[, 回调函数附加数据, 是否异步]） 
Ajax.prototype.get = function (url, callback, asyn) {
	var _self = this;
	var xhr = Ajax._createXMLHttpRequest();

	asyn = (typeof asyn == "undefined") ? true: asyn;
	if (asyn){
		xhr.onreadystatechange = function(){ 
			Ajax._callback(xhr, callback, _self); 
		};
	}

	xhr.open('GET', url, asyn);
	xhr.setRequestHeader('If-Modified-Since', '0');
	xhr.setRequestHeader('X_REQUESTED_WITH', 'xmlHttpRequest');

	if (Ajax.debug_enable){
		Ajax._debugger(callback); 
	}
	xhr.send(null); 

	if(asyn){ 
		return xhr; 
	}else{ 
		Ajax._callback(xhr, callback, _self); 
	} 
};

// POST 请求 （URL, 回调函数[, 回调函数附加数据, POST数据, 是否异步]） 
Ajax.prototype.post = function (url, callback, data, asyn) {
	var _self = this;
	var xhr = Ajax._createXMLHttpRequest();

	asyn = (typeof asyn == "undefined") ? true: asyn; 
	if (asyn){
		xhr.onreadystatechange = function(){ 
			Ajax._callback(xhr, callback, _self); 
		};
	}

	xhr.open('POST', url, asyn);
	xhr.setRequestHeader('If-Modified-Since', '0');
	xhr.setRequestHeader('X_REQUESTED_WITH', 'xmlHttpRequest'); 

	if(Ajax.debug_enable){
		Ajax._debugger(callback);
	}

	if ( data )
	{
		//xhr.setRequestHeader('Content-length', data.length); 
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 
	}else{
		data = null;
	}
	xhr.send(data);

	if(asyn){ 
		return xhr; 
	}else{ 
		Ajax._callback(xhr, callback, _self); 
	} 

};

// 设置出错处理函数 
Ajax.prototype.e_handler = function (func) { 
	if(func !== undefined) this._eh = func; 
};

// 创建一个兼容的XHR对象
Ajax._createXMLHttpRequest = function() {
	var xhr = null; 
	if(typeof XMLHttpRequest != 'undefined') { 
		xhr = new XMLHttpRequest(); 
	}else{ 
		var _msxmlhttp = new Array( 
		'Msxml2.XMLHTTP.6.0', 
		'Msxml2.XMLHTTP.3.0', 
		'Msxml2.XMLHTTP', 
		'Microsoft.XMLHTTP'); 
		for(var i = 0; i < _msxmlhttp.length; i++) { 
			try { 
				if (xhr = new ActiveXObject(_msxmlhttp[i])) break; 
			} catch (e) {
				xhr = null;
			} 
		} 
	} 
	if(!xhr)
	{
	alert("Could not create connection object."); 
	} 
	return xhr;
}; 

//– 私有函数 —————————————————————– 

Ajax._callback = function (req, callback, obj) {
	if(req.readyState == 4) {
		if(req.status != 200) {
			if(obj._eh) obj._eh(req, callback); 
		}else{

			// 检查是否有错误
			try {
				var msg = eval('(' + req.responseText + ')');
				if ( typeof msg == 'object' && msg.errCode ) {
					if (msg.message) {
						alert(msg.message);
					}
					if ( msg['location'] ) {
						window.top.location.href = msg['location'];
					}
					return false;
				} else {
					// 响应成功
					callback(req.responseText);
				}
			} catch(e) {
			// 响应成功
			callback(req.responseText);
			}
		} 
	} 
}; 

// Debug: 显示采用的回调函数。 
Ajax._debugger = function (func){ 
	alert('running: ' + Ajax._fname(func)); 
};

// 默认的出错处理 
Ajax._error = function (req, callback){ 
	alert(req.statusText + '\nShould run: ' + Ajax._fname(callback)); 
};

// 提取函数名（含参数） 
Ajax._fname = function (func){ 
	var strFunc = func.toString(); 
	return strFunc.slice(9, strFunc.indexOf(')', 10)) + ')'; 
};