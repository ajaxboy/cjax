/**
 * 
 */


var autoCompleteHelper = {};
autoCompleteHelper = function() {
	this.minChars = 2;
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
			this.field.onfocus = this.onFieldIn;
			this.field.onblur = this.onFieldOut;
		}
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
		AC.loop();
	},
	onFieldOut:function() {
		clearTimeout(AC.item_id);
		setTimeout("AC.hideHelper()", 120);
	},
	loop:function() {
		var list = "";
		var value = AC.field.value;
		var data = AC.data;
		
		if(value.length >= this.minChars) {
			for(x in data) {
				if(value.toLowerCase() == data[x].substr(0, value.length).toLowerCase()) {
					list += '<a href="javascript:AC.select(\'' + data[x] + '\');">' + data[x] + '</a>';
				}
			}
		}
		if(list != "") {
			if(this.helperContent != list) {
				this.helperContent = list;
				this.helper.innerHTML = this.helperContent;
			}
			this.showHelper();
		} else {
			this.hideHelper();
		}
		AC.item_id = setTimeout("AC.loop()", 200);
	},
	select:function(country) {
		this.field.value = country;
		this.hideHelper();
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
		this.helper.style.display = "none";
	}, 
	data: function() {
		
	}
};

var AC = new autoCompleteHelper();