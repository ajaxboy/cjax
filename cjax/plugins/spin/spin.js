/**
 * Cjax plugin spin v1.0
 */
CJAX.importFile({
    //list of files to load separated by comma, can use relative path to this plugin
    files: 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js,css/simpletextrotator.css,css/elusive-webfont.css',
    plugin:'spin', // this plugin's name
    check : 'jQuery', //check if this Object exists, it quits loading it if it does
    payload:'js/jquery.simple-text-rotator.js' //waits until 1st in files (jquery is loaded)
});

function spin(element_id, animation, speed)
{
    if(!element_id) {

        console.warn('No Element ID', this.name);

        return false;
    }
    if(typeof speed == 'undefined') {
        var speed = 200;
    }

    //makes sure that the file is loaded. Or waits until it loads.
    this.load('jquery.simple-text-rotator.js', function(obj) {

        spin.payload(element_id, function() {

            if(!/^#|\./i.test(element_id)) {
                element_id = '#' +element_id;
            }

            var animate  = function() {
                switch (animation) {
                    case 'flip':
                        if (!speed) {
                            var speed = 1000;
                        }
                        $(element_id).textrotator({
                            animation: "flip",
                            speed: speed
                        });
                        break;
                    case 'spin':


                        $(element_id).textrotator({
                            animation: "spin",
                            separator: ","
                        });

                        break;
                    case 'flipUp':
                        if (!speed) {
                            var speed = 2000;
                        }
                        $(element_id).textrotator({
                            animation: "flipUp",
                            speed: speed
                        });

                        break;
                    case 'flipCube':
                        $(element_id).textrotator({
                            animation: "flipCube",
                            separator: "|"
                        });
                        break;
                    case 'fade':
                        $(element_id).textrotator({
                            animation: "fade",
                            separator: "|"
                        });
                    default:
                        $(element_id).textrotator({
                            animation: "flipCube",
                            separator: "|"
                        });
                }
            };
            if(typeof $.fn.textrotator =='undefined') {
                //it appears that even though the file has loaded,
                //jquery still needs some time to process the plugin, so
                //wee need a few milliseconds more..

                spin.repeat(animate); // tried to recall if it fails
            } else {
                animate();
            }


        });

    });

}