/**
 * Plugin 1.3;
 * @author cj
 */


function uploader(a,b,c)
{
	this.callback(false);
	
	var options = a;

	var iframe = CJAX.create.frame('frame_upload_'+options.instance_id);

	if(!options.show_iframe) {
		iframe.style.display = 'none';
	}

	if(!options.use_debug) {
		options.use_debug = new String('');
	}

	var attachForm = function(form, iframe) {
		form.appendChild(iframe);

		if(typeof a=='object') {
			for(x in a) {
				extra = document.createElement('input');
				extra.type = 'hidden';
				extra.name = 'a['+x+']';
				extra.value = a[x];
				form.appendChild(extra);
			}
		}
		uploader.form = form;


		var new_url = uploader.ajaxFile+'?controller=uploader&function=upload&cjax_iframe=1&use_debug='+
			options.use_debug+'&instance_id='+options.instance_id;

		new_url = CJAX._pharseValues(new_url);

		with(form) {
			method = 'POST';
			action = new_url;
			enctype = "multipart/form-data";
			target = iframe.name;
		}
	};


	iResponse	=	function(iframe) {
		uploader.load(iframe, function() {
			_fn = function(data) {
				CJAX.process_all(data);
				if(url) {
					$callback(false);
				}
			};

			_wait = function () {
				setTimeout(function() {
					if(typeof iframe.contentWindow.body != 'undefined') {
						response = iframe.contentWindow.document.body.innerHTML;
						if(response) {
							_fn(response);
						}
						if(url) {
							$callback(false);
						}
					} else {
						_wait();
					}
				}, 200)
			};
			try {
				if(iframe.contentWindow.document.URL=="about:blank") {
					_wait();
				} else {
					response = iframe.contentWindow.document.body.innerHTML;
					if(response) {
						_fn(response);
					}
				}
			} catch(e) {
				_wait();
			}
		});
	}



	var timeouts = {};
	var done = {};


	uploader.ready(function() {

		var selector = '.files';
		if(options.selector) {
			selector = options.selector;
		}

		uploader.$(selector, function(files) {

			fn = function (file, x) {
				timeouts[x] = setInterval(function () {

					if(typeof file.files[0] !='undefined') {

						if (file.files.length) {

							//clearInterval(timeouts[x]);
							attachForm(file.form, iframe);
							iResponse(iframe);
							file.form.submit();
							file.value = '';
						}
					}
				},1000);
			};
			for (var x in files) {
				fn(files[x], x);
			}
		});
	},1000);


	/**
	 * Upload Handler
	 * 
	 * This handler is fired acter the form ajax request settings are settle but before the request is fired.
	 * The request is passed on $callback function, we trigger if there is a url after the files are uploaded.
	 * 
	 * form - is the form being submitted
	 * url - the url where the form is going
	 * $callback - form ajax request callback to fire after the files are uploaded.
	 */
	this.handler('handlerFileupload', function(form, url, $callback) {

		var count = 0;
		var items = {};
		for(var i = 0; i < form.length; i++) {if(form[i].type=='file') {
				if(form[i].value) {
					count = true;break;
				}
			}
		}

		if(!count) {//no files
			if(options.no_files) {
				CJAX.warning(CJAX.decode(options.no_files));
			}
			return false;
		}
		

		form.submit();

		iResponse(iframe);
		return iframe;
	});
	
}
