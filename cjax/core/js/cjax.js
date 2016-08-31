/** ################################################################################################**
 * Copyright (c)  2008  CJ.
 * Permission is granted to copy, distribute and/or modify this document
 * under the terms of the GNU Free Documentation License, Version 1.2
 * or any later version published by the Free Software Foundation;
 * Provided 'as is' with no warranties, nor shall the autor be responsible for any mis-use of the same.
 * A copy of the license is included in the section entitled 'GNU Free Documentation License'.
 *
 *   ajax made easy with cjax
 *   -- DO NOT REMOVE THIS --
 *   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -
 *   Written by: CJ Galindo
 *   Website: http://cjax.sourceforge.net                     $
 *   Email: cjxxi21 [at]gmail dot com
 **####################################################################################################    */

/**
 * @returns {CJAX_FRAMEWORK}
 */

function CJAX_FRAMEWORK() {
	this.name		=	'cjax';
	this.version	=	'5.9';
	this.debug = false;
	this.DOMContentLoaded = false;
	this._Ready = {};
	this.loaded = {};
	this.payload = {};
	this.queue = {};
	this.queueCompleted = {};
	this.handlers = {
		handlerFileupload: function(form, url, funcRequestCallback) {},
		handlerRequestStatus: function(url, request_status) {},
		handlerFormRequest: function(url, serial, args) {},
		handlerConfirm: function(question, callback) {}
	};
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
	this.message_id = 0;
	this.commands = {};
	this.callback_success = {};
	this.default_timeout = 3;
	this.messages = [];
	this.is_loading = true;
	this.clicked;
	this.IS_POST = false;
	this.ie;// is IE? -_-
	this.cache_calls = {};
	this.calls_in_progress = {};
	this.dir;
	this.files = false;
	this.styles = [];

	this.timer = 0;
	this.funtion_timer = true;

	this.defaultMessages = {
		invalid: 'Invalid Input!',
		success: 'Success!',
		error: 'Error!'
	};
	this.callback  = {
		success: function() {},
		complete: function() {},
		error: function() {},
		overlayPop: function() {}
	};

	this.ajaxSettings = this.ajaxDefaultSettings = {
		dataType: 'text/html',
		cache : true,
		process: true,
		ajaxVars: {},
		success: function() {},
		complete: function() {},
		error: function() {},
		overlayPop: function() {},
		stop: false //if true, halts an ajax request and resets to false
	};

	this.ajaxDefaultSettings.cache = false;
	//don't change these

	//holds the internal cjax style
	var HELPER_STYLE;

	this.Execfn		=		function(fn,element,data)
	{
		xraw_fn = fn;

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
					if(data.c){
						element['innerHTML'] = element['innerHTML']+data.b;
					} else {
						element['innerHTML'] = data.b+element['innerHTML'];
					}
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
				CJAX.lib.fnCall(element,{xraw_fn: data.b});
		}
	};

	this._fn		=		function(settings)
	{
		var fn = raw_fn = settings.fn;
		var prop;

		var data = settings.options;

		if(!data) {
			console.warn('_fn no data', settings,data, arguments.callee.caller);
			return false;
		}

		var count = CJAX.util.count(data);

		switch(fn) {
			case 'document':
				if(typeof document[data.a]=='string') {
					data.b = CJAX._pharseValues(data.b);
					return document[data.a] = data.b;
				}
				break;
		}

		/*if(count == 0) {
			return CJAX.Execfn(raw_fn, CJAX.clicked);
		}*/

		function _processFn(my_fn, type)
		{
			if(type=='direct') {

				str = raw_fn.toLowerCase().replace(/\b([a-z])/gi,function(c){return c.toUpperCase();});
				if(CJAX.handlers['_handler'+str] && CJAX.lib.isFn(CJAX.handlers['_handler'+str])) {
					if(CJAX.handlers['_handler'+str](data.a,data.b,data,settings)) {
						return true;
					}
				}
				switch(raw_fn) {
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
						var element = CJAX.$(data.a);

						var event = new MouseEvent('click', {
							'view': window,
							'bubbles': true,
							'cancelable': true
						});
						var cb = element;
						var canceled = !cb.dispatchEvent(event);
						if (canceled) {
							// A handler called preventDefault.
						} else {
							// None of the handlers called preventDefault.
						}

						console.log(event, element);

						//element.click();
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
						arr_data = [];
						for(x in data) {
							arr_data.push(data[x]);
						}
						my_fn.apply(this, arr_data);
				}
				return;
			} else if(type=='custom') {
				data.a = data.a.replace(/^\#/,'');
				data.b = CJAX.decode(data.b);
				element = CJAX.$(data.a);
				if(!element) {
					console.log('Element',data.a, 'cold not be found in the document.');
					return;
				}
				try {
					return CJAX.Execfn(raw_fn,element,data);
				}catch (e) {
					alert("Function "+raw_fn+ " generated an error: "+e);
					return;
				}
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
								window[raw_fn][data.a](data.b);
							}
						}
					}
				} else {
					arr_data = [];
					for(x in data) {
						arr_data.push(data[x]);
					}
					my_fn.apply(this, arr_data);
				}
			}
		}


		try {
			for(x in data) {
				data[x] = CJAX.lib.pharseFunction(data[x]);
			}
		} catch(e) {
			console.log("Function Error:",e.message,"in your dynamic $ajax->"+raw_fn+" function.", "\n\n\n", data[x]);
			alert("Function Error:"+e.message+", in your dynamic $ajax->"+raw_fn+" function.");
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
			if(CJAX.ie[raw_fn]) {

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
					xfn = element[fn];
					if(xfn) {
						_processFn(v);
					} else {
						_processFn(fn,'custom');
					}
				} else {
					console.log("Element", data.a, "could not be found.");
				}
			}
		}
	};

	this.property  	=		function (settings)
	{
		var element = settings.selector;

		if(!element) {
			element = CJAX.$(settings.element_id);
		}

		if(!element) {
			console.log('property: element_id -', settings.element_id, 'was not found', settings);
			return;
		}

		if(settings.options) {
			var value = settings.options.a;
		} else {
			var value = settings.value;
			if(CJAX.util.json(value)) {
				value = CJAX.util.json(value);
			}
		}
		if(typeof value =='object') {
			try {
				for (x in value) {
					if (typeof value[x] == 'object') {
						for (item in value[x]) {
							element[x][item] = CJAX.decode(value[x][item]);
						}
					} else {
						element[x] = CJAX.decode(value[x]);
					}
				}
			}catch(e) {
				console.error(element, e);
			}
		}  else {
			switch ( element.nodeName ) {
				default:

					console.info('Property: default Assignment to',element, ' value.');
					element.value = value;
					break;
				case 'BUTTON':
					element.value =  value;
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
				case 'DIV':
				case 'SPAN':
				case 'THEAD':
				case 'TH':
				case 'TR':
				case 'TD':
				case 'TBODY':
				case 'TFOOT':
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
		element_id = buffer.element_id;
		var element = CJAX.is_element(element_id);
		if(element) {
			element.parentNode.removeChild( element );
		}
	};

	this.util		=		function()
	{
		return {
			applySelector: function(selector,callback) {

				if(typeof selector == 'object') {
					return callback({0 : selector});
				}
				CJAX.util.queue('sizzle.js', function () {
					return callback(Sizzle(selector));
				});
			},
			//turn an entire cjax xml string, into an object.
			objectify: function(xml, parent) {

				var data = {};
				xml = xml.replace(/\n\r/gim,'');
				var items = xml.match(/<([\w]+)>(.+?)<\/\1>/gi);
				var event;

				try {
					if (items) {
						for (x in items) {
							event = items[x].match(/<(.+)>(.+)<\/\1>/i);

							if (parent) {
								return CJAX.util.objectify(event[2], null);
							} else {
								if(event){
									data[event[1]] =  CJAX.decode(event[2]);
								}
							}
						}

						if(data && data.options) {
							data.options = CJAX.util.jsonString(data.options);
						}


					}
					return data;
				}catch(e) {
					//stupid IE???
				}
			},
			tag: function(options, tag, tag_value) {
				if(options) {
					for (var i in options) {
						if (typeof options[i] == 'object') {
							if(options[i].options) {
								options[i].options = CJAX.util.tag(options[i].options,tag, tag_value);
							} else {
								for (var i2 in options[i]) {
									if (typeof options[i][i2] == 'string') {
										options[i][i2] = options[i][i2].replace(tag, tag_value);
									}
								}
							}
						} else {
							if(typeof options[i] == 'string') {
								options[i] = CJAX.decode(options[i]).replace(tag, tag_value);
							}
						}
					}
				}
				return options;
			},
			cleanString: function(str) {
				return str.toLowerCase().replace(/[^\w\s]/gi, '');
			},
			payload: function(file, data) {
				if(typeof data == 'undefined') {
					return CJAX.payload[CJAX.util.cleanString(file)];
				}
				CJAX.payload[CJAX.util.cleanString(file)] = data;
			},
			loaded: function(file, data) {
				if(typeof data == 'undefined') {
					return CJAX.loaded[CJAX.util.cleanString(file)];
				}
				CJAX.loaded[CJAX.util.cleanString(file)] = data;
			},
			queueCompleted: function(file) {
				CJAX.queueCompleted[CJAX.util.cleanString(file)] = true;
			},
			queue: function(file, fn) {
				if(!fn) {
					return CJAX.queue[CJAX.util.cleanString(file)];
				}
				if(CJAX.queueCompleted[CJAX.util.cleanString(file)]) {
					fn.call();
				} else {
					var count = CJAX.util.count(CJAX.queue[CJAX.util.cleanString(file)]);
					if (!CJAX.queue[CJAX.util.cleanString(file)]) {
						CJAX.queue[CJAX.util.cleanString(file)] = {};
					}
					CJAX.queue[CJAX.util.cleanString(file)][count] = fn;
				}
			},
			cacheURL: function(cache_url, data, dataType) {
				if(typeof cache_url != 'undefined') {
					var lower_url = CJAX.util.cleanString(cache_url);

					CJAX.cache_calls[lower_url] = {
						response: data,
						dataType: dataType
					};
				}
			},
			cachedURL: function(cache_url) {
				if(typeof cache_url != 'undefined') {
					var lower_url = CJAX.util.cleanString(cache_url);

					return CJAX.cache_calls[lower_url];
				}
			},
			cacheState: function(cache_url, settings) {
				var lower_url = CJAX.util.cleanString(cache_url);

				if(CJAX.calls_in_progress[lower_url]) {

					for(x in settings) {
						CJAX.calls_in_progress[lower_url][x] = settings[x];
					}
				} else {
					CJAX.calls_in_progress[lower_url] = {
						url: cache_url,
						message: settings.message
					};
				}
			},
			cachedState: function(cache_url) {
				if(typeof cache_url != 'undefined') {
					var lower_url = CJAX.util.cleanString(cache_url);

					return CJAX.calls_in_progress[lower_url];
				}
			},
			isXML: function(data) {
				if(typeof data !='string') {
					return false;
				}
				if(data.indexOf('<')!=-1 && data.indexOf('>')!=-1) {
					return true;
				}
				return false;
			},
			jsonString: function(data) {
				var json = CJAX.util.json(data);
				if(!json) {
					return data;
				}
				return json;
			},
			json: function(buffer, tag)
			{
				var err;
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

				var try1 = function(data) {
					try {
						if(_parse) {
							json =  _parse(data);
						} else {
							json =  eval("("+data+")");
						}
					} catch(e) {
						err = e;
						return false;
					}

					return json;
				};

				if(buff = CJAX.decode(CJAX.xml(tag,buffer))) {
					try {
						var json = try1(buff);

						if (typeof json != 'object') {
							new_buff2 = CJAX.decode(buff);
							json = try1(new_buff2);

							if(typeof json != 'object') {
								new_buff3 = CJAX.decode(new_buff2).replace(/\\/gi, '');
								json = try1(new_buff3);

								if(!json) {
									new_buff4 = new_buff3.replace(/\r?\n|\r|\t/gm,'');

									json = try1(new_buff4);

									if(!json && err) {

										console.warn('There was an error while processing data:', err);
										console.log('Original String:', buff);
										console.info('Modified String:', new_buff4);
									}
								}
							}
						}

						if (typeof json == 'undefined' || !json) {
							return {};
						}

					} catch(e) {
						console.error('Parser Error looking for:',tag,e, buffer, arguments.callee);
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
				if (!mixed_var){
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
					var script;
					var src;

					script = CJAX.$('cjax_lib');

					if(script) {
						src = script.src;
						var f = src.replace(/cjax-.+$/,'');

						CJAX.uri = script.src;

						return f;
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



	this.toggle		=		function(options) {
		var container_id =  options.container_id;
		var container = CJAX.$(container_id);

		if(!container) {
			alert("CJAX Error -  Element "+ container_id +" not found");
			return;
		}

		var element_id = options.event_element_id;
		var element = CJAX.$(element_id);

		var label1 = options.label1;
		var label2 = options.label2;

		if(element.value) {
			prop = 'value';
		} else if(element.innerHTML) {
			prop = 'innerHTML';
		}

		if(element[prop] ==  label2) {
			element[prop] = label1;

			container.style.display = 'none'
		} else {
			element[prop] = label2;
			container.style.display = 'block'
		}
	}

	/**
	 * Takes 2 arguments with the API -  a selectbox and the id of another selectbox
	 * and loads an array into the second selectbox depending on what is choosen in the first one
	 * if there are no records to display, then it will convert the second selectbox into a text input
	 * so the user can enter the record instead
	 *
	 * @param buffer
	 */
	this.select		=			function(options) {
		var element_id = options.element_id;
		var element = CJAX.$(element_id);

		if(!element) {
			alert('An error Ocurred, see console for details.');
			console.error("CJAX Error -  Element "+ element_id+" not found");
			return;
		}

		var allow_input = options.allow_input;
		var _selected = options.selected;

		var options = options.options;//CJAX.util.json(CJAX.decode(CJAX.xml('options',buffer)));

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
		var top = (CJAX.util.get.y()+100)+'px';

		if(!options.content) {
			return CJAX._removeOverLay();
		}
		CJAX.lib.overlayOptions(options);

		CJAX.$('cjax_overlay').style.display = 'block';
		if(!options.top) {
			options.top = top;
		}
		options.message = CJAX.decode(CJAX.decode(options.message));
		options.content = CJAX.decode(CJAX.decode(options.content));
		options.message_id = 'cjax_message_overlay';
		options.success = function() {
			CJAX.lib.overlayCallback(CJAX.decode(options.content), options);
			if(CJAX.callback.overlayPop && typeof CJAX.callback.overlayPop=='function') {
				CJAX.callback.overlayPop(options);
				if(options.clear) {
					CJAX.callback.overlayPop = function () {};
				}
			}
		};
		CJAX.message(options);
	};

	this.overLay		=		function(url, options)
	{
		var top = (CJAX.util.get.y()+100)+'px';

		if(!options.top) {
			options.top = top;
		}

		if(!options.url) {
			return CJAX._removeOverLay();
		}

		CJAX.lib.overlayOptions(options);

		CJAX.$('cjax_overlay').style.display = 'block';

		if(options.callback) {
			options.callback = CJAX.lib.pharseFunction(options.callback);
		} else {
			options.callback = function() {};
		}

		options.message_id =  'cjax_message_overlay';
		options.message = CJAX.decode(options.message);
		options.success = function() {
			if(options.cache) {
				CJAX.ajaxSettings.cache = true;
				CJAX.ajaxSettings.process = false;
			}
			CJAX.get(options.url, function(response) {
				CJAX.lib.overlayCallback(response,options);
				if(CJAX.callback.overlayPop && typeof CJAX.callback.overlayPop=='function') {
					CJAX.callback.overlayPop(options);
				}
			});
		};
		CJAX.message(options);

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
			overlayCallback: function(response,options) {
				if(options.callback) {
					if(CJAX.lib.isFn(options.callback)) {
						//response = callback(response, CJAX.$('cjax_message_overlay'));
						CJAX.html('cjax_overlay_content',response);
					} else {
						CJAX.html('cjax_overlay_content',response);

						//CJAX.process_all(callback, callback, null,'skip');
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
					console.log('Script was not found', element, caller, $callback.toString());
					return ;
				}
				if(typeof element == 'string') {
					var raw_string = element;
					element = CJAX.util.loaded(element);

					if(!element) {
						var payload = CJAX.util.payload(raw_string);
						if(!payload) {
							//object hasnt beed added to payload
							console.warn('Script/Element was not found:', raw_string, CJAX.loaded);
							return false;
						} else {
							if(CJAX.debug) {
								console.info('Payload Found:', raw_string, CJAX.loaded, payload);
							}

							if(!/[^a-zA-Z0-9_\-]/.test(raw_string)) {
								new_element = CJAX.$(raw_string);
								if (new_element) {

									new_element.loaded = true;
									$callback(new_element);
									return new_element;
								}
								/*if(!/[^a-zA-Z0-9_]/.test(raw_string) && window[raw_string]) {
								 $callback(element);
								 return window[raw_string];
								 }*/
							}
							//object is already registered that is going to load, it is a matter of time.
							if(typeof payload != 'boolean') {
								payload = payload - 100;
								if(payload <= 0) {
									console.warn('Payload for', raw_string, 'has expired.');
									return false;
								}
							}
							return setTimeout( function() {
								CJAX.util.payload(raw_string, payload);
								CJAX.lib.loadCallback(raw_string, $callback, caller);
							}, 100);
						}
					}
					element.loaded = true;
					return $callback(element);
				}
				if(element.loaded) {
					$callback();
					return false;
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
							element.onload = function () {
								element.loaded = true;
								return $callback();
							};

							giveup = function (time) {
								setTimeout(function () {
									if (typeof element == 'object' && !element.loaded) {
										//if(CJAX.debug) {
										console.log('Forcing loadCallback', element, 'to complete.');
										//}
										element.loaded = true;
										return $callback();
									}
								}, time);
							};
							setTimeout(function () {
								if (!element.loaded) {
									giveup(300);
								}
							}, 120);
						}
					}
				}
				return element;
			},
			pharseFunction: function(buffer) {
				if(typeof buffer != 'string') {
					return buffer;
				}

				if(typeof buffer=='string' && buffer.substr(0,'function('.length)=='function(') {
					try {
						fn = eval('('+buffer+')');
					} catch(e) {
						console.error('Function Error:\n',e, '\n\n', buffer);
					}
					if(CJAX.lib.isFn(fn)) {
						return fn;
					}
				}
				if(CJAX.xml('json',buffer)) {
					return CJAX.util.json(buffer);
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
							position = 'fixed';
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
								backgroundColor = _color;
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

	this.AddEventTo	=	function( options )
	{
		var	element_id = options.element_id;

		if(/[^a-zA-Z0-9_\-]/.test(element_id)) {

			if(CJAX.debug) {
				console.info('AddEventTo Selector for sizzle', element_id);
			}

			CJAX.$(element_id, function(elements) {

				if(CJAX.debug) {
					console.info('AddEventTo Selector', element_id, 'elements:', elements);
				}
				for(var x in elements) {
					options.selector = elements[x];
					CJAX.__AddEventTo(elements[x], options);
				}
			});
		} else {

			//options.selector = CJAX.$(element_id);
			CJAX.__AddEventTo(element_id, options);
		}
	};

	this.__AddEventTo	=	function(element, options)
	{
		var data, event_trigger, trigger, events, new_options;

		events = CJAX.util.json(options.options);
		event_trigger = options.event;


		if(!element) {
			console.error('__AddEventTo', 'No Element:',element, options);
			return false;
		}

		for(var x in events) {
			data = events[x];
			trigger = data.event? data.event: event_trigger;


			data.selector = options.selector;
			data.cache_id = x;

			if(!CJAX.is_loading && data.is_plugin) {
				new_options = data;
				if(window[new_options.is_plugin]) {
					CJAX.set.event(element, trigger, new_options);
				} else {

					CJAX.lib.loadCallback(new_options.filename, function () {
						el = CJAX.$(new_options.element_id);
						CJAX.set.event(el, trigger, new_options);
					});
				}
			} else {
				CJAX.set.event(element, trigger, data);
			}
		}
	};

	this.setEventProcessFnHandler	=		function(cache, element, _event, use_fns, cb) {

		var _fn, new_fn;

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

		if(plugin_name = cache.is_plugin) {

			if(init = CJAX.inits[plugin_name]) {
				plugin_fn = CJAX.lib.pharseFunction(init);
				plugin_fn();
			}

			_fn = function() {
				var plugin_name = cache.is_plugin;

				var plugin_fn = function(element, cache, _event) {
					CJAX._extendPlugin(plugin_name, cache, {
						//options: cache.options,
						element: element,
						event: _event,
						element_id: element.id,
						clear: function() {
							CJAX._EventCache.flushElement(element);
						},
					});
				};

				CJAX.lib.loadCallback(CJAX.util.loaded(cache.filename), function() {
					plugin_fn(element, cache, _event);
				});
			};
		} else {
			_fn = function(data) {
				CJAX._process(data,'setEventProcessFnHandler');
			};
		}

		switch(_event) {
			case 'onchange':

				new_fn = function(data) {
					_fn(data);
				};
				break;
			case 'onkeypress':
				var key = cache.key;
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
				break;
			case'onkeyup':
				new_fn = function(data) {
					_fn(data);
				};
				break;
			default:
				new_fn = _fn;
		}

		return cb(new_fn, cache, element, _event);
	};

	/**
	 * Util Set
	 */
	this.set				=			function() {
		return {
			title: function(title) {
				document.title = title;
			},
			event: function(element,trigger,options){
				var use_fns = false;
				if(typeof options == 'undefined') {
					options = {};
				}

				var cache_id = new Date().getTime();
				if(options.cache_id) {
					cache_id = options.cache_id;
				}

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

				if( !element ) return false;
				var element = CJAX.is_element( element );

				var f = options.toString();
				f = f.substr(0,f.indexOf('('));
				f = f.replace(/\s+$/,"");

				if(f =='function' ||CJAX.lib.isFn(options)) {
					if(typeof options =='function') {
						return CJAX._addEvent(element ,trigger , options, cache_id);
					} else {
						return CJAX._addEvent(element ,trigger ,eval(options), cache_id);
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
					switch(element.tagName) {
						case 'IMG':
						case 'DIV':
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

				return CJAX.setEventProcessFnHandler(options, element, trigger, use_fns,
					function(new_fn, cache, element) {
						//copy object, or be ready to handle some assync nightmare
						cache = Object.assign({}, cache);
						cache.selector = element;
						var event_id = CJAX._addEvent(element, trigger, function(new_opts) {
							new_fn(cache);
						});

						return event_id;
					});

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


	this.is_cjax		=		function(buffer) {
		if(typeof buffer !='string') {
			return;
		}
		if( !CJAX.xml(this.name,(CJAX.defined(buffer)?buffer:null)) ){ return false; }
		return true;
	};

	this.get_function		=		function(options) {
		if(typeof  options == 'object') {
			return options['do'];
		}
		return CJAX.xml( 'do' , options);
	};

	this._addEvent		=		function( obj, type, fn, cache_id)
	{
		if(typeof cache_id == 'undefined') {
			cache_id = new Date().getTime();
		}

		if(!CJAX.defined(id)) {
			var id = null;
		}
		if(type.substring(0, 2) == "on"){
			type = type.substring(2);
		}
		if (obj.addEventListener) {
			if(type=='ready'){
				CJAX.ready(fn,obj);
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

	var listEvents = {};
	this._EventCache		=		function(){
		return {
			listEvents : listEvents,
			add : function(node, sEventName, fHandler){
				return listEvents[CJAX.util.count(listEvents)+1] = {
					node: node,
					event_name: sEventName,
					handler: fHandler
				};
			},
			flushElement: function(element) {

				var item;

				for(var i in listEvents){
					item = listEvents[i];

					if(item.node==element) {
						if (item.node.removeEventListener) {
							item.node.removeEventListener(item.event_name, item.handler);
						} else {
							if (item.event_name.substring(0, 2) != "on") {
								item.event_name = "on" + item.event_name;
							}
							if (item.node.detachEvent) {
								if (item.node == element) {
									item.node.detachEvent(item.event_name, item.handler, false);
								}
							}
						}
					}
				};
			},
			flush : function( event_id ) {
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
				var f = CJAX.$(id);
				if(!f) {
					if(CJAX.ie) {
						f = document.createElement('<iframe name="'+id+'"/>');
					} else {
						f = document.createElement("IFRAME");
					}
					f.setAttribute("id",id);
					f.setAttribute("name",id);
					f.setAttribute("width",600);
					f.setAttribute("height",300);

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
				if(CJAX.util.loaded(f)) {
					if(CJAX.debug) {
						console.log('Already loaded:',script );
					}

					if($callback && !waitfor) {
						$callback();
					}
					return false;
				}
				CJAX.util.payload(f, true);
				var head = CJAX.elem_docs( 'head' )[0];
				var file_ext = CJAX.util.get.extension(script);
				if(file_ext=='.css') {
					var s = document.createElement("link");
					s.setAttribute("rel", "stylesheet");
					s.setAttribute("type", "text/css");
					s.setAttribute("href", script);
					head.appendChild( s );
				} else {
					var s = document.createElement( 'script' );
					s.type = 'text/javascript';
					head.appendChild( s );
					s.onload = function() {
						var queue = CJAX.util.queue(f);
						if(queue) {
							for (var x in queue) {
								queue[x].call(this);
							}
						}
						CJAX.util.queueCompleted(f);
					}
					s.src= script;
				}

				CJAX.util.loaded(f, s);

				if($callback && !waitfor) {
					CJAX.lib.loadCallback(s , $callback,f);
				}

				if(waitfor) {
					if(CJAX.util.loaded(waitfor)) {
						CJAX.lib.loadCallback(CJAX.util.loaded(waitfor) , function() {
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

		if (!CJAX.is_cjax(actions) && typeof actions != 'object'){ return; }

		if(!CJAX.is_loading) {
			if(!preload) {
				preload = CJAX.xml('preload', raw_actions);

				preload = CJAX.util.json(preload);
			}
		}
		if(is_loading!='skip') {
			CJAX.commands =  actions;
		}
		if(!is_loading) CJAX.is_loading = false;
		if(caller==null) var caller = 'unkonwn';
		if(debug!=null) {
			CJAX.debug = debug;
		}
		if(CJAX.debug) {
			console.log('initiating process_all', 'initiated by:',caller);
		}

		//preload
		if(preload) {

			var plugin_buffer;
			for(_id in preload) {
				buffer = preload[_id];
				method = CJAX.xml('do',buffer);

				switch(method) {
					case '_import':
						if(time = CJAX.xml('time', buffer)) {
							CJAX.found_extra_time += parseInt(time);
						} else {
							CJAX.found_extra_time += default_load_timeout;
						}

						CJAX._process(buffer,'process_all for '+method, method+' '+_id);
						break;
					default:
						if(CJAX.xml('is_plugin', buffer) ) {
							plugin_buffer = buffer;
							plugin_method = CJAX.xml('do',plugin_buffer);
							var options = CJAX.util.objectify(plugin_buffer,'cjax');

							CJAX._plugins[plugin_method] = options;
							if(CJAX.debug) {
								console.log('Preloading Plugin:', method);
							}
							var file = CJAX.pBase+options.file;

							init = CJAX.xml('init', plugin_buffer);

							if(init) {
								CJAX.inits[plugin_method] = init;
							}

							ximport = function(f, options) {
								CJAX.importPlugin(f, function () {
									options.first_run = true;
									CJAX._extendPlugin(options.is_plugin, options);
								});
							};

							ximport(file, options);
						}
				}
			}
		}

		var action,buffer, method;
		CJAX.ready(function() {
			for(_id in actions) {
				buffer = actions[_id];
				method = CJAX.xml('do', buffer);

				if(method=='_import' || method=='_imports' || CJAX.xml('is_plugin', buffer)) {
					//already imported.
					continue;
				}

				action = CJAX.util.objectify(buffer, 'cjax');

				if(typeof action.options == 'object' && CJAX.util.count(action.options) == 0) {
					console.warn(action, 'possibly missing options!');
				}

				if(CJAX.debug) {
					console.info('process_all item', action);
				}

				CJAX._process(action,'process_all for '+method, method+' '+_id);
			}
		});
		CJAX.is_loading = false;
		CJAX.timer = 0;
	};

	this._extendPlugin		=		function(plugin_name, options, settings)
	{
		if(waitfor = options.waitfor) {
			if(CJAX.debug) {
				console.info(plugin_name, 'waiting for', waitfor);
			}
			//using waitfor method. see above this loop
			return true;
		}
		if(CJAX.debug) {
			console.log('Loading:', options);
		}

		var _p = window[plugin_name];
		var file = CJAX.pBase+ options.file;

		callbacks = options.callback;

		if(CJAX.debug && callbacks) {
			console.info('Plugin Buffer', options.xml);
			console.info("Callbacks found for", plugin_name, callbacks);
		}
		if(CJAX.lib.isFn(_p) || typeof _p == 'object') {
			CJAX.extend(_p, options, callbacks, settings);
		} else {
			CJAX.lib.loadCallback(CJAX.util.loaded(options.filename), function(){

				if(CJAX.lib.isFn(window[plugin_name]) || typeof window[plugin_name] == 'object') {
					plugin = CJAX.extend(window[plugin_name], options, callbacks, settings);
				} else {
					console.log(plugin_name, 'option ??', window[plugin_name], _p);
				}
			},null, plugin_name);
		}
	};

	this._import		=		function(options, loop)
	{
		var file = options.file;

		if(!file) {
			console.info('no file',options);
			return;
		}

		if(/^https?/.test(file)) {
			f = CJAX.script.load(file);
		} else {
			if(dir = options.plugin_dir) {
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
		return f;
	};

	this.extend			=	function(plugin_fn, options, callbacks, settings)
	{
		var plugin_name = options.is_plugin;
		buffer = options.xml;
		if(typeof plugin_fn == 'object') {

			plugin = plugin_fn;
			params = options.options;

			//the plugin is attached to an elements trigger, no need to fire it.
			if(!CJAX.DOMContentLoaded && (options.event_element_id  || options.on)) {
				return plugin;
			}
			plugin_fn.fn(params['a'], params['b'], params['c'], params['d'], params['e'], params['f']);

			return plugin;
		}
		var plugins_dir = __base__+'plugins/';
		var path = plugins_dir+options.file;
		var extra = {};
		var file = options.file;

		var params = {};


		if(_extra = options.extra) {
			extra = CJAX.util.json(_extra);
		}

		if(options.options) {
			params = options.options;
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
					var events = CJAX.util.json(CJAX.xml('options', buffer));

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
				params : params,
				error: CJAX.error,
				success: function(m,s) {
					CJAX.message(m,s,'success');
				},
				warning : function(m,s) {
					CJAX.message(m,s,'warning');
				},
				info : function(m,s) {
					CJAX.message(m,s,'info');
				},
				message : CJAX.message,
				loading : CJAX.loading,
				trigger:CJAX.trigger,
				call : CJAX.call,
				controllers: 'controllers',
				post: CJAX.post,
				overlay: function(url, options) {
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
				$: CJAX.$,
				handler: function(handler, callback) {
					if(CJAX.debug) {
						console.log('Setting Handler..',handler);
					}
					//CJAX.found_extra_time += 100;
					return CJAX.setHandler(handler, callback);
				},
				isFn: CJAX.lib.isFn,
				load: CJAX.lib.loadCallback,
				payload: function(element, fn, expiry) {
					if(typeof  expiry == 'undefined') {
						var expiry = true;
					}
					CJAX.util.payload(element, expiry);
					CJAX.lib.loadCallback(element, fn);
				},
				queue: CJAX.util.queue,
				repeat: CJAX.repeat,
				ready: CJAX.ready,
				callback: function() {
					callbacks = CJAX.util.json(callbacks);

					for(event in callbacks) {
						for(x in callbacks[event]) {
							CJAX._process(callbacks[event][x]);
						}
					}
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
			window[plugin_name] = _new = new _plugin(buffer);
			//_new.fn.apply(window[plugin_name], Object.keys(params).map(function (key) {return params[key]}));
			if(!options.event_element_id && !options.on) {
				_new.fn(params['a'], params['b'], params['c'], params['d'], params['e'], params['f']);
			}
			if(CJAX.debug) {
				console.info('Running Plugin:', plugin_name);
			}
			return _new;
		}catch(e) {
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
					return CJAX.extend(fn, CJAX._plugins[plugin], callbacks);
				},seconds*1000);
			} else {
				return CJAX.extend(fn, CJAX._plugins[plugin], callbacks);
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
				var new_files = {};
				var payload = file.payload;
				var check = file.check;
				var last_number = CJAX.util.count(files) -1;

				for(var x in files) {
					new_files[x] = {};
					new_files[x].file = files[x];
					new_files[x].filename = files[x].replace(/.*\//, '');
				}

				if(check) {
					if(typeof check != 'object') {
						check = {0 : check};
					}
					for(var x in check) {
						if(new_files[x]) {
							if(window[check[x]]) {
								new_files[x].cancel = check[x];
							}
						}
					}
				}

				if(!file.callbacks) {
					if(file.callback) {
						new_files[last_number].callback = file.callback;
					}
				} else {
					for(x in file.callbacks) {
						new_files[x].callback = file.callbacks[x];
					}
				}

				if(payload) {

					var payloadHandler = function(pfile, cb) {
						var cbs = function () {
							load = {
								files: pfile,
								plugin: file.plugin
							};
							CJAX.script.load(CJAX.pBase+file.plugin+'/'+pfile, cb);
						};

						return cbs;
					};

					if(typeof payload != 'object') {
						payload = payload.split(',');
					}
					var new_callback = {};
					var pl = {};
					for (var x in payload) {
						if(typeof payload[x] != 'object') {
							pl = {
								file: payload[x],
								callback: null
							};
						} else {
							pl = payload[x];
						}
						new_file = pl.file.replace(/.*\//, '');
						CJAX.util.payload(new_file, true);
						new_callback[x] = payloadHandler(pl.file, pl.callback)
					}
					var old_cb = new_files[0].callback;
					new_files[0].callback = function () {
						for (x in new_callback) {
							new_callback[x]();
						}
						if (old_cb) {
							old_cb();
						}
					};
				}

				testFile = function(fileData) {
					var f =  fileData.file;
					var callback = fileData.callback;

					if(CJAX.util.payload(fileData.filename)) {

						if(callback) {
							CJAX.lib.loadCallback(fileData.filename, function(obj) {
								var call_number = 0;
								var calling = function () {
									setTimeout(function() {
										callback();
									},250);
								}
								try {
									calling();
								}catch(e) {
									if(call_number >= 10) {
										console.log('Giving up trying to load callback for', fileData.filename);
										return false;
									}
									console.log(call_number);
									call_number++;
									calling();
								}
							});
						}

						return false;
					}
					//is already loaded
					if(fileData.cancel) {
						if(file.debug) {
							console.info('Element importing was cancelled because it matches',fileDta.cancel,fileData);
						}
						if(callback) {
							callback();
						}
					} else {
						if (/^https?/.test(f)) {
							return CJAX.importFile(f, callback);
						} else if (file.plugin) {
							return CJAX.importFile(CJAX.pBase + file.plugin + '/' + f, callback);
						} else {
							return CJAX.importFile(f, callback);
						}
					}
				};
				for(xfile in new_files) {
					f = testFile(new_files[xfile]);
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
		if(typeof file == 'object') {
			var options = file;
			file = CJAX.pBase + options.file;
			CJAX._plugins[options.is_plugin] = options;
		}
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
	this.process		=		function( buffer , obj_buffer, caller, uniqid)
	{
		if(!CJAX.defined(caller)) {
			var caller = 'unknown';
		}
		if(!CJAX.is_cjax(buffer)) {
			alert('no cjax - caller: '+caller+'\n'+buffer);return false ;
		};

		CJAX._process(buffer, obj_buffer, caller, uniqid);
	};

	this._process		=		function(cache, caller)
	{
		var obj_buffer = cache;
		var xml_data = cache;

		if(typeof xml_data != 'object') {
			xml_data = CJAX.util.objectify(cache,'cjax');
		}
		CJAX.method = CJAX.get_function(cache);

		if(!CJAX.method) {
			console.warn('Not processed:', cache, xml_data,caller);
			return false;
		}
		var SUBFIX = CJAX.method;

		var seconds = 0;

		wait = CJAX._wait(xml_data);

		if(wait) {
			seconds = wait;
		} else {
			var seconds = xml_data.seconds;
			if(!seconds && CJAX.timer) {
				seconds = CJAX.timer;
			}
		}
		if(!CJAX.funtion_timer) {
			seconds = 0;
		}
		if(CJAX.debug && seconds) {
			console.log(CJAX.method ,"waits :",seconds,'caller:',caller);
		}


		//If it is a method
		if(CJAX[SUBFIX]) {

			try {
				switch(CJAX.method) {
					case '_fn':
						if(CJAX[cache.fn]) {
							SUBFIX = cache.fn;
						}
						break;
				}

				if(seconds){
					setTimeout(function() {
						CJAX[SUBFIX](xml_data, cache);
					},seconds);
				} else {

					fn = CJAX[SUBFIX];
					fn(xml_data, cache);
				}
			} catch( _e ) {
				console.error('#process unabled to load function#1: '+ CJAX.method+'();  '+_e.message, "\n", arguments.callee.caller.toString());
				alert('An error prevented last action. See console for details.');
			}
			return;
		} else {
			console.log(cache, xml_data, SUBFIX);
			alert("CJAX XML-Processor#1:"+SUBFIX+' function not found.');
		}
	};

	this.xml		=		function (start , buffer , loop , caller) {
		if(typeof buffer == 'object') {
			return buffer[start];
		}
		if(!buffer) return;
		if(loop == null) var loop = 0;
		if(typeof start=='undefined') return '';
		if(caller == null) var caller = 'unknown';
		if(!buffer || !start) return '';
		var real_var = start;
		var end = '</'+start+'>';
		start = '<'+start+'>';
		try {
			var loc_start = buffer.indexOf( start );
		} catch(e) {

			console.warn("CJAX: XML-tag"+start+" - '",buffer,"' is not valid xml source.\n", arguments.callee.caller.toString());
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

		var timeout, ms;
		var time_reset,not_wait;
		CJAX.funtion_timer = true;

		CJAX.funtion_timer = 0;

		if(typeof buffer == 'object') {

			timeout = buffer.timeout;
			ms = buffer.ms;//is milliseconds?
			time_reset = parseInt(buffer.time_reset);
			not_wait = buffer.no_wait;
		} else {

			timeout = CJAX.xml('timeout',buffer);
			ms = CJAX.xml('ms',buffer);//is milliseconds?
			time_reset = parseInt(CJAX.xml('time_reset',buffer));
			not_wait = CJAX.xml('no_wait',buffer);
		}

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
		data = data.replace(/<\\/gim, '<');
		data = data.replace(/\[nl\]/gim, "\n");


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


	this.prop			=		function(options) {
		if(options.options.b) {
			CJAX.$(options.options.b, function(elements) {
				for(var x in elements) {
					options.selector = elements[x];
					CJAX.property(options,options.xml);
				}
			});
		} else {
			if(!options.selector) {
				options.selector = CJAX.clicked;
			}
			return CJAX.property(options);
		}
	};


	this.swap			=		function(buffer, options)
	{
		var swap1 = options.options.a;
		var swap2 = options.options.b;
		var swap_type = options.options.c;

		switch(swap_type) {
			default:
			case 'class':

				CJAX.$('.'+ swap1, function(elements) {

					CJAX.$('.'+ swap2, function(elements2) {
						for(x in elements2) {
							elements2[x].setAttribute('class', swap1);
						}
					});

					for(x in elements) {
						elements[x].setAttribute('class', swap2);
					}
				});


		}
	};

	this.updateX		=		function(options) {

		var data = {};
		var dest_prop = options.options.b;
		var src_prop  = options.options.c;
		var selector  = options.selector;

		if(!src_prop) {
			src_prop = dest_prop;
		}

		CJAX.$(options.options.a, function(elements) {
			for(var x in elements) {

				if (selector.hasAttribute(src_prop)) {
					_value = selector.getAttribute(src_prop);
				} else {
					_value = selector[src_prop];
				}

				data.selector = elements[x];
				data.options = {};
				data.options.a = {};
				data.options.a[dest_prop] = _value;

				CJAX.property(data);
			}
		});
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
		var destination = buffer.url;
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

	this.on			=		function(options) {
		CJAX.callback[options.type] = function(response) {
			var new_event;
			for(option in options.options) {
				new_event = options.options[option];

				if(new_event.options) {
					new_event.options = CJAX.util.tag(new_event.options, '{response}', response);
				} else {
					new_event = CJAX.util.tag(new_event, '{response}', response);
				}

				if(new_event.is_plugin) {
					CJAX._extendPlugin(new_event.is_plugin, new_event);
				} else {
					CJAX._process(new_event);
				}

			}
		};
	};

	this._form		=		function( buffer , obj_buffer) {
		var selector;
		if(obj_buffer) {
			selector = obj_buffer.selector;
		}
		if(typeof buffer == 'object') {
			buffer = buffer.xml;
		}
		buffer = CJAX.decode(buffer);
		var url = CJAX.xml('url',buffer);
		var form_id = CJAX.xml('form_id',buffer);
		var args = CJAX.xml('args',buffer);
		var container = CJAX.xml('container',buffer);
		var text = CJAX._text =  CJAX.xml('text',buffer);
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

		url = CJAX._pharseValues(url, selector);

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
			//CJAX.files = CJAX._handleUploads(form, url, handlerFormRequest);
			if(url) {
				handlerFormRequest();
				CJAX.loading();
			}
		} else {
			if(url) {
				handlerFormRequest();

			}
		}
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
						response = CJAX.handlers._handlerRequestStatus(url, CJAX.HTTP_REQUEST_INSTANCE.status, {});
					} else{
						response = CJAX._handlerRequestStatus(url, CJAX.HTTP_REQUEST_INSTANCE.status,{});
					}
					if(CJAX._text) {
						CJAX.loading();
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
		vars = buffer.vars;
		if(vars) {
			CJAX.ajaxSettings.AjaxVars = vars;
		}
	};

	this.$					=		function(element_id, callback) {
		if(!element_id) {
			return;
		}
		if(typeof element_id =='object') {
			if(callback) {
				CJAX.util.applySelector(element_id,callback);
			}
			return element_id;
		}

		if(element_id=='body') {
			return CJAX.elem_docs( 'body' )[0];
		}
		if(element_id=='head') {
			return CJAX.elem_docs( 'head' )[0];
		}


		if(/[^a-zA-Z0-9_\-]/i.test(element_id)) {

			if(CJAX.lib.isFn(callback)) {
				return CJAX.util.applySelector(element_id,callback);
			} else {
				element_id = element_id.replace(/^\#/,'');
				if(item = CJAX.is_element(element_id) ) {
					if(CJAX.debug) {
						console.log('in sizzle context, no callback.',element_id, ' is_element fallback.');
					}
					return item;
				}
				console.log('Invalid Element ID:', element_id, callback);
			}
			return false;
		}
		if(CJAX.lib.isFn(callback)) {
			return callback({ 0: CJAX.is_element(element_id)})
		}
		return CJAX.is_element(element_id);
	};

	/**
	 * return an element object can pass an string as id or an object
	 **/
	this.is_element			=			function(id_obj, verbose) {
		if(typeof id_obj == 'object') {
			return id_obj;
		}
		if(CJAX.debug) { verbose = true; }

		var elem = document.getElementById(id_obj);

		if(typeof id_obj == 'undefined' || id_obj===null) {
			console.warning('Element '+id_obj+' not found');
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
	this.call			=		function(options, options2)
	{
		if(typeof options !='object') {
			var url = options;
			options = {};
			options.url = url;
			for(x in options2) {
				options[x] = options2[x];
			}
		}
		var controller = options.url.replace(/\/.+/g,'').replace(/^.+\?/,'');


		options.controller = controller

		var settings = controller.split(':');
		if(settings.length > 1) {
			CJAX.ajaxSettings.dataType = settings[1];
		}

		return CJAX._call(options,options2);
	};

	/**
	 * call:
	 * url,rel,confirm
	 */
	this._call		=		function( xcache ) {
		var selector;
		var cache = xcache;
		if(typeof xcache != 'object' || xcache.cjax) {
			cache = CJAX.util.objectify(xcache, 'cjax');
		}
		if(!cache.callback) {
			cache.callback = {};
		}

		selector = cache.selector;

		var options = {};
		if(cache.options) {
			options = cache.options;
		}

		var msg = null, x, response;

		var url = cache.url;
		url = url.replace(/\&amp\;/gi,"&");

		var _confirm = CJAX.decode(cache.confirm);
		var crossdomain = cache.crossdomain;

		var is_loading  =  cache.is_loading;
		if(!is_loading) is_loading = false;

		var text = cache.text;
		if( !text || text==1) {
			text = 'Loading...';
		}
		if(text =='no_text') {
			text = null;
		}
		if(CJAX.text) {
			text = CJAX.text;
		}

		var container_id =  cache.container_id;

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
				if(!window.confirm(CJAX.decode(_confirm))) {
					CJAX.$('cjax_overlay').style.display = 'none';
					return true;
				}
			}
			CJAX.$('cjax_overlay').style.display = 'none';
		}

		url = CJAX._pharseValues(url, selector);

		if(CJAX.ajaxSettings.stop) {
			CJAX.ajaxSettings.stop = false;
			return true;
		}

		var is_post  = cache.post? cache.post:'';
		var args = cache.args;

		if(args) {
			CJAX.IS_POST = true;
		}

		if(container_id) {
			var container = CJAX.is_element( container_id ,false);
			if( !container ) {
				alert("CJAX Error: container "+container_id+ " not found");
				return false;
			}
		}

		if(CJAX.ajaxSettings.cache || options.cache) {

			if(cached_data = CJAX.util.cachedURL(url)) {

				var new_response = cached_data.response;
				CJAX.ajaxSettings.cache = false;

				if(cached_data.dataType == 'json' || options.dataType == 'json') {
					new_response = CJAX.util.jsonEval(new_response);
				} else {
					CJAX.process_all(new_response);
				}

				if(cache.callback) {
					cache.callback.success(new_response);
				}

				if(CJAX.callback.success) {
					CJAX.callback.success(new_response);
				}
				if(CJAX.callback.complete) {
					CJAX.callback.complete(new_response);
				}

				return new_response;
			}
		}

		if(CJAX.ajaxSettings.cache || options.cache) {
			var cached_state = CJAX.util.cachedState(url)

			if(cached_state) {
				//the first call to be cached is in progress, but
				//an action occured to process that same call again
				//and the first call is not completed, and it hasn't been cached
				//this calcels out these extra calls, until the first call is completed
				console.log(cached_state);
				return true;
			}
			CJAX.util.cacheState(url, {message: 'in_progress'});
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

		var full_url = CJAX._handleRequestHeaders(url, args);

		try {
			if(CJAX.debug) {
				console.log("Waiting for response..");
			}
			CJAX.HTTP_REQUEST_INSTANCE.onreadystatechange = function () {
				if(CJAX.HTTP_REQUEST_INSTANCE.readyState) {
					if(CJAX.HTTP_REQUEST_INSTANCE.readyState < 4) {
						CJAX.util.cacheState(url, {readyState: CJAX.HTTP_REQUEST_INSTANCE.readyState});
					} else {
						CJAX.loading();
						response = CJAX._handlerRequestStatus(url, CJAX.HTTP_REQUEST_INSTANCE.status , cache, container);

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

	this.get		=		function($url , callback, dataType) {
		var options = {};

		if(typeof $url == 'object') {
			options = $url;
			$url = options.url;
		}
		options.callback = {};
		options.options = {};
		dataType = dataType? dataType : CJAX.ajaxSettings.dataType;

		if(callback) {

			if(!CJAX.lib.isFn(callback)) {
				options.options.dataType = callback;
			}
			options.callback.success = callback;

			options.options.dataType = dataType;
		}
		options.url = $url;
		if(/^https?/.test(options.url)) {
			options.crossdomain = true;
		}

		CJAX.IS_POST = false;
		return CJAX.call(options);
	};

	this._handleRequestHeaders		=		function(url,args)
	{
		if(!CJAX.HTTP_REQUEST_INSTANCE) CJAX.HTTP_REQUEST_INSTANCE = CJAX.AJAX();
		if (!CJAX.IS_POST && url.length < 1200) {
			//reset instance
			CJAX.HTTP_REQUEST_INSTANCE.onreadystatechange = function () {};
			CJAX.HTTP_REQUEST_INSTANCE.open ('GET', url);
			full_url = url;
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
		CJAX.HTTP_REQUEST_INSTANCE.setRequestHeader('X-Requested-With', 'CJAX FRAMEW0RK');

		return  full_url;
	};

	this._handlerRequestStatus		=		function(url, status, cache , container)
	{
		CJAX.default_timeout = 5;
		var response =  CJAX.HTTP_REQUEST_INSTANCE.responseText;

		if(!cache.callback) {
			cache.callback = {};
		}
		if(!cache.options) {
			cache.options = {};
		}

		var dataType = cache.options.dataType;

		if(!dataType) {
			dataType = CJAX.ajaxSettings.dataType;
		}

		CJAX.util.cacheURL(url,response, dataType);
		CJAX.util.cacheState(url, {status: status});

		var error_msg;
		switch(status)
		{
			case 200: {

				switch(dataType) {
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

				if(cache.callback.success) {
					cache.callback.success(response);
				} else if(CJAX.callback.success && typeof CJAX.callback.success=='function') {
					CJAX.callback.success(response);
				}

				if(CJAX.callback.complete && typeof CJAX.callback.complete=='function') {
					CJAX.callback.complete(response);
				}

			}
				break;
			case 400:
				error_msg = 'Error: The server returned a "Bad Request" status message 400.';
				break;
			case 403:
				error_msg = 'Error: Access to this request is forbidden';
				break;
			case 404:
				error_msg = 'CJAX Error: File not found '+url;
				if( container ) {
					if(!container.type) { alert('_call: container type is'+ container + error_msg ); return false; }
				}
				if(url.indexOf('ajax.php')==-1) {
					CJAX.error('Error: File not found '+url);
				} else {
					CJAX.message();
				}
				break;
			case 405:
				error_msg = 'Error: The server returned a "Methods not allowed" status message 405.';
				break;
			case 414:
				error_msg = 'Error: the data sent was too large.';
				break;
			case 500:

				error_msg = 'Error: The server encountered an unexpected Error with status 500. See server log for details.';

				break;
			case 503:
				error_msg = 'Error: Gateway timeout.';
				break;
			case 0:
				CJAX.message();
				error_msg = 'Request Status: 0. None http protocol.';
				break;
			default:
				error_msg = 'Error: Server responded with a unsual response, see available server error logs for details.';
				break;
		}
		if(CJAX.callback['error'+status] && typeof CJAX.callback['error'+status]=='function') {
			CJAX.callback['error'+status](this,response, error_msg, status);
		}
		if(error_msg) {
			if(CJAX.callback.error && typeof CJAX.callback.error=='function') {
				CJAX.callback.error(response, error_msg, status);
			}
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

	this.message	=	function(message, seconds, message_type) {
		var type_class = '';
		if(message_type) {
				type_class = ' cjax_'+message_type;
		}
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
				message: "<data><div class='cjax_message cjax_message_type"+type_class+"'>"+message+"</div></data>",
				time : seconds
			};
		}
		CJAX._message(options);
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

	/**
	 * Pharse url elements values passed in vertical bars
	 */
	this._pharseValues		=	function(url, selector)
	{
		if(undefined == url) {
			return '';
		}
		var v = url.match(/\|[^\|\|]*\|/g);

		try {
			for(x in v) {
				id = v[x].replace(/\|/g,'');

				if(CJAX.intval(id)) {
					_value = id;
				} else {
					var use_fns = false;

					if(selector && (id.indexOf('.')!=-1 || id.indexOf('function')!=-1)) {
						var data = id.split('.');
						switch(data[0]) {
							case 'this':
								_value = selector[data[1]];
								break;
							case 'data':
								_value = CJAX.decode(selector.getAttribute('data-'+data[1]));
								break;
							default:
								var fn = CJAX.lib.pharseFunction(data[0]);
								if(CJAX.lib.isFn(fn)) {
									_value = fn();
								}
						}
					} else {
						if(id.indexOf(':') !=-1) {
							use_fns = true;
							fns = id.split(':');
							id = fns[0];
							element = CJAX.$(id);
						} else {
							element = CJAX.$(id);
						}
						if(!element) {
							_value = id;
						} else {

							switch (element.type) {
								case 'checkbox':
									_value = element.checked ? 1 : 0;
									break;
								case 'radio':
									var radios = document.getElementsByName(id);
									if (radios) {
										var element;
										var check = '';

										for (var i = 0; i < radios.length; i++) {
											element = radios[i];
											if (element.checked) {
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
		__base__ = CJAX.base = CJAX.dir = CJAX.util.get.basepath()+'/';
		__root__ = CJAX.util.get.dirname(__base__,3)+'/';
		CJAX.f = __root__+'ajax.php';

		CJAX.setHandler('handlerRequestStatus', CJAX._handlerRequestStatus);


		CJAX.util.payload('sizzle.js', 10000);

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
			var el;
			if(e==null) {
				el = event.srcElement;
			} else {
				el = e.target;
			}
			CJAX.clicked = el;
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

		var completed = function() {
			CJAX.DOMContentLoaded = true;
			var data;
			for(var x in CJAX._Ready) {
				data = CJAX._Ready[x];
				if(data.element === true) {
					CJAX.repeat(data.fn(data.element),400,20);
				} else {
					data.fn(data.element);
				}
			}
		};

		r = function(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}
		r(completed);
	};

	this.repeat		=		function(fn, internal, times) {
		if(typeof internal == 'undefined') {
			var internal = 100;
		}
		if(typeof times == 'undefined') {
			var times = 15;
		}
		var tried = 0;
		var trying = function() {
			setTimeout(function() {
				fn();
			}, internal)
		};
		try {
			trying();
		} catch(e) {
			if(tried >= times) {
				console.warn('Gave up on', fn, fn.toSource());
				return false;
			}
			trying();
		}
	};

	this.ready		=		function(fn, obj) {
		if(!CJAX.lib.isFn(fn)) {
			if(CJAX.debug) {
				console.log(fn, 'is not a function');
			}
			return;
		}
		if(CJAX.DOMContentLoaded) {
			switch(typeof obj) {
				case 'number':
					CJAX.repeat(fn, obj, 20);
					break;
				case 'boolean':
					CJAX.repeat(fn, 400, 20);
					break;
				default:
					fn.call(this,obj);
			}
		} else {
			CJAX._Ready[CJAX.util.count(CJAX._Ready) + 1] = {
				fn: fn,
				element: obj
			};
		}
	};

	this.onStartEvents		=		function() {
		CJAX.importFile(__base__+'core/css/cjax.css');
		CJAX.importFile(__base__+'lib/sizzle.js');
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