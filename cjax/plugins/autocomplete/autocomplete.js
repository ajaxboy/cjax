/**
 * autocomplete 1.2
 *
 * Auto Complete Plugin for Cjax
 */

//allows to import these files before the plugin is ran.


CJAX.importFile({
	files: 'helper.js,css/style.css',
	plugin:'autocomplete',
	callbacks: {
		0: function() {
			var element = CJAX._plugins['autocomplete'].element_id;

			autocomplete.ready(function() {
				AC.init(element);
			});

		}
	}
});

function autocomplete(url , fulll_load) {
	version = CJAX.version.replace(/[^0-9\.].*/, '');

	CJAX.ajaxSettings.cache = true;

	var element = CJAX.$(CJAX._plugins['autocomplete'].element_id);
	var str = element.value;

	url = autocomplete.url = url.replace(/\/+$/, "");//remove any slashes at the end

	if (str) {

		this.ready(function() {
			//executes until helper.js if fully loaded.
			autocomplete.load('helper.js', function() {

				if (fulll_load) {

					var limit = 10;

					//element.setAttribute('disabled','disabled');
					CJAX.info('Loading Image List..', 30)
					autocomplete.get(url, function (data) {
						//element.removeAttribute('disabled');
						CJAX.message();

						//convert json into js array
						new_data = Object.keys(data).map(function (key) {
							return data[key]
						})
						//search string
						if (str.length == 1) {
							str = '^' + str;
						}
						new_data = new_data.filter(/./.test.bind(new RegExp(str, 'i')));

						//how many records
						new_data = new_data.slice(0, limit)

						if (new_data) {
							AC.refresh(new_data, element);
						}
					}, 'json');
				} else {

					autocomplete.get(url += '/' + str, function (data) {
						if (data) {
							AC.refresh(data, element);
						}
					}, 'json');
				}
			});
		});
	}
}