
/**
 * Plugin: //@validate;
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

CJAX.importFile({
	files: 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js',
	plugin:'validate',
	check: 'jQuery',
	payload: 'jquery.validate.min.js'
});

function validate(btn_id, url, fields)
{
	if(!btn_id) {
		console.error('Validate: Empty Submit Button');
		return;
	}

	/**
	 * uploadify jquery plugin was not detected, so we will try to load it automatically
	 */
	this.queue('jquery.validate.min.js',function() {

		if(!fields) {
			//an array was not passed.
			var fields = validate.params.c;
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
					if(CJAX.callback.validate) {
						CJAX.callback.validate.call();
					}
				} else {
					if(CJAX.callback.validate) {
						CJAX.callback.validate.call();
					}
					postCallback(validate.buffer);
				}
			};
		}


		var val = form.validate({
			errorElement: (fields.errorElement? fields.errorElement: "div"),
			invalidHandler: _invalidHandler,
			submitHandler: _submitHandler,
			rules: fields.rules,
			messages: fields.messages
		});
	});
}