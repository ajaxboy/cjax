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

        console.warn('No Element ID', 'spin plugin');

        return false;
    }
    if(typeof speed == 'undefined') {
        var speed = 200;
    }

    //makes sure that the file is loaded. Or waits until it loads.
    //particularly needed when calling during ajax call, and none of the files are loaded.
    this.load('jquery.simple-text-rotator.js', function(obj) {

        if (!/^#|\./i.test(element_id)) {
            element_id = '#' + element_id;
        }

        var animate = function () {
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
                case 'flipCubeUp':
                    $(element_id).textrotator({
                        animation: "flipCubeUp"
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
                    break;
                case 'stop':
                    console.log('trygin to stop');
                    $(element_id).stop();
                    break;
                default:
                    $(element_id).textrotator({
                        animation: "flipCube",
                        separator: "|"
                    });
            }
            $(element_id).data('default', $(element_id).text())
        };

        spin.ready(function () {
            spin.repeat(animate);
        });

    });

}