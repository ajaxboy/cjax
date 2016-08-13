
var autoCompleteHelper = {};
autoCompleteHelper = function() {
	this.minChars = 1;
	this.field = null;
	this.item_id = 0;
	this.helper = null;
	this.helperContent = "";
	this.data = [];
};
autoCompleteHelper.prototype = {
	init:function(idOfTheField) {
		this.field = CJAX.$(idOfTheField);
		if(!this.field) {
			alert('Element #'+idOfTheField+' was not found.');
		} else {
			this.createHelper();
			this.field.onblur = this.onFieldOut;
		}
	},
	refresh: function(data, element) {
		var list = new String('');


		if(element.value.length >= this.minChars) {

			for (x in data) {
				list += '<a class=\'ACOption\' href="javascript:AC.select(\'' + data[x] + '\',\'' + x + '\');">' + data[x] + '</a>';
			}
		}

		this.helper.innerHTML = list;
		this.showHelper();
		this.positionHelper();
	},
	element: function(element) {
		if(this.field !=element) {
			AC.init(element.id);
			this.field = element;
			this.field.onfocus = this.onFieldIn;
			this.field.onblur = this.onFieldOut;
		}
	},
	onFieldIn:function() {
		//AC.loop();
	},
	onFieldOut:function() {
		clearTimeout(AC.item_id);
		setTimeout("AC.hideHelper()", 120);
	},
	select:function(item, id) {
		this.field.value = item;
		this.hideHelper();

		var params = CJAX._plugins.autocomplete.options;
		if(params.c && typeof params.c == 'string') {
			if(params.d) {
				switch(params.d) {
					case 'id':
						item = id;
				}
			}

			CJAX.ajaxSettings.cache = true;
			autocomplete.get(params.c + '/' + item);
		}
	},
	// helper
	createHelper:function() {
		this.helper = document.createElement("div");
		this.helper.style.width = (this.field.offsetWidth - 22) + "px";
		this.helper.setAttribute("id", "helper");
		this.helper.innerHTML = "";
		document.body.appendChild(this.helper);
		this.positionHelper();
		//this.hideHelper();
	},
	positionHelper:function() {
		var position = {x:0, y:0};
		var e = this.field;
		while(e) {
			position.x += e.offsetLeft;
			position.y += e.offsetTop;
			e = e.offsetParent;
		}
		this.helper.style.left = position.x + "px";
		this.helper.style.top = (position.y + this.field.offsetHeight)+ "px";
	},
	showHelper:function() {
		this.helper.style.display = "block";
	},
	hideHelper:function() {
		setTimeout(function() {
			this.helper.style.display = "none";
		}, 20);
	}
};

var AC = new autoCompleteHelper();