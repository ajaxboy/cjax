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
 * @param containers array
 * @param options array
 * @param events array
 * by Ordland Euroboros
 * 
 */

CJAX.importFile(CJAX.pBase + 'dracula/dragula-3.6/dragula.min.css');

function dracula(containers, options, events){

    function getElementsOrders(containers){
        elementsOrders = {};
        for(var container in containers){
            containerId = containers[container];
            elementsOrders[containerId] = [];
            elements = document.getElementById(containerId).childNodes;
            for(var element in elements){
                elementId = elements[element].id;
                if(elementId){
                    elementsOrders[containerId].push(elementId);
                }
            }            
        }
        return elementsOrders;
    }

    length = Object.keys(containers).length;
    for(var i = 0; i < length; i++){   
        if(typeof containers[i] === 'string') {
            containers[i] = [containers[i]];
        }

 	    drake = dragula(Object.keys(containers[i]).map(function(container) {
            return document.getElementById(containers[i][container]);
        }), options[i]);  
       
        if(events[i]) {
            for(var eventName in events[i]) {
                var eventHandler = events[i][eventName];
                if(eventHandler.indexOf("function") > -1) {
                    eventHandler = eval("event = " + eventHandler);
                }

                if(typeof eventHandler === "function") {
                    drake = drake.on(eventName, eventHandler); 
                }
                else if(typeof eventHandler === "string"){ 
                    var url = eventHandler.replace(/\/+$/,"");
                    (function(index){ 
                        drake = drake.on(eventName, function(el){
                            document.cookie = "dragulaorders=" + JSON.stringify(getElementsOrders(containers[index])) + "; expires=" + 
                                                      new Date(Date.now() + 3600000).toGMTString() + "; path=/; domain=." + document.domain;
                            CJAX.get(url + '/' + el.id + '/');
                        });                             
                    })(i);                             
                } else{
                    throw new Exception("Invalid Event Handler specified.");
                }              
            }
        }
    }	
}