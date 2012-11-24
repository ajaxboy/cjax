/**
 * autocomplete 1.0
 * 
 * Auto Complete Plugin for Cjax
 */

//allows to import these files before the plugin is ran.



CJAX.importFile({
	files: 'css/style.css,helper.js',
	plugin:'autocomplete',
	callback: function() {
		AC.init(CJAX.xml('element_id',CJAX._plugins['autocomplete']));
	}
});


function autocomplete(url)
{
	version = CJAX.version.replace(/[^0-9\.].*/,'');
	
	if(parseFloat(version) < 5.3) {
		alert('Sorry, Autocomplete Plugin requires Cjax 5.3 or greater.');
		
		//return this.clear();//remove keyup event only in > 5.3
		return CJAX._EventCache.flushElement(this.element); ////remove keyup event
	}
	
	CJAX.ajaxSettings.cache = true;
	
	url = url.replace(/\/+$/,"");//remove any slashes at the end
	
	this.get(url+'/'+this.element.value+'/', function(data) {
		if(data) {
			AC.data = data;
		}
	},'json');
}