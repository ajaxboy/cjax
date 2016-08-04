/**
 * autocomplete 1.1
 *
 * Auto Complete Plugin for Cjax
 */

//allows to import these files before the plugin is ran.


CJAX.importFile({
	files: 'css/style.css,helper.js',
	plugin:'autocomplete',
	callback: function() {
		var element = CJAX.xml('element_id',CJAX._plugins['autocomplete']);
		AC.init(element);
	}
});

function autocomplete(url , fulll_load, limit)
{
	CJAX.ajaxSettings.cache = true;

	var element = CJAX.$(CJAX.xml('element_id',CJAX._plugins['autocomplete']));
	var str = element.value;
	if(str == '') {
		//nothing typed in
		return true;
	}

	url = url.replace(/\/+$/,"");//remove any slashes at the end

	if(fulll_load) {

		element.setAttribute('disabled','disabled');
		autocomplete.get(url, function(data) {
			element.removeAttribute('disabled');

			limit = limit? limit: 15;

			//convert json into js array
			new_data = Object.keys(data).map(function (key) {return data[key]})
			//search string
			new_data  = new_data.filter(/./.test.bind(new RegExp(str,'i')));

			//how many records
			new_data = new_data.slice(0, limit)

			if(new_data) {
				AC.refresh(new_data, element);
			}
		},'json');
	} else {

		this.get(url+='/'+str, function(data) {
			if(data) {
				AC.refresh(data, element);
			}
		},'json');
	}
}