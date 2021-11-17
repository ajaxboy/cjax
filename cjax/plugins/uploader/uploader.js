/**
 * Plugin 1.4;
 * @author cj
 */


function uploader(a,b,c)
{
	this.callback(false);

	var options = a;

	var iframe = CJAX.create.frame('frame_upload_'+options.instance_id);

	iframe.style.display = 'none';
	if(options.show_iframe) {
		iframe.style.display = 'block';
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

		var file = uploader.ajaxFile;
		if(options.path) {
			file = options.path+'ajax.php';
		}
		var new_url = file+'?controller=uploader&function=upload&cjax_iframe=1&use_debug='+
			options.use_debug+'&instance_id='+options.instance_id;

		new_url = CJAX._pharseValues(new_url);

		with(form) {
			method = 'POST';
			action = new_url;
			enctype = "multipart/form-data";
			target = iframe.name;
		}
	};


	iResponse	=	function(iframe,form) {
		uploader.load(iframe, function() {
			_fn = function(data) {
				CJAX.process_all(data);
				if(options.debug || options.log) {
					console.log('-------------Uploader Debug Details---------------------');
					console.log('URL: ', form.action);
					console.info('Response: ', data);
					console.info('Response Commands: ', CJAX.commands);
					console.info('Options: ', options);
				}
				if(url) {
					$callback(false);
				}
			};

			_wait = function () {

				CJAX.repeat(function() {
					if(typeof iframe.contentWindow.body != 'undefined') {
						response = iframe.contentWindow.document.body.innerHTML;
						if(response) {
							_fn(response);
						}
						if(url) {
							$callback(false);
						}
					}
				}, 200);
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
	options.data = {};


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

							attachForm(file.form, iframe);
							iResponse(iframe,file.form);
							file.form.submit();
							file.value = '';
						}
					}
				},1000);
			};
			for (var x in files) {

				/*
				 Pass file inline-data
				 */
				var items = [].filter.call(files[x].attributes, function(at) { return /^data-/.test(at.name); });
				if(items) {
					for(item in items) {
						item_name = items[item].name.split('-');
						extra = document.createElement('input');
						extra.type = 'hidden';
						extra.name = 'data['+item_name[1]+']['+ x +']';
						extra.value = CJAX._pharseValues(items[item].nodeValue);
						files[x].form.appendChild(extra);
					}
				}

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
