
/**
 * Dragula  dragula 1.0
 * 
 * Dependencies: Cjax 6.0+, Dragula
 * 
 * Ref:
 * 
 * https://github.com/bevacqua/dragula
 * http://code.google.com/p/cjax
 * http://cjax.sourceforge.net
 * 
 * @param containers string|array
 * @param options array
 * @param events array
 * by Ordland Euroboros
 * 
 */

function dragula(containers, options, events){

    if(typeof containers === 'string') {
        containers = [containers];
    }
	
    function getElementsOrders(containers){
        return {"container1": ["element1", "element2", "element3"],
                "container2": ["element4", "element5", "element6"]};
    }
    
	(function() {
        var val = dragula(containers.map(function(container) {
            return document.getElementById(container);
        }), options);
        
        if(events) {
            for(var eventName in events) {
                var eventHandler = events[eventName];
                if(typeof eventHandler === "function") {
                    val = val.on(eventName, eventHandler);  
                }
                else if(typeof eventHandler === "string"){
                    var url = eventHandler.replace(/\/+$/,"");
                    document.cookie = "dragulaorders=" + getElementsOrders(containers) + "; expires=" + new Date(Date.now() + 3600000).toGMTString() + "; path=/; domain=." + document.domain;
                    val = val.on(eventName, function(){
                       	this.get(url);
                    });                                  
                } else{
                    throw new Exception("Invalid Event Handler specified.");
                }               
            }
        }
	});
	
}