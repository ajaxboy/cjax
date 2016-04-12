
/**
 * Plugin: validate 1.6
 * Dependencies: Cjax 4.3+, Jquery, jquery.validate
 * 
 * Ref:
 * 
 * http://docs.jquery.com/Main_Page
 * http://docs.jquery.com/Plugins/Validation
 * 
 * http://code.google.com/p/cjax
 * http://code.google.com/p/ajax-framework-for-codeigniter
 * 
 * @param form_id string
 * @param fields Json Object
 */


function validate(btn_id, url, fields)
{
	if(typeof jQuery  =='undefined') {
		CJAX.error('Validate Plugin requires Jquery library.');
		//jquery was not found
		return;
	}
	if(!btn_id) {
		return console.error('Validate: Empty Submit Button');
	}
	if(typeof $.validator =='undefined') {
		/**
		 * uploadify jquery plugin was not detected, so we will try to load it automatically
		 */
		CJAX.importFile(this.base+'jquery.validate.min.js',function() {
			
			if(typeof $.validator !='undefined') {
				plugin = CJAX.plugins['validate'];
				params = plugin.params;
				
				//call this plugin recursively
				return plugin.fn(params['a'],params['b'],params['c'],params['d'],params['e'],params['f']);
			} else {
				CJAX.error('CJAX: Validate Plugin requires validate Jquery plugin.');
			}
		});
		return;
	}

	if(!fields) {
		//an array was not passed.
		var fields = {};
	}
	//get form
	var form = $('#'+btn_id).closest('form');
	
	//prevent request or api and returns it  in a function
	var callback = this.callback;
	
	function postCallback(buffer)
	{
		var postCallback = CJAX.decode(CJAX.xml('postCallback',buffer));
		
		if(!postCallback) {
			return true;
		}
		postCallback = CJAX.util.json(postCallback);
		CJAX.process_all(postCallback,postCallback);
	}
	
	if(typeof fields.invalidHandler !='function') {
		_invalidHandler =  function(form, validator) {};
	}
	if(typeof fields.submitHandler !='function') {
		_submitHandler =  function(form) {
			if(url) {
				CJAX.ajaxSettings.success = function() {
					postCallback(validate.buffer);
					CJAX.ajaxSettings.success = null;
				};
				callback();
			} else {
				setTimeout(function() {
					callback();
				}, 300);
				postCallback(validate.buffer);
				
				
			}
		};
	}
	
	$(document).ready(function() {
		var val = $(form).validate({
			errorElement: (fields.errorElement? fields.errorElement: "div"), 
			invalidHandler: _invalidHandler,
			submitHandler: _submitHandler,
			rules: fields.rules,
			messages: fields.messages
		});
	});
	
}