/**
 * Cjax plugin spin v1.0
 */
CJAX.importFile({
    //list of files to load separated by comma, can use relative path to this plugin
    files: 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js,css/simpletextrotator.css,css/elusive-webfont.css',
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

    console.log('trying to load');
    //makes sure that the file is loaded. Or waits until it loads.
    this.load('jquery.simple-text-rotator.js', function() {

        console.log('loaded')
        if(!/^#|\./i.test(element_id)) {
            element_id = '#' +element_id;
        }


            $(element_id).textrotator({
                animation: animation,
                separator: ", "
            });


    });

}