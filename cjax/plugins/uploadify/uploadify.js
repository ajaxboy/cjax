/**
 * Uploadify  //@uploadify;
 * 
 * Dependencies: Cjax 5.0+, Jquery, jquery.uploadify
 * 
 * Ref:
 * 
 * http://www.uploadify.com/documentation/
 * http://code.google.com/p/cjax
 * http://cjax.sourceforge.net
 * 
 * by Cj Galindo
 * 
 */

CJAX.importFile({
	files: 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js,uploadify-3.2/uploadify.css',
	plugin:'uploadify',
	check: 'jQuery',
	payload: 'uploadify-3.2/jquery.uploadify.js'
});

function uploadify(upload_id, options, session_id) 
{
	var base = this.base;

	options.formData   = {'session_id' : session_id};// need this to communicate with the flash uploader
	
	if(options.checkExisting) {
		options.checkExisting = this.ajaxFile+'?uploadify/fileExists';//base+options.checkExisting;
	}
	if(!options.swf) {
		options.swf = base+'uploadify-3.2/uploadify.swf';
	}
	if(!options.uploader) {
		options.uploader = this.ajaxFile+'?uploadify/upload';
	}
	if(!options.buttonImage) {
		options.buttonImage = base+'uploadify-3.2/browse-btn.png';
	}
	
	if(!/[^a-zA-Z0-9_]/.test(upload_id)) {
		upload_id = '#'+upload_id;
	}
	
	this.queue('jquery.uploadify.js', function() {
		$(upload_id).uploadify(options);

	});
}