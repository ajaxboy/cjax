//@app_header;

/**
 * $Rev: 1562 $
 * @returns {CJAX_FRAMEWORK}
 */

function CJAX_FRAMEWORK() {
	this.name		=	'cjax';
	this.version	=	'//@version;';
	this.debug = false;
	var CJAX_CACHE = [];
	this.DOMContentLoaded = false;
	this.loaded = [];
	this.handlers = {
		handlerFileupload: function(form, url, funcRequestCallback) {},
		handlerRequestStatus: function(url, request_status) {},
		handlerFormRequest: function(url, serial, args) {},
		handlerConfirm: function(question, callback) {}
	};
	var _FUNCTION;
	var __base__;
	var __root__;
	this.uri; //full uri to cjax.js
	this.f; //full file path to ajax.php.
	this.base; //this file  base path
	this.$plugin; // plugin being loaded
	this.plugins = {};//plugins instances
	this._plugins = {};//access plugins xml settings
	this.pBase; //plugins  base
	this.inits = [];//plugins init code
	this.vars = []; 
	this.waitingFor = {}; //for plugins
	/**
	 * Timeout to preload stuff in milliseconds
	 */
	this.preloadTime = 0;
	this.found_extra_time = 0;
	this.message_id = 0;
	this.commands = {};
	this.callback_success = {};
	this.callback_error = null;
	this.callback_cache = {};
	this.processCallback = null;//execute something after process_all
	this.deferredActions = {};
	this.left_delimeter = "<";
	this.right_delimeter = ">";
	this.split_delimiter = "|";
	this.default_timeout = 3;
	this.messages = [];
	this.is_loading = true;
	this.clicked;
	this.IS_POST = false;
	this.ie;// is IE? -_-
	this.cache_calls = [];
	this.chache_templates = [];
	this.dir;
	this.files = false;
	this.styles = [];
	//collection of elements that are using listeners
	this.current_element = [];
	
	this.timer = 0;
	this.funtion_timer = true;
	
	this.defaultMessages = {
		invalid: 'Invalid Input!',
		success: 'Success!',
		error: 'Error!'
	};
	
	this.ajaxSettings = this.ajaxDefaultSettings = {
		dataType: 'text/html',
		cache : false,
		process: true,
		ajaxVars: {},
		success: function() {},
		complete: function() {},
		error: function() {},
		stop: false,//if true, halts an ajax request and resets to false
	}; 
	//don't change these
	var FLAG_WAIT = 1;
	var FLAG_NO_WAIT = 2;
	var FLAG_TIMEOUT_EXPAND = false;
	
	//holds the internal cjax style
	var HELPER_STYLE;
	
	this.Execfn		=		function(fn,element,data)
	{
		_raw_fn = fn;
		
		switch(fn) {
			case 'replace':
				if(data.b[0]=='#' && !/[^a-zA-Z0-9_]/.test(data.b.replace(/^#/,''))) {
					data.b = data.b.replace(/^\#/,'');
					child = CJAX.$(data.b);
					if(!child) {
						console.log('Element#1', data.b,'could not be found.');
						return;
					}
					element.parentNode.replaceChild(child, element);
				} else {
					data.replace = true;
					return CJAX.Execfn('append', element, data);
				}
			break;
			case 'before':
			case 'prepend':
				if(data.b[0]=='#') {
					data.b = data.b.replace(/^\#/,'');
					child = CJAX.$(data.b);
					if(!child) {
						console.log('Element#1', data.b,'could not be found.');
						return;
					}
					element.parentNode.insertBefore(child, element); 
				} else {
					CJAX.lib.fnCall(element,{prepend: data.b});
				}
			break;
			case 'flush':
				//clear event listerners from an element
				CJAX._EventCache.flushElement(element);
			break;
			case 'insert':
				if(data.b[0]=='#') {
					data.b = data.b.replace(/^\#/,'');
					child = CJAX.$(data.b);
					if(!child) {
						console.log('Element', data.b,'could not be found.');
						return;
					}
					
					if(data.c) {
						if(element.lastChild) {
							element.insertBefore(child,element.lastChild.nextSibling);
						} else {
							element.appendChild(child);
						}
					} else {
						element.insertBefore(child,element.firstChild);
					}
				} else {
					CJAX.lib.fnCall(element,{insert: data.b},data);
				}
			break;
			case 'append':
				if(data.b[0]=='#') {
					data.b = data.b.replace(/^\#/,'');
					child = CJAX.$(data.b);
					if(!child) {
						console.log('Element', data.b,'could not be found.');
						return;
					}
					
					element.parentNode.insertBefore(child,element.nextSibling);
				} else {
					CJAX.lib.fnCall(element,{append: data.b});
				}
			break;
			case 'hide':
				element.style.display = 'none'; 
			break;
			case 'show':
				element.style.display = 'block'; 
			break;
			default:
				CJAX.lib.fnCall(element,{_raw_fn: data.b});
		}
	};
	
	this._fn		=		function(buffer) 
	{
		fn = _raw_fn = CJAX.xml('fn', buffer);
		var prop;
		data = CJAX.util.json(CJAX.decode(CJAX.xml('fn_data', buffer)));

		switch(fn) {
			case 'document':
			if(typeof document[data.a]=='string') {
				data.b = CJAX._pharseValues(data.b);
				return document[data.a] = data.b;
			}
			break;
		}
		
		function _processFn(my_fn, type)
		{
			if(type=='custom') {
				data.a = data.a.replace(/^\#/,'');
				element = CJAX.$(data.a);
				if(!element) {
					console.log('Element',data.a, 'cold not be found in the document.');
					return;
				}
				try {
					return CJAX.Execfn(_raw_fn,element,data);
				}catch (e) {
					alert("Function "+_raw_fn+ " generated an error: "+e);
					return;
				}
			} else if(type=='direct') {
				str = _raw_fn.toLowerCase().replace(/\b([a-z])/gi,function(c){return c.toUpperCase();});
				if(CJAX.handlers['_handler'+str] && CJAX.lib.isFn(CJAX.handlers['_handler'+str])) {
					if(CJAX.handlers['_handler'+str](data.a,data.b,data,buffer)) {
						return true;
					}
				}
				switch(_raw_fn) {
					case 'confirm':
						if(my_fn(data.a)) {
							
							console.log(data.b);
							if(typeof data.b=='function') {
								data.b();
							}
						}
					break;
					case 'submit':
						element = CJAX.$(data.a);
						element.submit();
						break;
					case 'click':
						element = CJAX.$(data.a);
						element.click();
					break;
					break;
					case 'focus':
						element = CJAX.$(data.a);
						element.focus();
					break;
					case 'append':
						if(data.b) {
							child = CJAX.$(data.b);
							if(!child) {
								element = CJAX.$(data.a);
								CJAX.lib.fnCall(element,{append: data.b});
								return;
							}
						}
					case 'appendChild':
						element = CJAX.$(data.a);
						child = CJAX.$(data.b);
						element.appendChild(child);
					break;
					default:
					if(data.f) {
						my_fn(data.b,data.c,data.d,data.e,data.f);
					} else if(data.e) {
						my_fn(data.b,data.c,data.d,data.e);
					} else if(data.d) {
						my_fn(data.b,data.c,data.d);
					} else if(data.c) {
						my_fn(data.b,data.c);
					} else  if(data.b) {
						my_fn(data.b);
					} else  if(data.a) {
						my_fn(data.a);
					} else {
						my_fn();
					}
				}
				return;
			}
			if(typeof my_fn =='object') {
				if(prop) {
					data.a = prop; 
				}
				CJAX.lib.fnCallback(my_fn, data.a, data.b, data.c, data);
			} else {
				if(!data.c) {
					if(data.b){
						if(CJAX.lib.isFN(my_fn)) {
							if(type=='window') {
								window[_raw_fn][data.a](data.b);
							}
						}
					}
				} else {
					if(data.f) {
						my_fn(data.b,data.c,data.d,data.e,data.f);
					} else if(data.e) {
						my_fn(data.b,data.c,data.d,data.e);
					} else if(data.d) {
						my_fn(data.b,data.c,data.d);
					} else if(data.c) {
						my_fn(data.b,data.c);
					} else  if(data.b) {
						my_fn(data.b);
					} else {
						my_fn();
					}
				}
			}
		}
		
		if(data) {
			try {
				for(x in data) {
					data[x] = CJAX.lib.pharseFunction(data[x]);
				}
			} catch(e) {
				console.log("Function Error:",e.message,"in your dynamic $ajax->"+_raw_fn+" function.", "\n\n\n", data[x]);
				alert("Function Error:"+e.message+", in your dynamic $ajax->"+_raw_fn+" function.");
				return;
			}
			
			if(typeof data.a == 'string') {
				parts = data.a.split('.');
				if(CJAX.util.count(parts) > 1) {
					if(window[fn]) {
						fn = window[fn];
						if(fn[parts[0]]) {
							fn = fn[parts[0]];
							if(typeof fn[parts[1]]=='object') {
								fn = fn[parts[1]];
							} else {
								prop = parts[1];
							}
						}
					}
				}
			}
		  
			if(CJAX.ie) {
				if(CJAX.ie[_raw_fn]) {
					
					if(!fn || typeof fn=='string') {
						fn = window[fn];
					}
					return _processFn(fn,'direct');
				}
			}
		
			if(CJAX.lib.isFn(fn)) {
				_processFn(fn,'direct');
			} else if(window[fn]) {
				fn = window[fn];
				if(CJAX.lib.isFn(fn)) {
					return _processFn(fn, 'direct');
				} else {
					return _processFn(fn, 'window');
				}
			} else {
				if(typeof fn=='object') {
					_processFn(fn);
				} else  {
					
					element = CJAX.$(data.a);
					
					if(element) {
						fn = element[fn];
						if(fn) {
							_processFn(fn);
						} else {
							_processFn(fn,'custom');
						}
					} else {
						console.log("Element", data.a, "could not be found.");
					}
				}
			}
		}
	};
	
	this.property  	=		function (buffer)
	{
		var element = CJAX.$(CJAX.xml('element_id',buffer));
		
		if(!element) {
			if(CJAX.debug) {
				
				console.log('Element:', CJAX.xml('element_id',buffer),'was not found');
			}
			return;
		}
		var value = CJAX.xml('value',buffer);
		if(CJAX.util.json(value)) {
			value = CJAX.util.json(value);
		}
		
		if(typeof value =='object') {
			for(x in value) {
				if(typeof value[x] == 'object') {
					for(item in value[x]) {
						element[x][item] = value[x][item];
					}
				} else {
					element[x] = value[x];
				}
			}
		}  else {
			switch ( element.nodeName ) {
				default:
					
					console.log(element);
					element.value = value;
				break;
				case 'IMG':
					element.src = value;
				break;
				case 'A':
					var href = element.href;
					if(/^https?/.test(href)) {
						element.href =  value;
						element.innerHTML =  value;
					} else {
						element.innerHTML =  value;
					}
				break;
				case 'LABEL':
				case 'BUTTON':
				case 'DIV':
				case 'SPAN':
				
					element.innerHTML =  value;
				break;
				case 'INPUT': {
					switch(element.type) {
					//these others TODO
						case 'button':
						case 'radio':
						case 'text':
						case 'select-one':
						case 'textarea':
						case 'hidden':
						case 'password':
							element.value  = value;
						break;
						case 'checkbox':
							element.checked  = parseInt(value)? true: false;
					}
				}
				break;
			}
		}
	};
	
	this.remove		=		function( buffer ) {
		var element = CJAX.is_element(buffer);
		if(element) {
			element.parentNode.removeChild( element );
		}
	};
	
	this.util		=		function()
	{
		return {
				isXML: function(data) {
					if(typeof data !='string') {
						return false;
					}
					if(data.indexOf(CJAX.left_delimeter)!=-1 && data.indexOf(CJAX.right_delimeter)!=-1) {
						return true;
					}
					return false;
				},
				json: function(buffer, tag)
				{
					if(typeof buffer=='object') {
						return buffer;
					} 
					var _parse;
					if(typeof JSON !='undefined' && !CJAX.ie) {
						_parse = JSON.parse;
					}
					if(!tag) {
						var tag = 'json';
					}

					if(buff = CJAX.decode(CJAX.xml(tag,buffer))) {
						try {
							if(_parse) {
								json =  _parse(buff);
							} else {
								json =  eval("("+buff+")");
							}
						} catch(e) {
							if(CJAX.ie) {
								alert(e.message);
							}
							console.log('Json Parser Error:',e);
						}
						
						if(typeof json=='undefined' || !json) {
							return  {};
						}
						if(typeof json !='object') {
							buff = CJAX.decode(CJAX.decode(CJAX.xml(tag,json)));
							if(_parse) {
								json =  _parse(buff);
							} else {
								json =  eval("("+buff+")");
							}
						}
						return json;
					}
				},
				jsonEval: function(buffer)
				{
					try {
						json = eval("("+buffer+")");
					} catch(e) {
						console.log("Could not convert Json Object");
						return;
					};
					if(json) {
						return json;
					}
				},
				/**
				*  input will be something like:
				*  <arr><key>1</key><value>value 1</value><key>2</key><value>value 2</value></arr>
				*  output will be an array
				*/
				array: function(buffer) {
					if(CJAX.xml('json',buffer)) {
						return eval("("+CJAX.decode(CJAX.xml('json',buffer))+")");
					}
					var array = CJAX.xml('arr',buffer,true);
					
					var xml_arr = [];
					for(x in array) {
						xml_arr[x] = array[x];
					}
					
					var k,v;
					var xml_arr = [];
					
					for(x in array) {
						if(CJAX.util.isXML(array[x])) {
							k = CJAX.xml('k',array[x]);
							v = CJAX.xml('v',array[x]);
							xml_arr[k] = v;
						}
					}
					return xml_arr;
				},
				strrpos: function ( haystack, needle, offset) {
					var i = haystack.lastIndexOf( needle, offset );
					return i >= 0 ? i : false;
				},
				encode: function(str) {
					str = escape(str);
					str = str.replace('+', '%2B');
					str = str.replace('%20', '+');
					str = str.replace('*', '%2A');
					str = str.replace('/', '%2F');
					str = str.replace('@', '%40');
					str = str.replace('(', '%28');
					str = str.replace('!', '%21');
					str = str.replace(')', '%29');
					
					return str;
				},
				injectXML:function(buffer,xml) {
					buffer = buffer.replace(/<\/out>/gi,xml+'</out>');
					return buffer;
				},
				replace_encode: function(buffer, unencoded)
				{
					var new_buffer = buffer.replace("<encode>"+unencoded+"</encode>",CJAX.util.encode(unencoded));
					
					return new_buffer;
				},
				eval: function (source) 
				{
					
					var new_data = CJAX.decode(source).replace(/\n\r/ig,"");
					new_data = new_data.replace(/[\n\r\t]/gm,""); 
					new_data = new_data.replace(/\t/gm," "); 
					
					try {
						eval(new_data);
					} catch(e) {
						console.info("Eval could not load: %s", new_data, e);
					}
				},
				count: function(mixed_var,mode){
				var key, cnt = 0; 
				if (mixed_var === null){
					return 0;
				} else if (mixed_var.constructor !== Array && mixed_var.constructor !== Object){
					return 1;	}
			
				if (mode === 'COUNT_RECURSIVE') {
					mode = 1;
				}	if (mode != 1) {
					mode = 0;
				}
			
				for (key in mixed_var){		if (mixed_var.hasOwnProperty(key)) {
						cnt++;
						if ( mode==1 && mixed_var[key] && (mixed_var[key].constructor === Array || mixed_var[key].constructor === Object) ){
							cnt += this.util.count(mixed_var[key], 1);
						}		}
				}
			
				return cnt;			
			},
			get: {
			y: function() {
				var scrOfY = 0;
				if( typeof( window.pageYOffset ) == 'number' ) {
					//Netscape compliant
					scrOfY = window.pageYOffset;
				} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
					//DOM compliant
					scrOfY = document.body.scrollTop;
				} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
					//IE6 standards compliant mode
					scrOfY = document.documentElement.scrollTop;
				}
				return scrOfY;
			},
			extension: function(path) {
				var pos = CJAX.util.strrpos(path,'.');
				if(!pos) {
					return '';
				}
					return CJAX.php.substr(path,pos,path.length);
				},
				byClassName:function(theClass,tag)
				{
					var allHTMLTags = new Array();
					if(tag == null ) {
						var tag = "*";
					}
					var allHTMLTags=document.getElementsByTagName(tag);

					for (i=0; i<allHTMLTags.length; i++) {
						if (allHTMLTags[i].className==theClass) {
							return allHTMLTags[i];
						}
					}
				}
				,
				dirname : function (path,loops) {
					if(typeof loops=='undefined') {
						var loops = 1;
					}
					var self = CJAX.util.get.selfpath();
					if(!self || !path) {
						return false;
					}
					path.match(/(.*)[\/\\]/)[1];
					if( loops ){
						for(var i = 0; i < loops-1; i++){
						try{
							path = path.match( /(.*)[\/\\]/ )[1];
							}
							catch( _e ) {}
						}
					}
					return path;
				},
				document : function(frame) {
					if(CJAX.defined(frame) && frame) {
						var iframeDoc;
						if (this.contentDocument) {
							iframeDoc = this.contentDocument;
						}
						else if (this.contentWindow) {
							iframeDoc = this.contentWindow.document;
						}
						else if (window.frames[this.name]) {
							iframeDoc = window.frames[this.name].document;
						}
						return iframeDoc.document;
					}
					return document.body;
				}
				,basepath : function () {
					if(CJAX.base) {
						return CJAX.base;
					}
					var path = CJAX.util.get.selfpath();
					
					
					path = CJAX.util.get.dirname(path,3);
					if(path) {
						var len = path.substr(path.length - 4);
						if(len=='core') {
						//if cjax is called from a parent-child file
							path = CJAX.util.get.dirname(path,2);
						}
					} else {
						path = 'cjax';
					}
					return CJAX.base = path;
				},
				basename : function(path, suffix) {
					var b = path.replace(/^.*[\/\\]/g, '');
					if (typeof(suffix) == 'string' && b.substr(b.length-suffix.length) == suffix) {
						b = b.substr(0, b.length-suffix.length);
					}
					return b;
				}
				,scripts : {
					src : function () {
							var paths = [];
							var script;
							var scripts = CJAX.elem_docs( 'script' );
							for( var i = 0; i < scripts.length; i++ ){
								script = scripts[i];
								if(script.src) paths[i] = script.src;
							}
							return paths;
						}
				},
				selfpath : function() {
					if(CJAX.vars['selfpath']) {
						return vars['selfpath'];
					}
					var script;
					var name = 'cjax-//@version;.js';
					var src;
					
					script = CJAX.$('cjax_lib');
					
					if(script) {
						src = script.src;
						var f = src.replace(/cjax-.+$/,'');
						
						CJAX.uri = script.src;
					} else {
						var scripts = document.getElementsByTagName('script');
						for( var i = 0; i < scripts.length; i++ ){
							script = scripts[i];
							src = script.src;
							if(CJAX.util.get.basename(src).indexOf('cjax-')!=-1) {
								var f = src.replace(/cjax-.+$/,'');
								CJAX.uri = src;
								return f;
							}
						}
					}
					if(f) {
						return  f;
					}
				
				},
				value : function(elem,verbose) {
					var type = (typeof elem);
					if( typeof verbose == 'undefined') { verbose = true; }
					if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
					return elem.value;
				},
				position : function(obj) {
					var curleft = curtop = 0;
					if (obj.offsetParent) {
						do {
							curleft += obj.offsetLeft;
							curtop += obj.offsetTop;
						} while (obj = obj.offsetParent);
						var r = [];
						r['top'] = curtop;
						r['left'] = curleft;
						return r;
					}
				},
				property : {
					enabled: function(elem,verbose) {
						var type = (typeof elem);
						if( typeof verbose == 'undefined') { verbose = true; }
						if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
						return (elem.disabled)? false : true;
					},
					disabled: function(elem,verbose) {
						var type = (typeof elem);
						if( typeof verbose == 'undefined') { verbose = true; }
						if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
						return elem.disabled;
					},style : function(elem,verbose) {
						var type = (typeof elem);
						if( typeof verbose == 'undefined') { verbose = true; }
						if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
						return elem.style;
					}
					, parent : function(elem,verbose) {
						var type = (typeof elem);
						if( typeof verbose == 'undefined') { verbose = true; }
						if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
						return elem.parentNode;
					}, position : function(elem,verbose) {
						var type = (typeof elem);
						if( typeof verbose == 'undefined') { verbose = true; }
						if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
						var pos = [];
						var  curleft = curtop = curright = curdown = 0;
						if ( elem.offsetParent ) {
							do {
									curleft += elem.offsetLeft;
									curtop += elem.offsetTop;
							} while (elem = elem.offsetParent);		
							pos[0] = curleft;
							pos[4] = curtop;
							return pos;
						}
					}
					},parent : function(elem,type_of) {
						var type = (typeof elem);
						if( typeof verbose == 'undefined') { verbose = true; }
						if( type.indexOf( 'object' ) == -1) {var elem = CJAX.$(elem,verbose);}
						var parent;
						if(CJAX.util.get.isType(elem.parentNode,type_of)) {
							return elem.parentNode;
						} else {
							var giveup = 30;
							var i = 0;
							while(!CJAX.util.get.isType(elem,type_of) && !elem) {
								i++;
								parent = 	elem.parentNode;
								elem = elem.parentNode;
								if(i >= giveup) {
									break;
								}
							}
							return parent;
						}
					},
				isType: function(element,element_type) {
					if(!element)  return false;
					var type = (typeof element);
					if(element_type=='table') {
						if(element.rows.length) {
							return true;
						}
					}
					if( type.indexOf( element_type ) == -1) { return false; }
					return true;
				}
			}
		};
	}();
	
	/**
	* Takes 2 arguments with the API -  a selectbox and the id of another selectbox
	* and loads an array into the second selectbox depending on what is choosen in the first one
	* if there are no records to display, then it will convert the second selectbox into a text input
	* so the user can enter the record instead
	* 
	* @param buffer
	*/
	this.select		=			function( buffer ) {
		var element_id = CJAX.xml('element_id',buffer);
		var element = CJAX.$(element_id); 

		if(!element) {
			alert("CJAX Error -  Element "+ element_id+" not found");
			return;
		}
		
		var allow_input = CJAX.xml('allow_input', buffer);
		var _selected = CJAX.xml('selected', buffer);
		
		var options = CJAX.util.json(CJAX.decode(CJAX.xml('options',buffer)));

		var options_count = CJAX.util.count(options);
		
		if(element.type=='select-one') {
			element.style.display = 'inline';
			if(options_count) {
				element.options.length = 0;
				for ( x in options ) {
					addOption(element,options[x],x);
					if(options_count==x) {
						break;
					}
				}
			} else {
				if(allow_input) {
					make_input(element);
				} else {
					element.style.display = 'none';
				}
			}
			if(_selected!=null) {
				element.value = _selected;
			}
		} else {
			if(element.type=='text') {
				if(CJAX.util.count(options)) {
					var obj = document.createElement('SELECT'); 
					id = element.id;
					name = element.name;
					element.setAttribute('id', '');
					element.setAttribute('name', '');
					obj.className = element.className;
					obj.setAttribute('id', id);
					obj.setAttribute('name', name);
					if(obj) {
						obj.options.length = 0;
					}
					console.log(obj);
					var x = 0;
					for ( var i in options ) { 
						x++;
						addOption(obj,options[i],i);
						if(options_count==x) {
							break;
						}
					}
					replacedNode = element.parentNode.replaceChild(obj, element);
					//element.parentNode.appendChild(obj);
					if(_selected!=null) {
						obj.value = _selected;
					}
				}
				
			} else {
				if(!CJAX.util.count(options)) {
					make_input(element);
				}
			}
		}

		function make_input(element) {
			element_id = element.id;
			name = element.name;
			element.setAttribute('id', '');
			element.setAttribute('name', '');
			var obj = CJAX.create.input(element_id);
			obj.type = 'text';
			obj.name = name;
			obj.className = element.className;
			obj.style.width = element.offsetWidth+'px';
			obj.style.display = '';
			element.parentNode.replaceChild(obj, element);
			obj.id = element_id;

			if(_selected!=null) {
				obj.style.color = '#ACACAC';
				obj.value = _selected;

				obj.onclick = function() {
					if(obj.value ==_selected) {
						obj.value = '';
						obj.style.color = '';
					}
				};
			}
		}
		
		function addOption(selectbox,text,value ) {
			var optn = document.createElement('OPTION'); 
			optn.text = text; 
			optn.value = value;
			selectbox.options.add(optn);
		}

	};
	
	
	this.tag		=		function(tag, value) {
		return '<'+tag+'>'+value+'</'+tag+'>';
	};
	
	this.eval		=			function( buffer )
	{
		CJAX.util.eval(buffer);
	};

	
	this.overLayContent		=		function(content, options) 
	{
		CJAX.getTemplate('overlay.html', function(template) {
			if(!options || typeof options!=='object') {
				options =  {};
			}
			options.template = template;
			options.content = content;
			return CJAX._overLayContent(options);
		});
	};
	
	this.overLay		=		function(url, options) 
	{
		CJAX.getTemplate('overlay.html', function(template) {
			if(!options || typeof options!=='object') {
				options =  {};
			}
			options.template = template;
			options.url = url;
			return CJAX._overLay(options);
		});
	};
	
	this.getTemplate		=		function(template_name, success)
	{
		CJAX.ajaxSettings.cache = true;
		
		CJAX.get(__base__+'core/templates/'+template_name, function(template) {
			if(success) {
				success(template);
			} else {
				return template;
			}
		});
	};
	
	this._overLayContent		=		function( buffer )
	{
		var template;
		var content;
		var callback;
		var top = (CJAX.util.get.y()+100)+'px';
		if(typeof buffer =='object') {
			options = buffer;
			
			template = options.template;
			content = options.content;

		} else {
			var options = CJAX.xml('options',buffer);
			options = CJAX.util.json(options);
			if(!options) {
				options = {top:top};
			}
			
			content = CJAX.decode(CJAX.xml('content',buffer));
			
			template = CJAX.decode(CJAX.xml('template',buffer));
			template = CJAX.decode(template);
			
			callback = CJAX.decode(CJAX.xml('callback',buffer));
		}
		
		if(!content) {
			return CJAX._removeOverLay();
		}
		CJAX.lib.overlayOptions(options);
		
		CJAX.$('cjax_overlay').style.display = 'block';
		message_options = {
			top: options.top,
			message: template,
			message_id:'cjax_message_overlay',
			success: function() {
				CJAX.lib.overlayCallback(content,callback, options);
			}
		};
		for(x in options) {
			message_options[x] = options[x];
		}
		CJAX.message(message_options);
	};
	
	this._overLay		=		function ( buffer )
	{
		var options;
		var url;
		var top = (CJAX.util.get.y()+100)+'px';
		var cache;
		var template;
		if(typeof buffer=='object') {
			options = buffer;
			if(!options || !options.top) {
				options.top = top;
			}
			url = options.url;
			cache = options.cache;
			template = options.template;
		} else {
			buffer = CJAX.decode(buffer);
			url = CJAX.xml('url',buffer);
			cache = CJAX.xml('cache',buffer);
			options = CJAX.xml('options',buffer);
			options = CJAX.util.json(options);
			callback = CJAX.xml('callback',buffer);
			if(!options) {
				options = {};
			} 
			if(!options.top) {
				options.top = top;
			}
			template = CJAX.xml('template',buffer);
		}
		
		if(!url) {
			return CJAX._removeOverLay();
		}
		
		CJAX.lib.overlayOptions(options);
		
		CJAX.$('cjax_overlay').style.display = 'block';
		
		if(options.callback) {
			options.callback = CJAX.lib.pharseFunction(options.callback);
		}
		message_options = {
			top: options.top,
			left: options.left,
			message_id:  'cjax_message_overlay',
			message: template,
			success: function() {

				if(cache) {
					CJAX.ajaxSettings.cache = true;
					CJAX.ajaxSettings.process = false;
				}
				
				CJAX.get(url, function(response) {
					CJAX.lib.overlayCallback(response,callback,options);
				});
			}
		};
		for(x in options) {
			message_options[x] = options[x];
		}
		CJAX.message(message_options);
	};
	
	this._removeOverLay		=		function()
	{
		overlay = CJAX.$('cjax_overlay');
		overlay.style.display = 'none';
		
		CJAX.is_element('cjax_message_overlay').innerHTML='';
		//default class 
		CJAX.$('cjax_overlay').className = 'cjax_overlay';
	};
	
	this.lib	=	function(element) {
		
		return {
			overlayCallback: function(response,callback,options) {
				if(callback) {
					if(CJAX.lib.isFn(callback)) {
						response = callback(response, CJAX.$('cjax_message_overlay'));
						CJAX.html('cjax_overlay_content',response);
					} else {
						CJAX.html('cjax_overlay_content',response);
						
						CJAX.process_all(callback, callback, null,'skip');
					}
				} else {						
					CJAX.html('cjax_overlay_content',response);
				}
				if(options.click_close) {
					CJAX.$('cjax_overlay').onclick = function() {
						CJAX._removeOverLay();
					};
				}
			},
			fnCallback: function(element, prop, getter, callback, data) {
				if(CJAX.lib.isFn(callback)) {
					if(!element[prop]) {
						console.log(element, 'property:', prop, 'is invalid.');
						return;
					}
					element = element[prop](getter);
					if(typeof callback=='function') {
						callback(element);
					}
				} else {
					CJAX.lib.fnCall(element, getter);
				}
			},
			fnCall: function(element, setting) {
				if(CJAX.lib.isFn(element[setting])) {
					element[setting](data.b);
				} else {
					if(typeof setting =='object') {
						for(x in setting) {
							CJAX.lib.fns(element, x, setting[x], setting, data);
						}
					} else {
						element[setting] = callback;
					}
				}
			},
			//used by js lib
			fns: function(element, fn, value, obj, data) {
				switch(fn) {
					case 'prepend':
						element['outerHTML'] = value+element['outerHTML'];
					break;
					case 'append':
						if(data.replace) {
							element['outerHTML'] = value;
						} else {
							element['outerHTML'] = element['outerHTML']+value;
						}
						break;
					case 'insert':
						if(data.c){
							element['innerHTML'] = element['innerHTML']+value;
						} else {
							element['innerHTML'] = value+element['innerHTML'];
						}
					break;
				}
			},
			isFn:  function(fn) {
				if(typeof fn=='function') {
					return true;
				}
				return Object.prototype.toString.call(fn) == '[object Function]';  
			},
			loadCallback: function(element, $callback, caller) {
				if(!element) {
					console.log('Script was not found', caller);
					return ;
				}
				if(element.loaded) {
					$callback();
					return element;
				}
				
				if($callback) {
					if(CJAX.lib.isFn($callback)) {

						element.onreadystatechange = function () {
							if (this.readyState == 'complete' || this.readyState == 'loaded') {
								element.loaded = true;
								return $callback();
							}
						};
						
						if(element.addEventListener) {
							element.addEventListener( 'load', function() {
								 element.loaded = true;
								 return $callback();
							}, false );
						} else {
							 element.onload = function(){
								 element.loaded = true;
								 return $callback();
							};
						}
						
						
						giveup = function(time) {
							setTimeout(function() {
								if(!element.loaded) {
									if(CJAX.debug) {
										console.log('Forcing loadCallback', caller,'to complete.');
									}
									element.loaded = true;
									return $callback();
								}
							},time);
						};
						setTimeout(function() {
							if(!element.loaded) {
								giveup(300);
							}
						},120);
						
						/*
						giveup = function(time) {
							var interval_count = 0;
							interval = setInterval(function() {
								interval_count++;
								if(element.loaded) {
									clearInterval(interval);
									return true;
								} else if(interval_count > 10) {
									clearInterval(interval);
									if(CJAX.debug) {
										console.log('Forcing loadCallback', caller,'to complete.');
									}
									element.loaded = true;
									return $callback();
								}
							},time);
						};
						setTimeout(function() {
							if(!element.loaded) {
								giveup(100);
							}
						},300);*/
						
					}
				}
				return element;
			},
			pharseFunction: function(buffer) {
				if(typeof buffer == 'object') {
					return buffer;
				}
				if(typeof buffer=='string' && buffer.substr(0,'function('.length)=='function(') {
					try {
						fn = eval('('+buffer+')');
					} catch(e) {
						console.log('Function Error:\n',e, '\n\n', buffer);
					}
					if(CJAX.lib.isFn(fn)) {
						return fn;
					}
				}
				return buffer;
			},
			overlayOptions: function(options) {
				
				if(options.transparent || options.color) {
					var _opacity =_alpha =_color = null;
					if(!options.transparent) {
						options.transparent = 80;
					}
					_opacity = parseFloat("0."+parseFloat(options.transparent));
					_alpha = 'alpha(opacity='+parseInt(options.transparent)+')';
					_color = options.color;
					
					var overlay_class = CJAX.css.add('.overlay_class','cjax');
					if(overlay_class) {
						with (overlay_class.style) {
							display = 'block';
							position = 'absolute';
							top = 0;
							left= 0;
							width= '100%';
							height = '150%';
							Zindex = 5000;
							marginBottom = '0px';
							if(options.transparent) {
								opacity = _opacity;
								filter = _alpha;
							}
							if(_color) {
								backgroundColor =_color;
							}
						}
						CJAX.$('cjax_overlay').className = 'overlay_class';
					}
				}
			}
		};
	}();
	
	this.html			=		function(element, html)
	{
		CJAX.update(element, html);
	};
	
	this.AddEventTo	=	function( buffer ) 
	{
		var temp_buffer = CJAX.decode(buffer);

		uid = CJAX._uniqid(temp_buffer);
		
		var element = CJAX.xml('element_id',temp_buffer);
		
		//binding elements
		if(element.indexOf(CJAX.split_delimiter)!=-1) {
			var bind = element.split(CJAX.split_delimiter);
			var elem,rel,xml;
			var new_buffer;
			var len =CJAX.util.count(bind);
			var i = 0;
			for(x in bind) {
				if(i>= len)break;
				i++;
				new_buffer = buffer.replace(element, bind[x]);
				elem = CJAX.is_element(bind[x],false);
				CJAX.AddEventTo(new_buffer,false);
			}
			return;
		}
		var events = CJAX.util.json(CJAX.xml('events', buffer));
		var event = CJAX.xml('event', buffer);
		
		for(x in events) {
			buffer = events[x];
			CJAX.set.event(element, buffer.event? buffer.event: event, buffer.xml, x);
		}
	};
	
	this.is_cjax		=		function(buffer) {
		if(typeof buffer !='string') {
			return;
		}
		if( !CJAX.xml(this.name,(CJAX.defined(buffer)?buffer:null)) ){ return false; }
		return true;
	};
	
	this.resetDelimeters		=		function(left,right)
	{
		if(CJAX.defined(left) && CJAX.defined(right)) {
			CJAX.left_delimeter = left;
			CJAX.right_delimeter = right;	
		}	else {
			CJAX.left_delimeter = "<";
			CJAX.right_delimeter = ">";
		}
	};
	
	this.get_function		=		function(buffer) {
		return CJAX.xml( 'do' ,buffer);
	};
	
	this._addEvent		=		function( obj, type, fn, cache_id) 
	{
		if(typeof cache_id =='undefined') {
			cache_id = new Date().getTime();
		}
		
		if(!CJAX.defined(id)) {
			var id = null;
		}
		if(type.substring(0, 2) == "on"){
			type = type.substring(2);
		}
		if (obj.addEventListener) {
			if(type=='load'){
				if(CJAX.DOMContentLoaded || typeof window['DOMContentLoaded'] !='undefined') {
					if(CJAX.debug) {
						console.info('DOMContentLoaded is loaded');
					}
					fn();
					return  CJAX._EventCache.add(obj, type, fn);
				} else {
					var listener = function(e)
					{
						document.removeEventListener("DOMContentLoaded", listener, false);
						 if(CJAX.debug) {
					    	console.info('DOMContentLoaded is loaded');
					    }
					    fn();
					   
					    CJAX.DOMContentLoaded = true;
					};
					document.addEventListener("DOMContentLoaded", listener, false);
					if(!CJAX.DOMContentLoaded && typeof window['DOMContentLoaded']=='undefined') {
						try {
							obj.addEventListener( 'load', fn, false );
						} catch(e) {
							alert("CJAX: Error - addEvent "+e );
						}
					}
				}
				return  CJAX._EventCache.add(obj, type, fn);
			}
			try {
					obj.addEventListener( type, fn, false );
				}
				catch( _e ){alert("CJAX: Error - addEvent "+_e );}
			return CJAX._EventCache.add(obj, type, fn);
		} else if (obj.attachEvent) {
			obj["e"+type+fn+cache_id] = fn;
			obj[type+fn+cache_id] = function() { obj["e"+type+fn+cache_id]( window.event ); };
			obj.attachEvent("on"+type, obj[type+fn+cache_id]);
			CJAX._EventCache.add(obj, type, fn);
		} else {
			obj["on"+type] = obj["e"+type+fn+cache_id];
		}
	};
	
	var listEvents = [];
	this._EventCache		=		function(){
		return {
			listEvents : listEvents,
			add : function(node, sEventName, fHandler){
				return listEvents.push( arguments );
			},
			flushElement: function(element) {
				for(i = listEvents.length - 1; i >= 0; i = i - 1){
					item = listEvents[i];
					if(item[0].removeEventListener){
						if(item[0]==element) {
							item[0].removeEventListener(item[1], item[2], item[3]);
						}
					};
					if(item[1].substring(0, 2) != "on"){
						item[1] = "on" + item[1];
					};
					if(item[0].detachEvent){
						if(item[0]==element) {
							item[0].detachEvent(item[1], item[0][eventtype+item[2]]);
						}
					};
					item[0][item[1]] = null;
				};
			},
			flush : function( event_id ){
				if(typeof event_id =='undefined') var event_id;
				var i, item;
				for(i = listEvents.length - 1; i >= 0; i = i - 1){
					item = listEvents[i];
					if(item[0].removeEventListener){
						item[0].removeEventListener(item[1], item[2], item[3]);
					};
					if(item[1].substring(0, 2) != "on"){
						item[1] = "on" + item[1];
					};
					if(item[0].detachEvent){
						//item[0].detachEvent(item[1], item[2]);
						item[0].detachEvent(item[1], item[0][eventtype+item[2]]);
					};
					item[0][item[1]] = null;
				};
			}
		};
	}();
	
	this.tagExists 		=		function(tag, buffer) {
		if(!CJAX.xml(tag, buffer)) {
			return '';
		}
	};
	
	this._uniqid		=		function(buffer)
	{
		return CJAX.xml('uniqid', buffer);
	};
	
	/**
	* Util Set
	*/
	this.set				=			function() {
		return {
			title: function(title) {
				document.title = title;
			},
			event: function(element,_event,method,cache_id){
				var use_fns = false;
				if(typeof element=='string') {
					if(element.indexOf(':') !=-1) {
						use_fns = true;
						fns = element.split(':');
						element = fns[0];
						element = CJAX.$(element);
					} else {
						element = CJAX.$(element);
					}
				}
				
				if(CJAX.debug) {
					console.log("set.even  for -..:",element);
				}
				
				if( !element ) return false;
				var element = CJAX.is_element( element );
				
				var f = method.toString();
				f = f.substr(0,f.indexOf('('));
				f = f.replace(/\s+$/,"");
				
				if(f =='function' ||CJAX.lib.isFn(method)) {
					if(typeof method=='function') {
						return CJAX._addEvent(element ,_event , method, cache_id);
					} else {
						return CJAX._addEvent(element ,_event ,eval(method), cache_id);
					}
				}
				
				var href;
				if(href = element.href) {
					if(href.indexOf('#')==-1) {//avoid removing internal anchor
						//removes all clickable events
						element.onclick = function() {return false;};
					} else {
						element.href= 'javascript:void(0)';
					}
				} else {
					if(element.tagName=='IMG') {
						element.style.cursor = 'pointer';
					}
					if(element.type && (element.type == 'checkbox' || element.type=='radio')) {
						element.onclick = function() {return true;};
					} else {
						if(element.tagName=='LI') {
							//for now do nothing...
							element.onclick = function() {return false;};
						}  else {
							element.onclick = function() {return false;};
						}
					}
				}

				var _x = [];
				if(!cache_id) {
					cache_id = new Date().getTime();
				}
				
				var _stop = false;
				if(use_fns) {
					for(var i = 1; i < fns.length; i++) {
						pub_fn = CJAX.lib.pharseFunction(fns[i]);
						x_fn = function() {
							props = {
								exec: function(element) {
									return pub_fn(element);
								},
								stop: function() {
									_stop = true;
								},
								start: function() {
									_stop = false;
								}
							}
							return props;
						};
						fn_object = new x_fn();
						
						if(CJAX.lib.isFn(pub_fn) || CJAX.lib.isFn(pub_fn  = window[fns[i]])) {
							switch(element.type) {
								default:
								case 'text':
								fn_object.exec(element);
								break;
							}
						}
					}
				}
				
				if(plugin_name = CJAX.xml('is_plugin',method)) {
					if(init = CJAX.inits[plugin_name]) {
						plugin_fn = CJAX.lib.pharseFunction(init);
						plugin_fn();
					}
					_fn = function() {
						if(!_stop) {
							CJAX._extendPlugin(plugin_name, method, 
							{
								element: element,
								event: _event,
								element_id: element.id,
								clear: function() {
									CJAX._EventCache.flushElement(element);
								}
							});
						} else {
							_stop = false;
						}
					};
				} else {
				
					_fn = function(data) {
						_method = data.replace(/\n/g,"");
						
						if(!_stop) {
							if(CJAX.util.isXML(_method)) {
								if(!CJAX.is_cjax(_method)) {
									_method = "<cjax>"+_method+"</cjax>";
								}
								CJAX._process(_method,'set.event',element);
							} else {
								eval(_method);
							}
						} else {
							_stop = false;
						}
					};
				}

				if(_event=='onkeypress') {
					var key = CJAX.util.json(CJAX.xml('key', method));
					if(key) {
						element.onkeypress = function(e) {
							if(e.keyCode) {
								element.keyCode = e.keyCode;
							} else {
								element.keyCode = e.charCode;
							}
						};
						new_fn = function(data) {
							if(key[element.keyCode]) {
								_fn(data);
							}
						};
					} else {
						new_fn = _fn;
					}
				} else {
					new_fn = _fn;
				}
				_x[cache_id] = method;
				
				return CJAX._addEvent(element, _event, function() {new_fn(_x[cache_id]);}, cache_id);
			}
			,type: function(elem,new_type,verbose){
				if( !elem ) return false;
				var elem = CJAX.is_element(elem,verbose);
				if( elem ) { elem.type = new_type; return true;}
				return false;
			}, 'class': function(element,_class){
				element = CJAX.is_element(element,false);
				if(element) {
					element.className = _class;
				}
			}
			,center : function(obj,options) {
				if(typeof options == 'undefined') var options = {};
				var element = CJAX.is_element(obj);
				
				if(options.width) {
					prefix = parseInt(options.width);
					suffix = options.width.match(/(\%|px|em|pt|in|cm|mm|ex|pc)/)[0];
					if(!suffix) {
						options.width = prefix+'px';
					}
					switch(suffix)
					{ 
					case '%':
						if(prefix > 100) {
							prefix = 100;
						}
						options.marginLeft = '-'+(prefix / 2)+'%';		
						if(!options.left) {
							options.left = '50%';
						} else {
							options.marginLeft = 1;		
						}
					break;
					case 'px':
						if(!options.left) {
							options.left = '50%';
							options.marginLeft = '-'+(prefix/ 2)+'px';
						} else {
							options.marginLeft = 1;
						}
					}
				} else {
					if(options.left) {
						prefix = parseInt(options.left);
						suffix = options.left.match(/(\%|px|em|pt|in|cm|mm|ex|pc)/)[0];
						if(!suffix) {
							options.left = prefix+'px';
						}
						switch(suffix)
						{
						case '%':
							options.position = 'relative';
							
							options.marginLeft = '-'+(prefix )+'%';
							
							break;
						case 'px':
							options.marginLeft = 1;
						}
					}
				}
				
				element.style.position ='absolute';
				var ctop = (screen.height /4);
				if(CJAX.defined(options.top) && options.top) {
					var _top = options.top;
					if(CJAX.php.isNumeric(_top)) {
						_top = _top+'px';
					}
				} else {
					var  _top = CJAX.util.get.y()+ctop+'px';
				}
				if(CJAX.defined(options.left) && options.left) {
					var _left = options.left;
					if(options.marginLeft) {
						var _margin_left = options.marginLeft;
					} else {
						var _margin_left = '';
					}
				} else {
					var  _left = '50%';
					var _margin_left = '-'+((element.offsetWidth / 2))+'px';
				}
				if(options.marginLeft) {
					_margin_left = options.marginLeft;
				}
				with (element.style) {
					top = _top;
					left = _left;
					maxWidth = '800px';
				}
				
				if(options.width) {
					with(element.style) {
						maxWidth = options.width;
						width = options.width;
					}
				}
				if(_margin_left && _margin_left !='0px') {
					element.style.marginLeft = _margin_left;
				}
			return element;
			}
		};
	}();
	
	/**
	* util Create
	*/
	this.create		=		function() {
		return{
			input:function(id) {
				var element = CJAX.is_element(id,false);
				if(element) {
					return element;
				}
				element = document.createElement('INPUT');
				element.id = id;
				element.name = id;
				return element;
			},
			div:function(id,parent,append) {
				if(typeof append == 'undefined') var append = true;
				var element = CJAX.is_element(id,false);
				if(!parent || parent == 'body') {
					parent = CJAX.elem_docs( 'body' )[0];
				} else {
					if( !parent ) parent = CJAX.is_element(parent,false);
				}
				if( !parent )return false;
				if(element && parent){	
					if( append ) {
						parent.appendChild( element );
					} else {
						CJAX.elem_docs( 'body' )[0].appendChild( element );
					}
					return element;
				}
				var div = document.createElement( 'div' );
				div.setAttribute('id',id);
				
				if( append ) { 
					parent.appendChild( div );
				} else {
					CJAX.elem_docs( 'body' )[0].appendChild( div );
				}
				return div;
			},
			select: function(id,parent) {
				var select;
				if(select = CJAX.is_element(id)) {
					return select;
				}
				select = document.createElement('select');
				select.name = id;
				select.id = id;
				
				return select;	
			},
			span:function(id,parent) {
				var element = CJAX.is_element( id );
				if(!parent || parent == 'body') parent = CJAX.elem_docs( 'body' );
				else parent = CJAX.is_element(parent,false);
				if( !parent )return false;
				if(element && parent)
				{
					parent.appendChild( element );
					return element;
				}
				var div = document.createElement( 'span' );
				div.setAttribute('id',id);
				parent.appendChild( div );
				return div;
			},
			frame:function(id,parent,src) {
				if(!id) {
					var id = 'cjax_iframe';
				}
				var f = CJAX.$(id,false);
				if(!f) {
					if(CJAX.ie) {
						f = document.createElement('<iframe name="'+id+'"/>');
					} else {
						f = document.createElement("IFRAME");
					}
					f.setAttribute("id",id);
					f.setAttribute("name",id);
					if(typeof src !='undefined' && src) {
						f.setAttribute("src",src);
					}
					if(typeof parent !='undefined' && parent) {
					CJAX.$(parent).appendChild(f);
					}
				}
				return f;
			}
		};
	}();
	
	/**
	* Util php..  mimics php functions
	*/
	this.php		=		function()
	{
		return {
			isNumeric: function(n) {
				var n2 = n;
				n = parseFloat(n);
				return (n!='NaN' && n2==n);
			},
			/*
			* checks to see if specific data is an array
			*/
			is_array: function( element ) {
				if(CJAX.util.isXML(element) && CJAX.xml('json', element)) {
					return true;
				} else {
					return typeof(element)=='object'&&(element instanceof Array);
				}
			},
			in_array: function ( subject , array ) {
				//var len = array.length;
				for (x in array) {
					if (x == subject ){ return true;}
				}
				return false;
			},
			trim: function( data ) {
				if ( !data ) return;
				while (data[0] == ' ' || data[0] == '\n') data = data.substr( 1 ); var l = data.length-1;
				while (l > 0 && data[l] == ' ' || data[l] == '\n') l--;
				return this.substring(0, l+1);
			},
			rtrim: function(str,replace) {
				if(!replace) {
					var replace = " ";
				}
				return  str.replace(/\s+$/,"");
			},
			ltrim: function(string,replace) {
			if(!replace) {
				var replace = " ";
			}
			return string.replace(/replace/ig,string);
			},
			substr: function( f_string, f_start, f_length ) {
				if(f_start < 0) {
					f_start += f_string.length;
				}
			
				if(f_length == undefined) {
					f_length = f_string.length;
				} else if(f_length < 0){
					f_length += f_string.length;
				} else {
					f_length += f_start;
				}
			
				if(f_length < f_start) {
					f_length = f_start;
				}
				return f_string.substring(f_start, f_length);
			}
		};
		
	}();
	
	this.defined		=		function(obj) {
		return (typeof obj!='undefined')? true:false;
	};
	
	/**
	* Util script
	*/
	this.script		=		function() {
		return {
			loaded : function ( path ,force) {
				if(!CJAX.defined(path)) {
					return false;
				}
				//Loaded by CJAX
				if(!CJAX.defined(force)) {
					return (path.loaded())? true:false;
				} 
				//Loaded on the document
				var scripts = CJAX.elem_docs( 'script' );
				var s;
				if(scripts.length){
					for(var i = 0; i < scripts.length; i++ ){
						s = scripts[i];
						if(s.src==path) return s;
					}
				}
				return false;
				
			},
			load: function(script, $callback, waitfor) {
				var f = script.replace(/.*\//,'');
				if(CJAX.defined(CJAX.vars['loaded'][script])) {
					if(CJAX.debug) {
						console.log('Already loaded:',script );
					}
					s = CJAX.vars['loaded'][script];
					
					if($callback && !waitfor) {
						CJAX.lib.loadCallback(s , $callback,f);
					}
					return true;
				}
				
				var head = CJAX.elem_docs( 'head' )[0];
				var file_ext = CJAX.util.get.extension(script);
				if(file_ext=='.css') {
					var s = document.createElement("link");
					s.setAttribute("rel", "stylesheet");
					s.setAttribute("type", "text/css");
					s.setAttribute("href", script);
				} else {
					var s = document.createElement( 'script' );
					s.type = 'text/javascript';
					s.src= script;
				}
				head.appendChild( s );
				CJAX.loaded[f] = s;
				CJAX.vars['loaded'][script] = s;
				
				if($callback && !waitfor) {
					CJAX.lib.loadCallback(s , $callback,f);
				}
				
				if(waitfor) {
					if(CJAX.loaded[waitfor]) {
						CJAX.lib.loadCallback(CJAX.loaded[waitfor] , function() {
							CJAX.lib.loadCallback(s , function() {
								$callback();
							},f);
						},waitfor);
					} else{
						CJAX.waitingFor[waitfor] = $callback;						
					}
				} else {
					if(CJAX.waitingFor[f]) {
						if(CJAX.debug) {
							console.log('waiting for ',f,'to load to fire pending task.');
						}
					
						CJAX.lib.loadCallback(s , CJAX.waitingFor[f], f);
					}
				}
				return s;
			},
			reload: function(script,id) {
				var file_ext = CJAX.util.get.extension(script);
				if(file_ext=='.css') {
					var s = document.createElement("link");
					s.setAttribute("rel", "stylesheet");
					s.setAttribute("type", "text/css");
					s.setAttribute("href", script);
				} else {
					var s = document.createElement( 'script' );
					s.type = 'text/javascript';
					s.src= script;
					s.id= id;
				}
				var head = CJAX.elem_docs('body')[0];
				head.appendChild( s );
				return s;
			}
		};
	}();
	
	/**
	* Process all commands
	*/
	this.process_all		=		function ( actions, preload, debug, is_loading) 
	{
		var raw_actions = actions;
		actions = CJAX.util.json(actions);
		preload = CJAX.util.json(preload);
		
		var plugin_buffer;
		var waitfor;
		
		if (!CJAX.is_cjax(actions) && typeof actions != 'object'){ return; }
		
		if(!CJAX.is_loading) {
			if(!preload) {
				preload = CJAX.util.json(CJAX.xml('preload', raw_actions));
			}
		}
		if(is_loading!='skip') {	
			this.commands =  actions;
		}
		if(!is_loading) CJAX.is_loading = false;
		if(caller==null) var caller = 'unkonwn';
		if(debug!=null) {
			CJAX.debug = debug;
		}
		if(CJAX.debug) {
			console.log('initiating process_all', 'initiated by:',caller);
		}
		
		var found = 0;
		var default_load_timeout = 50;
		var buff;
		
		//CJAX._plugins = {};
		
		//preload
		if(preload) {
			
			for(_id in preload) {
				buffer = preload[_id];
				method = CJAX.xml('do',buffer);
				if(CJAX.debug) {
					console.info("Preloading", method);
				}
				
				switch(method) {
					case '_import':
					found++;
					if(time = CJAX.xml('time', buffer)) {
						CJAX.found_extra_time += parseInt(time);
					} else {
						CJAX.found_extra_time += default_load_timeout;
					}
					
					CJAX._process(buffer,'process_all for '+method, method+' '+_id);
					break;
					case '_imports':
						files = CJAX.xml('files',buffer);
				
						CJAX._import(files+CJAX.tag('plugin_dir',CJAX.xml('plugin_dir', buffer)) , true);
						
					break;
					default:
					if(CJAX.xml('is_plugin', buffer) ) {
						plugin_buffer = buffer;
						plugin_method = CJAX.xml('do',plugin_buffer);
						if(CJAX.debug) {
							console.log('Preloading Plugin:', method);
						}
						file = CJAX.xml('file', buffer);
						file = CJAX.pBase+file;
						
						CJAX._plugins[plugin_method] = plugin_buffer;
						
						init = CJAX.xml('init', plugin_buffer);
						
						if(init) {
							CJAX.inits[plugin_method] = init;
						}
						waitfor = CJAX.xml('waitfor', plugin_buffer);
						
						if(waitfor){
							//add a little extra time for handlers
							CJAX.found_extra_time += 250;
							_import = CJAX.importPlugin(file, function() {
								if(CJAX.debug) {
									console.log('_import waitfor:',plugin_method, window[plugin_method]);
								}
								CJAX.processPlugin(plugin_buffer);
							}, waitfor);
						} else {

							if(buff = CJAX.xml('onwait', plugin_buffer)) {
								_import = CJAX.importPlugin(file , function() {
									CJAX.process_all(buff);
								});
							} else {
								CJAX.importPlugin(file, function() {
									if(CJAX.lib.isFn(window[plugin_method])) {
										
										//console.log(plugin_method,window[plugin_method], plugin_buffer);
									}
								});
							}
							
						}
					}
				}
			}
			found  = found*default_load_timeout;
			if(found > 400) {
				found = 400;
			}
			
			if(parseInt(CJAX.found_extra_time)) {
				found += parseInt(CJAX.found_extra_time);
			}
			CJAX.preloadTime += found;
		}

		var method;
		var _wait;
		var waitFor;
		excfun =  function() {
			for(_id in actions) {
				buffer = actions[_id];
				method = CJAX.xml('do', buffer);
				
				if(method=='_import' || method=='_imports') {
					//already imported.
					continue;
				}
				
				if(CJAX.debug) {
					console.log('#',_id,'process_all in loading mode','calling:',method);
				}
				
				if(CJAX.xml('is_plugin', buffer)) {
					plugin_buffer = buffer;
					plugin_method = CJAX.xml('do', plugin_buffer);
					
					if(CJAX.debug) {
						console.info('Processing Plugin', plugin_method);
					}
					CJAX._extendPlugin(plugin_method, plugin_buffer);
					continue;
				} else {
					if(id = CJAX.xml('waitFor', buffer)) {
						
						if(cmd = CJAX.commands[id]) {
							f = CJAX.xml('file',cmd).replace(/.*\//,'');
							if(!CJAX.loaded[f]) {
								CJAX.waitingFor[CJAX.xml('file',cmd).replace(/.*\//,'')] = function() {
									CJAX.process(buffer,'process_all for '+method, method+' '+_id);
								};
								continue;
							}
						}
					}
				}
				CJAX.process(buffer,'process_all for '+method, method+' '+_id); 
			}
		};
		
		_processFuncs = function(){
			if(CJAX.preloadTime) {
				if(CJAX.debug) {
					console.log('Loading Functions','time wait:', CJAX.preloadTime);
				}
				
				setTimeout('excfun()',CJAX.preloadTime);
			} else {
				excfun();
			}
			if(CJAX.processCallback) {
				CJAX.processCallback();
				CJAX.processCallback = null;
			}
		};
	
		if(CJAX.is_loading) {
			if(CJAX.ie) {
				setTimeout('_processFuncs()',500);
			} else {
				CJAX.ready(function() { //ie doesn't like this
				
					_processFuncs();
				});
			}
		} else {
			if(CJAX.found_extra_time) {
				setTimeout('_processFuncs()',CJAX.found_extra_time);
			} else {
				_processFuncs();				
			}
		}
		CJAX.is_loading = false;
		CJAX.timer = 0;
	};
	
	this._extendPlugin		=		function(plugin_name, plugin_buffer, settings)
	{
		if(waitfor = CJAX.xml('waitfor', plugin_buffer)) {
			if(CJAX.debug) {
				console.info(plugin_name, 'waiting for', waitfor);
			}
			//using waitfor method. see above this loop
			return true;
		}
		if(CJAX.debug) {
			console.log('Loading:', CJAX.xml('is_plugin', plugin_buffer));
		}
		file = CJAX.xml('file', plugin_buffer);
		file = CJAX.pBase+'/'+file;
		f = CJAX.xml('filename', plugin_buffer);
		
		_p = window[plugin_name];

		callbacks = CJAX.xml('callback', plugin_buffer);
		
		if(CJAX.debug && callbacks) {
			console.info('Plugin Buffer',plugin_buffer);
			console.info("Callbacks found for", plugin_name, callbacks);
		}
		if(_p) {
			if(plugin = CJAX.plugins[plugin_name] || CJAX.lib.isFn(_p)) {
				if(CJAX.lib.isFn(plugin)) {
					plugin = CJAX.extend(plugin, plugin_name, plugin_buffer,callbacks, settings);
					
				} else if(CJAX.lib.isFn(_p)) {
					plugin = CJAX.extend(_p, plugin_name, plugin_buffer,callbacks, settings);
					
				} else {
					params = _p.params;
					_p.fn(params['a'],params['b'],params['c'],params['d'],params['e'],params['f']);
				}
			}
		} else {
			CJAX.lib.loadCallback(CJAX.loaded[f], function(){
				
				if(CJAX.lib.isFn(window[plugin_name])) {
					
					plugin = CJAX.extend(window[plugin_name], plugin_name, plugin_buffer, callbacks, settings);
				} else {
					console.log('option ??');
				}
			},null, plugin_name);
		}
	};

	this._import		=		function(buffer, loop)
	{
		var file = CJAX.xml('file',buffer);
		
		if(!file) {
			console.info('no file',buffer);
			return;
		}
		
		if(/^https?/.test(file)) {
			f = CJAX.script.load(file);
		} else {
			if(dir = CJAX.xml('plugin_dir',buffer)) {
				file = CJAX.pBase+dir+'/'+file;
				f  = CJAX.script.load(file);
			} else {
				f  = CJAX.script.load(file);				
			}
			
		}
		if(CJAX.debug) {
			console.log('Imported File:', file);
		}
		CJAX.lib.loadCallback(f, function() {
			f.loaded = true;
		});
		if(loop) {
			new_buffer = CJAX.remove1Tag('file',buffer);
			exists = CJAX.xml('file',new_buffer);
			if(exists) {
				CJAX.lib.loadCallback(f, function() {
					return CJAX._import(new_buffer);
				});
			}
		}
		return f;
	};
	
	this.extend			=	function(plugin_fn, plugin_name, buffer, callbacks, settings)
	{
		if(plugin = CJAX.plugins[plugin_name]) {
			params = plugin.params;
			plugin.fn(params['a'],params['b'],params['c'],params['d'],params['e'],params['f']);
			return plugin;
		}
		var plugins_dir = __base__+'plugins/';
		var path = plugins_dir+file;
		var extra = {};
		var file;
		
		var params = {};
		if(buffer) {
			file = CJAX.xml('file',buffer);
			
			if(_extra = CJAX.decode(CJAX.xml('extra',buffer))) {
				 extra = _extra;
			}
			var data = CJAX.decode(CJAX.xml('data',buffer));
			data = CJAX.util.json(data);
			
			for(x in data) {
				if('object' == typeof data[x]) {
					for(i in data[x]) {
						data[x][i] = CJAX.lib.pharseFunction(data[x][i]);
					}
				} else {
					data[x] = CJAX.lib.pharseFunction(data[x]);
				}
			}
			params = data;
		}
		var uniqid  = CJAX._uniqid(buffer);
		CJAX.$plugin = uniqid;
		if(CJAX.lib.isFn(plugin_fn)) {
			fn = plugin_fn;
		} else {
			fn = window[plugin_name];
		}
		 if(file.indexOf('/')!=-1) {
			base = plugins_dir+file.replace(/\/.+$/,'/');
			//fn.file = file.replace(/.+\//,'');
		 } else {
			//fn.file = file;
			base = plugins_dir;
		 }

		 var cb = function() {
 			if(CJAX.debug) {
 				console.log('cb:', callbacks);
 			}
 			callbacks = CJAX.util.json(callbacks);
 			
			for(event in callbacks) {
				buffer = callbacks[event];
				method = CJAX.xml('do', buffer);

				if(CJAX.debug) {
					console.info(method+':','Executing function - ', method);
				}
				if(method=='AddEventTo') {
					var events = CJAX.util.json(CJAX.xml('events', buffer));
					
					for(x in events) {
						event_buffer = events[x];
						CJAX._process(event_buffer.xml);
					}
				} else {
					CJAX._process(buffer);
				}
 			}
		 };

		 _plugin	=	function(buffer) {
			 func = {
				error: CJAX.error,
				success: function(message,seconds) {
					CJAX.success(message,seconds);
				},
				params : params,
				buffer: buffer,
				warning : CJAX.warning,
				info : CJAX.info,
				message : CJAX.message,
				loading : CJAX.loading,
			 	trigger:CJAX.trigger,
			 	call : CJAX.call,
			 	controllers: 'controllers',
			 	post: CJAX.post,
			 	overLay: function(url, options) {
			 		if(!options) {
			 			options = {};
			 		}
			 		if(options.remote) {
			 			CJAX.post(CJAX.f+'?_crossdomain/overlay','a='+escape(escape(url)), function(response) {
			 			
				 			return CJAX.overLayContent(response, options);
			 			});
			 		} else {
				 		if(/^https?/.test(url)) {
							return CJAX.overLay(url, options);
						} else {
							console.log("overLay",'requires a full URL.');
						}
			 		}
			 	},
			 	get:CJAX.get,
			 	overLayContent: CJAX.overLayContent,
			 	base : base,
			 	$: CJAX.is_element,
			 	handler: function(handler, callback) {
			 		if(CJAX.debug) {
			 			console.log('Setting Handler..',handler);
			 		}
			 		//CJAX.found_extra_time += 100;
			 		return CJAX.setHandler(handler, callback);
			 	},
			 	isFn: CJAX.lib.isFn,
			 	load: CJAX.lib.loadCallback,
			 	callback: function(event_trigger) {
			 		if(event_trigger==null) {
			 			var event_trigger = true;
			 		}
			 		if(CJAX.debug) {
		 				console.log('Processing Callback:', callbacks);
		 			}
			 		
		 			callbacks = CJAX.util.json(callbacks);
		 			/*if(callbacks){
		 				CJAX.process_all(callbacks,callbacks);
		 			}*/
					for(event in callbacks) {
						buffer = callbacks[event];
						method = CJAX.xml('do', buffer);

						if(CJAX.debug) {
							console.info(method+':','Executing function - ', method);
						}
						if(event_trigger && method=='AddEventTo') {
							var events = CJAX.util.json(CJAX.xml('events', buffer));
							
							for(x in events) {
								event_buffer = events[x];
								CJAX._process(event_buffer.xml);
							}
						} else {
							CJAX._process(buffer);
						}
		 			}
			 	},
			 	prevent : function(count) {
			 		console.log('callbacks:',callbacks);
			 		return cb;
			 	},
			 	ajaxFile: CJAX.f,
			 	file: file,
			 	serialize: CJAX._serialize,
			 	importFile: function(_file, $callback) {
					if(/^https?/.test(_file)) {
						return CJAX.importFile(_file, $callback);
					}
					if(_file.indexOf('.css')!=-1) {
						_file = base+_file;
					} else {
						if(_file.indexOf('/')==-1) {
							_file = base+_file;
						}
					}
					return CJAX.importFile(_file, $callback);
				},
				fn: fn
			 };
			 for(x in extra) {
				 func[x] = CJAX.lib.pharseFunction(extra[x]);
			 }
			 if(settings){
				 for(x in settings) {
					 func[x] = CJAX.lib.pharseFunction(settings[x]);
				 }
			 }
			 return func;
		 };
			
		 try {
			 CJAX.plugins[plugin_name] = window[plugin_name] = _new = new _plugin(buffer);
			
			_new.fn(params['a'],params['b'],params['c'],params['d'],params['e'],params['f']);

			if(CJAX.debug) {
				console.log('Called plugin:', plugin_name);
			}
			return _new;
		}catch(e) {
			
			if(CJAX.debug){
				alert("Error#1 plugin Error "+plugin_name+': '+e);
			}
			console.error("plugin",plugin_name ,"Generated an Error:", e.message);
			return false;
		}
		return _new;
	};
	
	this.processPlugin		=		function(buffer, seconds, my_plugin,callbacks)
	{
		var file = CJAX.xml('file',buffer);

		var plugins_dir = __base__+'plugins/';
		var path = plugins_dir+file;
		var plugin = CJAX.xml( 'do' ,buffer);
		//for some reason a different method was returned, regain the original value
		if(CJAX.debug) {
			console.log('Loading Plugin:', path);
		}
		if(CJAX.lib.isFn(window[plugin]) || CJAX.lib.isFn(plugin) || my_plugin) {
			if(CJAX.lib.isFn(my_plugin)) {
				fn = my_plugin;
			} else if(window[plugin]) {
				fn = window[plugin];
			} else {
				fn = plugin;
			}
			if(seconds){
				return setTimeout( function() {
					return CJAX.extend(fn, plugin, buffer, callbacks);
				},seconds*1000);
			} else {
				return CJAX.extend(fn, plugin, buffer, callbacks);
			}
		} else {
			if(CJAX.ie) {
				alert(plugin+' could not be found or took to long to load.');
			}
			console.log(plugin,'could not be found or took to long to load.');
		}
	};

	this.importFile		=		function(file, $callback, waitfor)
	{
		if(typeof file =='object') {//for plugins
			if(file.files){
				var time = 300;
				if(file.time) {
					time = file.time;
				}
				var files = file.files.split(',');
				var last_number = CJAX.util.count(files) -1;
				var last_file = files[last_file];
				if(file.callback) {
					delete files[last_file];
				}
				testFile = function(_file , cb) {
					if(/^https?/.test(_file)) {
						return CJAX.importFile(files[_file], cb);
					} else if(file.plugin) {
						return CJAX.importFile(CJAX.pBase+file.plugin+'/'+files[_file], cb);
					} else {
						return CJAX.importFile(files[_file], cb);
					}
				};
				for(xfile in files) {
					f = testFile(xfile);
				}
				if(file.callback) {
					testFile(last_number, setTimeout(function() { file.callback(); }, time));
				}
				return true;
			} else {
				if(file.plugin) {
					file = CJAX.importFile(CJAX.pBase+file.plugin+'/'+file.file, $callback);
				} else {
					file = file.file;
				}
			}
		}
		var _import = CJAX.script.load(file, $callback, waitfor);
		 
		return _import;
 	};
 
	this.importPlugin		=		function(file, $callback, waitfor, plugin_name)
	{
		var _import = CJAX.script.load(file, $callback, waitfor);
		 if(plugin_name) {
			console.log('plugin',plugin_name); 
		 }
		return _import;
 	};	
	
	this.remove1Tag		=	function(tag, buffer)
	{
		buffer1 = CJAX.xml(tag,buffer);
		buffer1 = '<'+tag+'>'+buffer1+'</'+tag+'>';
		new_buffer = buffer.replace(buffer1,'');
		return new_buffer;
	};
	
	/**
	* Proccess specific command.
	* buffer is the command
	* caller, any function caller reference.
	* uniqid - an alternative element that is being used.
	*/	
	this.process		=		function( buffer , caller, uniqid) 
	{
		if(!CJAX.defined(caller)) {
			var caller = 'unknown';
		}
		if(!CJAX.is_cjax(buffer)) {
			alert('no cjax - caller: '+caller+'\n'+buffer);return false ;
		};
		
		CJAX._process(buffer, caller, uniqid);
	};
	
	this._process		=		function(buffer , caller, uniqid)
	{
		if(buffer==null) var buffer = '';
		if(encoded==null) var encoded = '';
		CJAX.method = CJAX.get_function(buffer);
		if(!CJAX.method) return false;
		var PREFIX = 'CJAX.';
		var SUBFIX = CJAX.method;
		var f = _FUNCTION = PREFIX+CJAX.method;
	
		var seconds = 0;
		
		var _wait = true;
		
		var flags = CJAX.xml('flags',buffer);
		if(flags) {
			flags = CJAX.util.array(flags,true);
			if(flags) {
				if(flags.FLAG_WAIT  == FLAG_NO_WAIT) {
					_wait = false;
				}
			}
		}

		wait = CJAX._wait(buffer);

		if(_wait) {
			if(wait) {
				seconds = wait; 
			} else {
				var seconds = CJAX.xml('seconds',buffer);
				if(!seconds && CJAX.timer) {
					seconds = CJAX.timer;
				} 
			}
			if(!CJAX.funtion_timer) {
				seconds = 0;
			}
			if(CJAX.debug) {
				console.log(CJAX.method ,"waits :",seconds,'caller:',caller);
			}
		} else {
			if(CJAX.debug) {
				console.log(CJAX.method ,'no wait time','caller:',caller);
			}
		}
		
		//If it is a method
		if(CJAX[SUBFIX]) {
			try {
				if(seconds){
					buffer = buffer.replace(/[\n\r]/gm,'\\n');
					setTimeout(PREFIX+CJAX.method+'("'+buffer+'")',seconds);
				} else {
					fn = CJAX[SUBFIX];
					fn(buffer);
				}
			} catch( _e ) {
				alert('#process unabled to load function#1: '+ CJAX.method+'();  '+_e.message);
			}
			return;
		} else {
			alert("CJAX XML-Processor#1:"+_FUNCTION+' function not found.');
		}
	};
	
	this.xml		=		function (start , buffer , loop , caller) {
		if(!buffer) return;
		if(loop == null) var loop = 0;
		if(typeof start=='undefined') return '';
		if(caller == null) var caller = 'unknown';
		if(!buffer || !start) return '';
		var real_var = start;
		var end = CJAX.left_delimeter+'/'+start+CJAX.right_delimeter;
		start = CJAX.left_delimeter+start+CJAX.right_delimeter;
		try {
			var loc_start = buffer.indexOf( start );
		} catch(e) {
			
			console.log("CJAX: XML-tag"+start+" - '",buffer,"' is not valid xml source.");
			if(CJAX.debug) {
				alert("CJAX: XML-tag"+start+" - '"+buffer+"' is not valid xml source.");
			}
			return;
		}
		var start_len = start.length;
		var end_len = end.length;
		var loc_end = buffer.indexOf( end );
		var middle = loc_end - loc_start - end_len +1;
		if (loc_start == -1 || loc_end ==-1) return '';
		var _new_var = buffer.substr(loc_start+start_len,middle);
		var string_len = loc_start+start_len+_new_var.length+start_len;
		
		if(loop) {
			var myarr = [];
			var i = 0;
			var value;
			var hold = buffer;
			while(CJAX.xml(real_var,hold) && hold) {
				value = CJAX.xml(real_var,hold,0,'CJAX.xml');
				hold = hold.substr((loc_start+start_len)+value.length+end_len);
				myarr[i] = value;
				
				i++;
			}
			if(CJAX.debug) {
				console.log("xml count:",i, 'for tag:',real_var);
			}
			return (myarr)?myarr:'';
		}
		return _new_var;
	};
	
	this.getbyname	=	function(name,tag){
		var x=document.getElementsByName(name); 
		
		if(x.length) {
			return x;
		} else if(x && tag) {
			var elements = document.getElementsByTagName(tag);
			var new_elements = [];
			var element;  
			var x = 0;
			for(var i = 0; i < elements.length; i++) {
				element = elements[i];
				if(element.name == name) { 
				new_elements[x] = element; 
					x = x+1;
				} 
				
			}
			return new_elements;
		}
	};
	
	this.css		=		function(_class,title)  {
		return {
				add:function(_class,title) {
				//if(typeof title=='undefined') var title = 'cjax';
				if(HELPER_STYLE && title=='cjax') {
					if(HELPER_STYLE.cssRules) {
						if(!CJAX.css.get(_class,title)) {
							HELPER_STYLE.insertRule(_class+' { }', 0);
						}
						return CJAX.css.get(_class,title);
					} else {
						//for IE
						if(!CJAX.css.get(_class,title)) {
							HELPER_STYLE.addRule(_class, null,0);
						}
						return CJAX.css.get(_class,title);
					}
				}
				
				function _create(title) {
					var style = document.createElement( 'style' );
					style.type = 'text/css';style.rel = 'stylesheet';style.media = 'screen';style.setAttribute('title',title);return style;
				}
				var styles = document.styleSheets;
				var style;
				for (var i = 0; i < styles.length; i++ ) {
					if(styles[i].title == title ) {
						style = styles[i];
						break;
					}
				}
				
				var head = CJAX.elem_docs('head')[0];
				//if(!CJAX.defined(style)) {
					var obj = _create(title);
					head.appendChild( obj );
				//}
				
				//first for FF
				if(obj.sheet) {
					var style = HELPER_STYLE = obj.sheet;
					style.insertRule(_class+' { }', 0);
				} else {
					//for IE
					var style = HELPER_STYLE = obj.styleSheet;
					style.addRule(_class, null,0);
				}
				
				var new_style =  CJAX.css.get( _class ,title);
				
				return new_style;
			},
			getClass: function(_class,css_file) {
				if(typeof css_file =='undefined') var css_file = null;
				
				if(CJAX.defined(CJAX.styles[_class])) {
					return CJAX.styles[_class];
				}
				
				var styles = document.styleSheets;
				var style;
				var rules;
				for (var i = 0; i < styles.length; i++ ) {
					style = styles[i];
					rules = style.cssRules;
					
					if(css_file && style.href) {
						var base = CJAX.util.get.basename(style.href);
						if(css_file != base) {
							continue;
						}
					}
					if(!CJAX.defined(rules.length)) {
						continue;
					}
					//css file is too big
					if(rules.length && rules.length > 50) {
						continue;
					}
					for(var i = 0; i < rules.length;i++) {
						
						if(typeof rules[i]=='number' || typeof rules[i]=='function') {
							continue;
						}
						if(!CJAX.defined(rules[i].selectorText)) {
							continue;
						}
						
						try {
							if(rules[i].selectorText==_class) {
								CJAX.styles[_class] = rules[i];
								return rules[i];
							}
						}catch(e) {}
					}
					
				}			
			},
			get: function(_class,css_title) {
				if(typeof css_title == 'undefined') var css_title = null;
				
				if(css_title=='cjax') {
					var style = HELPER_STYLE;
					
					var rule;
					if(style.cssRules){
						for(x in style.cssRules) {
							rule = style.cssRules[x];
							if(CJAX.defined(rule) && CJAX.defined(rule.selectorText) && rule.selectorText.toLowerCase() == _class) {
								return style.cssRules[x];
							}
						}
					} else {
						//for IE
						for(x in style.rules) {
							rule = style.rules[x];
							if(CJAX.defined(rule) && CJAX.defined(rule.selectorText) && rule.selectorText.toLowerCase() == _class) {
								return style.rules[x];
							}
						}
					}
				}
			}
		};
	
	}();
	
	this.AJAX		=		function() {
		xmlhttp = false;
		
		if (typeof XMLHttpRequest!='undefined') {
			xmlhttp = new XMLHttpRequest ();
		} else {
			try{
				xmlhttp = new ActiveXObject ("Msxml2.XMLHTTP");
			}
			catch ( _e ){
				try{
					xmlhttp = new ActiveXObject ("Microsoft.XMLHTTP");
				}
				catch ( _e ){
					xmlhttp = false;
				}
			}
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp = new XMLHttpRequest ();
		}
		return xmlhttp;
	};

	this.intval		=		function( number ) {
		var ret =  isNaN( number )? false:true;
		if( ret ) { return number; } else { return 0; } 
	};
	
	this.wait		=		function(seconds) 
	{
		CJAX.timer += parseInt(seconds);
	};
	
	this._wait		=		function( buffer ) {
		if(typeof buffer=='undefined') {
			CJAX.timer = 0;
			CJAX.waiting = false;
			console.log("Timer has be reset.");
			return 0;
		}
		
		CJAX.funtion_timer = true;
		
		if(!FLAG_TIMEOUT_EXPAND) {
			CJAX.funtion_timer = 0;
		}
		var timeout = CJAX.xml('timeout',buffer);
		ms = CJAX.xml('ms',buffer);//is milliseconds?
		
		var time_reset = parseInt(CJAX.xml('time_reset',buffer));
		if(time_reset) {
			CJAX.timer = 0;
		}
		var timeout;
		if(ms) {
			if(timeout.indexOf('.')!=-1) {
				timeout = parseFloat(timeout);
				timeout = timeout * 1000;
			}
		} else {
			timeout = parseInt(timeout);
			timeout = timeout * 1000;
		}
		FLAG_TIMEOUT_EXPAND = CJAX.xml('expand',buffer);
		var not_wait = CJAX.xml('no_wait',buffer);

		if(not_wait) {
			CJAX.funtion_timer = 0;
		} else {
			CJAX.funtion_timer = true;
		}
		if(!timeout) {
			return;
		}
		CJAX.waiting = true;
		if(!CJAX.timer) {
			CJAX.timer = timeout;
		} else {
			CJAX.timer = parseInt(CJAX.timer)+parseInt(timeout);
		}
		
		return CJAX.timer;
	};

	/**
	* Decodes encoded data that passed by parameter
	* data delivered from php
	**/
	this.decode = function( data ) {
		if(!data) {
			return '';
		}
		if(typeof data !='string') {
			return data;
		}
		data = data.replace(/\+/gim," ");
		data = data.replace(/\[plus\]/gim,"+");
		
		data = unescape(data);
		
		return data;
	};
	
	this.update			=		function(element_id, data)
	{
		if(data) {
			CJAX.$(element_id).innerHTML =  data;
		} else {
			CJAX.$(element_id).innerHTML =  '';
		}
	};
	
	/**
	* update an element on the page
	**/
	this._update		=		function(buffer) 
	{
		var element = CJAX.is_element(CJAX.xml('element_id',buffer));
		
		if( !element )  {
			console.log(element,'was not found');
			return false;
		}
		
		var data = CJAX.xml('data',buffer);
		
		if(data) {
			data = CJAX.decode( data );
			element.innerHTML = data;
		} else {
			element.innerHTML = '';
		}
	};
	
	/**
	* redirected to specified location
	*/
	this.location		=		function( buffer ) {
		var destination = CJAX.xml('url',buffer);
		window.location = destination;	
	};
	
	this._serialize		=		function(form,include_files) {
		if(typeof include_files =='undefined') {
			var include_files = true;
		} else {
			CJAX.files = false;
		}
		form = CJAX.is_element(form);
		var url ='';
		var elem_value = '';
		var is_my_radio = new Array( 10 );
		var splitter;
		var assign = '=';
		
		var elems =  form.elements? form.elements: elems;
		var form_len = elems.length;

		for (var n=0; n < form_len; n++) {
			splitter = '&';
			elem  = elems[n];
			elem_id = elem.id;
			elem_type = elem.type;
			elem_name =  elem.name;
			elem_value = elem.value;
			elem_len = elem.length;
			if(!elem_type)continue;
			if(elem_type=='file' && include_files) {
				CJAX.files = true;
			}
			if(elem_id && elem_name)elem_id = elem_name;
			if(!elem_id && elem_name)elem_id = elem_name;
			
			if(!elem_id) {
				continue;
			}
			
			//Try to detect CKEDITOR
			try{
				if (elem_id && typeof CKEDITOR !='undefined' && typeof eval("CKEDITOR.instances."+elem_id) != 'undefined') {
					elem_type = 'ckeditor';
				}
			} catch(e) {}
			switch ( elem_type ) {
				case 'submit':
					if(elem_name.toLowerCase()=='submit') {
						elem.name = 'btnSubmit'; 
					}
					continue;
				break;
			//Detect CKEDITOR value
				case 'ckeditor':
					elem_value =(eval("CKEDITOR.instances."+elem_id+".getData()"));
				break;
				case 'checkbox':
					//if has no value, then not send
					elem_value = ((elem.checked)? 1:'');
					
					if(!elem_value) {
						continue;
					}
					if(elem.value) {
						if(typeof elem.value=='string' && elem.value=='0') {
							elem_value = ((elem.checked)? 1:0);
						} else  {
							if(elem.checked) {
								elem_value = elem.value;
							} else {
								elem_value = '';
							}
						}
					}
				
				break;
				case 'text':
				case 'select-one':
				case 'textarea':
					assign='=';
					elem_value = elem.value;
				break;
				case 'radio':
					
					name =  elem.getAttribute('name');
					var radios = document.getElementsByName(name);
					if(radios) {
						var element;
						var check = '';
			
						for(var i = 0; i < radios.length; i++) {
							element = radios[i];
							if(element.checked) {
								check = element.value;
								break;
							}
							
						}
						
						elem_value = check;
					}
					break;
				case 'hidden':
					elem_value = elem.value;
					break;
				default:
					elem_value = elem.value;
			}
			if(typeof elem_value =='string' && elem_value.indexOf('&') !=-1) {
				elem_value = escape(elem_value);
			}
			
			url += splitter;
			url += elem_id + assign + encodeURI(elem_value);
			assign = '=';
		}
		return url.replace(/^&/, '');
	};
	
	this._form		=		function( buffer ) {
		
		buffer = CJAX.decode(buffer);
		var url = CJAX.xml('url',buffer);
		var form_id = CJAX.xml('form_id',buffer);
		var args = CJAX.xml('args',buffer);
		var container = CJAX.xml('container',buffer);
		var text = CJAX.xml('text',buffer);
		CJAX.IS_POST = is_post  = CJAX.xml('post',buffer);
		
		if(text) {
			CJAX.loading(text,true);
		}
		
		var _confirm = CJAX.xml('confirm',buffer);
		
		if(_confirm) {
			CJAX.$('cjax_overlay').style.display = 'block';
			if(CJAX.handlers._handlerConfirm && CJAX.lib.isFn(CJAX.handlers._handlerConfirm)) {
				$callback = function() {
					confirm_buffer = CJAX.remove1Tag('confirm', buffer);
					CJAX._process(confirm_buffer);
				};
				if(!CJAX.handlers._handlerConfirm(_confirm, $callback)) {
					CJAX.$('cjax_overlay').style.display = 'none';
					return true;
				}
			} else {
				if(!window.confirm(_confirm)) {
					CJAX.$('cjax_overlay').style.display = 'none';
					return true;
				}
			}
			CJAX.$('cjax_overlay').style.display = 'none';
		}

		if(!form_id) {
			var element_id = CJAX.xml('event_element_id',buffer);
			
			if(element_id) {
				form = CJAX.$(element_id).form;
			} else {
				if(typeof CJAX.clicked =='undefined') {
					console.log("Form not found");
					return;
				}
				form = CJAX.clicked.form;
			}
		} else {
			form = CJAX.is_element(form_id);
			if(!form) {
				form = document.forms[form];
				if(!form) {
					form = CJAX.$(form);
				}
			}
		}
		
		if(!form) {
			alert('CJAX: invalid form_id or form not found.'); 
			return false;
		}
		if(!form.id) {
			form.id = 'cjax_form';
			if(!form.name) {
				form.name = form.id;
			}
		}
		serial = CJAX._serialize(form);
		
		url = CJAX._pharseValues(url);
		
		if( container ){
			container = CJAX.$( container );
			if( !container ) return false;
		}
		if(url) {
			CJAX._handleRequestHeaders(url,args,serial);
		}
		
		if(CJAX.handlers._handlerFormRequest && CJAX.lib.isFn(CJAX.handlers._handlerFormRequest)) {
			handlerFormRequest = function() {
				CJAX.handlers._handlerFormRequest(url, serial, args);
			};
		} else {
			handlerFormRequest = function() {
				CJAX._handlerFormRequest(url, serial, args);
			};
		}

		if(CJAX.handlers.fileupload && CJAX.lib.isFn(CJAX.handlers.fileupload)) {
			CJAX.files = CJAX.handlers.fileupload(form, url, handlerFormRequest);
		} else if(CJAX.files) {
			if(CJAX.debug) {
				console.log('built-in handler:',CJAX.handlers);				
			}
			//@deprecated
			CJAX.files = CJAX._handleUploads(form, url, handlerFormRequest);
		}else {
			if(url) {
				handlerFormRequest();
				CJAX.loading();
			}
		}
	};
	
	this.refresh		=		function()
	{
		//this is intentionally left blank.
	};
	
	this._handlerFormRequest		= 	function(url, serial, args) 
	{
		if(CJAX.debug) {
			console.log("Waiting for response...");
		}
		CJAX.HTTP_REQUEST_INSTANCE.onreadystatechange = function () {
			if(CJAX.HTTP_REQUEST_INSTANCE.readyState) {
				if(CJAX.HTTP_REQUEST_INSTANCE.readyState < 4) {
				} else {
					if(CJAX.handlers._handlerRequestStatus && CJAX.lib.isFn(CJAX.handlers._handlerRequestStatus)) {
						response = CJAX.handlers._handlerRequestStatus(url, CJAX.HTTP_REQUEST_INSTANCE.status);
					} else{
						response = CJAX._handlerRequestStatus(url, CJAX.HTTP_REQUEST_INSTANCE.status);
					}
				}
			}
		};
		if(CJAX.ajaxSettings.AjaxVars) {
			serial += '&'+CJAX.ajaxSettings.AjaxVars;
			CJAX.ajaxSettings.AjaxVars = null;
		}
		
		var full_url = url.replace(/\&+$/,'');
		if(serial) {
			full_url +='&'+serial;
		}
		if(args) {
			full_url +='&'+args;
		}
		
		try {
			CJAX.HTTP_REQUEST_INSTANCE.send (  ((is_post)? full_url:null) );
		}catch(e){console.log(e);};
	};
	
	this.setHandler		=		function(name, callback_handler)
	{
		if(CJAX.lib.isFn(callback_handler)) {
			CJAX.handlers[name] = callback_handler;
		} else {
			console.log('Invalid Handler was assigned');
		}
	};
	
	this.ajaxVars		=		function(buffer)
	{
		vars = CJAX.xml('vars',buffer);
		if(vars) {
			CJAX.ajaxSettings.AjaxVars = vars;
		}
	};
	
	/**
	 * @deprecated
	 * Backward compatibily
	 * File uploads are now handle by plugin
	 */
	this._handleUploads		=		function(form, url, $callback)
	{
		var count = 0;
		for(var i = 0; i < form.length; i++) {if(form[i].type=='file') {if(form[i].value) {count = true;break;}}}
		if(!count) {//no files
			return false;
		}
		
		iframe = CJAX.create.frame('frame_upload');
		iframe.style.display = 'none';
		iframe.width = '400';
		iframe.height = '200';
		form.appendChild(iframe);
		
		with(form) {
			method = 'POST';
			action = CJAX.f+'?controller=uploader&function=upload&cjax_iframe=1';
			enctype = "multipart/form-data";
			target = iframe.name;
		}
		
		form.submit();
		CJAX.lib.loadCallback(iframe, function() {
			response = iframe.contentWindow.document.body.innerHTML;
			CJAX.process_all(response);
			if(url) {
				$callback(false);
			}
		});
		return iframe;
	};
	
	this.$					=		function(element_id,v) {
		if(!element_id) {
			return;
		}
		if(typeof element_id =='object') {
			return element_id;
		}
		if(typeof v == 'undefined') {
			var v = false;
		}
		
		if(element_id=='body') {
			return CJAX.elem_docs( 'body' )[0];
		}
		if(element_id=='head') {
			return CJAX.elem_docs( 'head' )[0];
		}
		element_id = element_id.replace(/^\#/,'');
		
		if(/[^a-zA-Z0-9_]/.test(element_id)) {
			//if(CJAX.debug) {
				console.log('Invalid Element ID:', element_id);
			//}
			return;
		}
		return CJAX.is_element(element_id,v);
	};
	
	/**
	* return an element object can pass an string as id or an object
	**/
	this.is_element			=			function(id_obj, verbose) {
		
		var type = (typeof id_obj);
		if( typeof verbose == 'undefined' && CJAX.debug) { verbose = true; }
		if( type.indexOf( 'object' ) != -1) {
			return id_obj;
		} else {
			var elem = document.getElementById(id_obj);
		}
		if(typeof id_obj == 'undefined' || id_obj===null) {
			if( verbose ) alert('Element '+id_obj+' not found'); 
			return false;
		}
		
		if( !elem ){
			
			if(CJAX.util.isXML(id_obj)) {
				elem = CJAX.xml('element_id',id_obj);
			}
			
			if(!elem) {
				if( verbose ) {
					console.log('CJAX: Element "'+id_obj+'" not found on document');
				}
				return false;
			}
		}
		return elem;
	};
	
	this.elem_docs		=		function(id_obj,verbose) {
		if(typeof verbose =='undefined') verbose = true;	
		var obj = document.getElementsByTagName(id_obj);
		if( !obj ) {
			if( verbose ) {
				console.warning('CJAX: Element '+id_obj+' not found on document');
			}
			return;
		}			
		return obj;
	};
	
	/**
	* Make an ajax request
	* 
	* @var $mixed_url required
	* @var $mixed_items optional
	* 
	* Example: 
	* 	CJAX.call('ajax.php', 'container_id');
	* 
	* Example2:
	*	CJAX.call({
	* 	 url: 'ajax.php',
	*    success: function(response) {},
	*    error: function(error_status) {}
	* });
	*/
	this.call			=		function($mix_url, $mix_item)
	{
		if(typeof $mix_url =='object') {
			$mix_item =  $mix_url;
			$mix_url = $mix_item.url;
		}
		if(typeof $mix_item =='undefined') {
			var $mix_item = {};
		}
		var url = $mix_url;
		var $out = [];
		var controller = $mix_url.replace(/\/.+/g,'').replace(/^.+\?/,'');
		var dataType;
		
		var settings = controller.split(':');
		if(settings.length > 1) {
			CJAX.ajaxSettings.dataType = settings[1];
		}
		
		$out.push(CJAX.tag('url',$mix_url));
		
		if($mix_item.crossdomain) {
			$out.push(CJAX.tag('crossdomain', $mix_item.crossdomain));
		}
		if($mix_item) {
			switch(typeof $mix_item) {
				case 'function':
					CJAX.callback_success[url] = $mix_item;
				break;
				case 'object':
					
					if($mix_item.success) {
						CJAX.callback_success[url] = $mix_item.success;
					}
					if($mix_item.error) {
						CJAX.callback_error = $mix_item.error;
					}
					if($mix_item.post) {
						$out.push(CJAX.tag('post', $mix_item.post));
					}
					
					if($mix_item.data) {
						$out.push(CJAX.tag('args',$mix_item.data));
					}
				break;
				default:
					$out.push(CJAX.tag('args',$mix_item));
					
			}
		}
		var xml = '<do>_call</do>'+$out.toString();
		
		return CJAX._call(xml, CJAX.callback_success[url]);
	};
	
	this.post			=		function($url, $args , success_callback)
	{
		var options = {};
		
		options.url = $url;
		if(typeof $args =='function') {
			options.success = $args;
		} else {
			if(typeof $args=='object') {
				var query = '';
				for(x in $args) {
					query += x+'='+$args[x]+'&';
				}
				$args = query.replace(/\&$/,'');
			} else {
				options.data = $args;
			}
			options.success = success_callback;
		}
		
		CJAX.IS_POST = true;
		return CJAX.call(options, options.success);
	};
	
	this.get		=		function($url , container , success_callback) {
		var options = {};
	
		if(success_callback && !CJAX.lib.isFn(success_callback)) {
			CJAX.ajaxSettings.dataType = success_callback;
			success_callback = null;
		}
		options.url = $url;
		if(/^https?/.test(options.url)) {
			options.crossdomain = true;
		}
		if(CJAX.lib.isFn(container)) {
			options.success = container;
		} else {
			options.container =  container;
			options.success = success_callback;
		}
		
		CJAX.IS_POST = false;
		return CJAX.call(options, options.success);
	};
	
	/**
	* call:
	* url,rel,confirm
	*/
	this._call		=		function( buffer , callback ) {
		if(CJAX.debug) {
			console.log('Call executed.');
		}
		buffer = CJAX.decode(buffer);
		var msg = null, x, response;
		
		var url = CJAX.xml('url',buffer);
		url = url.replace(/\&amp\;/gi,"&");
		
		var _confirm = CJAX.xml('confirm',buffer);
		var stamp = CJAX.xml('stamp',buffer);
		var crossdomain = CJAX.xml('crossdomain',buffer);
		var data = CJAX.xml('data',buffer);
		
		var is_loading  =  CJAX.xml('is_loading',buffer);
		if(!is_loading) is_loading = false;
		
		if(_confirm) {
			CJAX.$('cjax_overlay').style.display = 'block';
			if(CJAX.handlers._handlerConfirm && CJAX.lib.isFn(CJAX.handlers._handlerConfirm)) {
				$callback = function() {
					confirm_buffer = CJAX.remove1Tag('confirm', buffer);
					CJAX._process(confirm_buffer);
				};
				if(!CJAX.handlers._handlerConfirm(_confirm, $callback)) {
					CJAX.$('cjax_overlay').style.display = 'none';
					return true;
				}
			} else {
				if(!window.confirm(_confirm)) {
					CJAX.$('cjax_overlay').style.display = 'none';
					return true;
				}
			}
			CJAX.$('cjax_overlay').style.display = 'none';
		}
		
		url = CJAX._pharseValues(url);
		
		if(CJAX.ajaxSettings.stop) {
			CJAX.ajaxSettings.stop = false;
			return true;
		}
		if(CJAX.ajaxSettings.cache) {
			lower_url = url.toLowerCase();
			if(CJAX.cache_calls[lower_url]) {
				CJAX.ajaxSettings.cache = false;
				if(CJAX.callback_success[url]) {
					CJAX.callback_success[url](CJAX.cache_calls[url]);
				}
				return CJAX.cache_calls[lower_url];
			}
		}
		
		var text = CJAX.xml('text',buffer);
		if( !text || text==1) text = 'Loading...';
		if(text =='no_text') text = null;
		
		var is_post  = (CJAX.xml('post',buffer)? CJAX.xml('post',buffer):'');
		var args = CJAX.xml('args',buffer);
		
		if(args) {
			CJAX.IS_POST = true;
		}
		var container_id =  CJAX.xml('container_id',buffer);
		
		if(container_id) {
			var container = CJAX.is_element( container_id ,false);
			if( !container ) {
				alert("CJAX Error: container "+x+ " not found");
				return false;
			}
		}
		
		CJAX.HTTP_REQUEST_INSTANCE = CJAX.AJAX ();
		if(url.indexOf('&') != -1) {
			var ms=+new Date().getTime();
			url += "&cjax="+ms;
		}
		
		if(crossdomain) {
			var ms=+new Date().getTime();
			
			var crossdomain_url = CJAX.f+'?_crossdomain/'+ms;
			return CJAX.post(crossdomain_url,'a='+escape(escape(url)), function(response) {
				
				if(CJAX.lib.isFn(callback)) {
					callback(response);
				}
				if(container)  {
					container.innerHTML = response;
				}
			});
		}
		
		if(text) {
			CJAX.loading(text);
		}
		
		full_url = CJAX._handleRequestHeaders(url, args);
		
		try {
			if(CJAX.debug) {
				console.log("Waiting for response..");
			}
			CJAX.HTTP_REQUEST_INSTANCE.onreadystatechange = function () {
				if(CJAX.HTTP_REQUEST_INSTANCE.readyState) {
					if(CJAX.HTTP_REQUEST_INSTANCE.readyState < 4) {
						//
					} else {
						CJAX.loading();
						response = CJAX._handlerRequestStatus(url,  CJAX.HTTP_REQUEST_INSTANCE.status, container);
						
					}
				}
			};
		} catch( err ) {
			alert('CJAX: Error - "'+err.description+'"'+"\n"+err.message); 
		}
		try  {
			CJAX.HTTP_REQUEST_INSTANCE.send ( ((CJAX.IS_POST)? full_url:null) );
		} catch(e){console.log(e);};
		return response;
	};

	this._handleRequestHeaders		=		function(url,args)
	{
		if(!CJAX.HTTP_REQUEST_INSTANCE) CJAX.HTTP_REQUEST_INSTANCE = CJAX.AJAX();
		if (!CJAX.IS_POST && url.length < 1200) {
			//reset instance
			CJAX.HTTP_REQUEST_INSTANCE.onreadystatechange = function () {};
			CJAX.HTTP_REQUEST_INSTANCE.open ('GET', url);
		} else {
			
			var full_url = url.replace(/\&+$/,'')+'&'+args;
			full_url = full_url.replace(/^.+\?$/,'');
			
			url = url.replace(/\/+$/,'')+'/';

			CJAX.HTTP_REQUEST_INSTANCE.open('POST', url,true);
			if (CJAX.HTTP_REQUEST_INSTANCE.overrideMimeType) {
				CJAX.HTTP_REQUEST_INSTANCE.overrideMimeType('text/html');
			}
			CJAX.HTTP_REQUEST_INSTANCE.setRequestHeader("Content-length", full_url.length);
			CJAX.HTTP_REQUEST_INSTANCE.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			if(url.length > 1500) {
				CJAX.HTTP_REQUEST_INSTANCE.setRequestHeader("Connection", "Closed");
			} else {
				CJAX.HTTP_REQUEST_INSTANCE.setRequestHeader("Connection", "Keep-Alive");
			}
		}
		//don't change this header or you will get a security error.
		CJAX.HTTP_REQUEST_INSTANCE.setRequestHeader('X-Requested-With', 'CJAX FRAMEW0RK //@version;');
		
		return  full_url;
	};
	
	this._handlerRequestStatus		=		function(url, status , container)
	{
		CJAX.default_timeout = 5;
		var response =  CJAX.HTTP_REQUEST_INSTANCE.responseText;
		
		switch(status) 
		{
			case 200: {
				switch(CJAX.ajaxSettings.dataType) {
					case 'json':
						response = CJAX.util.jsonEval(response);
						break;
					default:
					case 'text/html': 
						if(CJAX.ajaxSettings.process) {
							CJAX.process_all(response);
						}
						response =  unescape(response);
				}
				
				if( container ){
					try {
						container.innerHTML = response;
					} catch(err)   {
						alert("Error - Cant not use container. "+err);  
					}
				}
			
				if(CJAX.callback_success[url]) {
					CJAX.callback_success[url](response);
				}
				
				CJAX.cache_calls[url.toLowerCase()] = response;
				if(CJAX.ajaxSettings.success && typeof CJAX.ajaxSettings.success=='function') {
					CJAX.ajaxSettings.success(response);
				}
				
				if(CJAX.ajaxSettings.complete && typeof CJAX.ajaxSettings.complete=='function') {
					CJAX.ajaxSettings.complete(response);
				}
				
			}
			break;
			case 400:
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					CJAX.error('Error: The server returned a "Bad Request" status message 400.');
				}
				break;
			case 403:
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					CJAX.error('Error: Access to this request is forbidden');
				}
				break;
			case 404:
				var msg = 'CJAX Error: File not found '+url;
				if( container ) {
					if(!container.type) { alert('_call: container type is'+ container + msg ); return false; }
				}
				if(url.indexOf('ajax.php')==-1) {
					CJAX.error('Error: File not found '+url);
				} else {
					CJAX.message();
				}
				break;
			case 405:
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					CJAX.error('Error: The server returned a "Methods not allowed" status message 405.');
				}
				break;
			case 414:
				CJAX.error('Error: the data sent was too large.');
				break;
			case 500:
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					CJAX.error("Error: The server encountered an unexpected Error with status 500. See server log for details.");
				}
				break;
			case 503:
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					CJAX.error("Error: Gateway timeout.");
				}
				break;
			case 0:
				CJAX.message();
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					console.log('Request Status: 0. None http protocol.');
				}
				break;
			default:
				if(CJAX.callback_error) {
					CJAX.callback_error(status);
				} else {
					CJAX.warning("Error: Server responded with a unsual response, see available server error logs for details.");
				}
				break;
			
				CJAX.callback_error = null;
		}

		if(CJAX.ajaxSettings.task && CJAX.lib.isFn(CJAX.ajaxSettings.task)) {
			CJAX.ajaxSettings.task();
			CJAX.ajaxSettings.task = null;
		}
		
		//reset settings
		CJAX.ajaxSettings = CJAX.ajaxDefaultSettings;
		
		return response;
	};
	
	/**
	* Display a message in the middle of the screen
	*/
	this._message		=		function( buffer ) {

		var message_id;
		var time;
		var seconds;
		var options = {};
		if(typeof buffer=='object') {
			
			if(buffer.message_id) {
				message_id = buffer.message_id;
			} else {
				message_id = 'cjax_message';
			}
			message = buffer.message;
			
			time = buffer.time;
			
			for(x in buffer) {
				options[x] = buffer[x];
			}
			
		} else {
			message_id = (CJAX.xml('message_id',buffer)? CJAX.xml('message_id',buffer):'cjax_message');
			
			message = CJAX.decode( CJAX.xml('message',buffer) );
			
			time = CJAX.xml('time',buffer);
			
			seconds = CJAX.xml('seconds',buffer);
		}
		var div = CJAX.create.div(message_id);
		
		if(!buffer || !message) {
			div.innerHTML = '';
			return;
		}

		div.innerHTML = message;
		CJAX.set.center(div,options);
		div.style.zIndex = '5999';
		if(typeof buffer=='object') {
			if(buffer.success) {
				buffer.success(div);
			}
		}
		if(time && (seconds > time) || (!seconds && time)){
			if(CJAX.message_id) {
				clearTimeout(CJAX.message_id);
			}
			CJAX.messages[CJAX.message_id]= setTimeout(function(){
				div.innerHTML='';
			}
			,time*1000);
		}
		
		return div;
	};
	
	this.message	=	function(message, seconds) {
		if(typeof message=='undefined') {
			CJAX.$('cjax_message').innerHTML='';
			return ;
		}
		if(typeof message =='object') {
			options =  message;
		} else {

			if(typeof seconds =='undefined') {
				var seconds = CJAX.default_timeout;
			}
			
			options = {
				message: "<data><div class='cjax_message cjax_message_type'>"+message+"</div></data>",
				time : seconds
			};
		}
		CJAX._message(options);
	};
	
	this.info	=	function(message, seconds)
	{
		if(typeof message=='undefined') {
			var message = 'Success!';
		}
		if(typeof seconds =='undefined') {
			var seconds = CJAX.default_timeout;
		}		
		$out  = [];
		$out.push("<data><div class='cjax_message cjax_message_type cjax_info'>"+message+"</div></data>");
		if(seconds) {
			$out.push('<time>'+seconds+'</time>');
		}
		CJAX._message($out.toString());
	};
	
	this.loading	=	function(message)
	{
		if(typeof message=='undefined') {
			this._message();
			return;
		}
		
		CJAX.message({
			message: "<data><div class='cjax_message cjax_message_type cjax_loading'>"+message+"</div></data>"
		});
	};
	
	this.success	=	function(message, seconds)
	{
		if(typeof message=='undefined') {
			var message = CJAX.defaultMessages.success;;
		}
		if(typeof seconds =='undefined') {
			var seconds = CJAX.default_timeout;
		}
		
		CJAX.message({
			
			time: seconds,
			message: "<data><div class='cjax_message cjax_message_type cjax_success'>"+message+"</div></data>"
		});
	};
	
	this.warning	=	function(message, seconds)
	{
		if(typeof message=='undefined') {
			var message = CJAX.defaultMessages.invalid;
		}
		if(typeof seconds =='undefined') {
			var seconds = CJAX.default_timeout;
		}		
		$out  = [];
		$out.push("<data><div class='cjax_message cjax_message_type cjax_warning'>"+message+"</div></data>");
		if(seconds) {
			$out.push('<time>'+seconds+'</time>');
		}
		CJAX._message($out.toString());
	};
	
	this.error	=	function(message, seconds)
	{
		if(typeof message=='undefined') {
			var message = CJAX.defaultMessages.error;
		}
		if(typeof seconds =='undefined') {
			var seconds = CJAX.default_timeout;
		}		
		$out  = [];
		$out.push("<data><div class='cjax_message cjax_message_type cjax_error'>"+message+"</div></data>");
		if(seconds) {
			$out.push('<time>'+seconds+'</time>');
		}
		CJAX._message($out.toString());
	};

	/**
	 * Pharse url elements values passed in vertical bars
	 */
	this._pharseValues		=	function(url)
	{
		var v = url.match(/\|(.+)\|/gi);
		
		try {
			for(x in v) {
				id = v[x].replace(/\|/g,'');
				if(id=='rand') {
					element = CJAX.$(id);
					
					if(!element) {
						_value = new Date().getTime();
					} else {
						_value = element.value;
					}
				} else {
					var use_fns = false;
					
					if(id.indexOf(':') !=-1) {
						use_fns = true;
						fns = id.split(':');
						id = fns[0];
						element = CJAX.$(id);
					} else {						
						element = CJAX.$(id);
					}
					
					if(!element) {
						continue;
					}
				
					switch(element.type) {
						case 'checkbox':
							_value = element.checked? 1: 0;
						break;
						case 'radio':
							var radios = document.getElementsByName(id);
							if(radios) {
								var element;
								var check = '';
					
								for(var i = 0; i < radios.length; i++) {
									element = radios[i];
									if(element.checked) {
										check = element.value;
										break;
									}
								}
								
								_value = check;
							}
						break;
						case 'text':
						default:
							_value = element.value;
					}
				}
				if(use_fns) {
					for(var i = 1; i < fns.length; i++) {
						fn = CJAX.lib.pharseFunction(fns[i]);
						if(!CJAX.lib.isFn(fn) && CJAX.lib.isFn(_value[fns[i]])) {
							_value = _value[fn]();
						} else {
							_fn = function() {
								props = {
									exec: fn,
									stop: function() {
										CJAX.ajaxSettings.stop = true;
									}
								}
								return props;
							};
							fn_object = new _fn();
							
							if(CJAX.lib.isFn(fn) || CJAX.lib.isFn(fn  = window[fns[i]])) {
								switch(element.type) {
									default:
									case 'text':
									_value = fn_object.exec(_value, element);
									if(typeof _value=='undefined') {
										_value = '';
									}
									break;
								}
							}
						}
					}
				}
				url = url.replace(v[x], _value);
			}
		} catch(e) {}//IE being weird
		return url;
	};
	

	this.initiate			=			function() {
		CJAX.vars['loaded'] = [];
		__base__ = CJAX.base = CJAX.dir = CJAX.util.get.basepath()+'/';
		__root__ = CJAX.util.get.dirname(__base__,3)+'/';
		CJAX.f = __root__+'ajax.php';
		
		CJAX.setHandler('handlerRequestStatus', CJAX._handlerRequestStatus);
		
		CJAX.pBase = CJAX.base+'plugins/';
		if(typeof _CJAX_PROCESS !='undefined') {
			_CJAX_PROCESS();
		} else {
			
			if(CJAX.uri.indexOf('crc32')!=-1)  {
				crc32 = CJAX.uri.replace(/.+crc32=/,'');
				CJAX.importFile(CJAX.base+'core/js/cjax.js.php?crc32='+crc32);
			} else {
				CJAX.importFile(CJAX.base+'core/js/cjax.js.php?preload='+Math.random());
			}
		}
		var nav=navigator.userAgent.toLowerCase();
		this.ie	= ((nav.indexOf("msie") != -1) && (nav.indexOf("opera") == -1));

		if(CJAX.ie) {
			CJAX.ie = {};
			ie = ['alert','confirm','focus','blur'];
			for(x in ie) {
				CJAX.ie[ie[x]] = true;
			}
		}
		
		function myClickListener(e) {
			var eventIsFiredFromElement;
			if(e==null) {
				eventIsFiredFromElement = event.srcElement;
			} else {
				eventIsFiredFromElement = e.target;
			}
			CJAX.clicked =eventIsFiredFromElement;
		}
		document.onclick = myClickListener;
		var div = CJAX.create.div('cjax_overlay');
		div.className = 'cjax_overlay';
		div.onclick = CJAX._removeOverLay;
		
		
		/**
		* Deal with Firebug not being present
		*/
		if (!window.console || !console.firebug) {
			(function(w) { var fn, i = 0;
				if (!w.console) w.console = {};
				fn = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'getFirebugElement', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'notifyFirebug', 'profile', 'profileEnd', 'time', 'timeEnd', 'trace', 'warn'];
				for (i = 0; i < fn.length; ++i) if (!w.console[fn[i]]) { w.console[fn[i]] = function() {}; }
			})(window);
		}
		
		var cjax_css = CJAX.css.add('.cjax','cjax');
		if(cjax_css) {
			cjax_css.style.position = 'absolute';
			cjax_css.style.visibility = 'hidden';
			cjax_css.style.display = 'none';
		}
		CJAX.ready(CJAX.onStartEvents);
	};
	
	this.ready		=		function(fn) {
		if(!CJAX.lib.isFn(fn)) {
			if(CJAX.debug) {
				console.log(fn, 'is not a function');
			}
			return;
		}
		CJAX.set.event(window,'load', fn);
	};
	
	this.onStartEvents		=		function() {
		CJAX.importFile(__base__+'core/css/cjax.css');
		//ajax requests made with jquery..
		if(typeof jQuery !='undefined') {
			jQuery.ajaxSetup({
				complete: function(a, b) {
					
					if(a) {
						CJAX.process_all(a.responseText);
					}
				}
			});
		}
	};
}

var CJAX = new CJAX_FRAMEWORK();
CJAX.initiate();

