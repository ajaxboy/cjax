/**
 * Plugin Ajax Uploader 1.3
 * @author cj
 */

function uploader(a,b,c)
{
	this.callback(false);
	
	var handler,version;
	//backward compatibility with pre-5.3
	version = CJAX.version.replace(/[^0-9\.].*/,'');
	
	if(parseFloat(version) < 5.3) {
		handler = 'handlerFileupload';
	} else {
		handler = 'fileupload';
	}
	
	var options = this;
	
	
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
	this.handler(handler, function(form, url, $callback) {
		var count = 0;
		for(var i = 0; i < form.length; i++) {if(form[i].type=='file') {if(form[i].value) {count = true;break;}}}
		if(!count) {//no files
			if(options.no_files) {
				CJAX.warning(CJAX.decode(options.no_files));
			} else {
				CJAX.message();
			}
			return false;
		}
		
		iframe = CJAX.create.frame('frame_upload');
		if(!options.show_iframe) {
			iframe.style.display = 'none';
		}
		iframe.width = '400';
		iframe.height = '200';
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
		
		with(form) {
			method = 'POST';
			action = uploader.ajaxFile+'?controller=uploader&function=upload&cjax_iframe=1';
			enctype = "multipart/form-data";
			target = iframe.name;
		}

		form.submit();
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
				}, 100)
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
		return iframe;
	});
	
}
