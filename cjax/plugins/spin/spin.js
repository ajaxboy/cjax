/**
 * Cjax plugin spin v1.0
 */
CJAX.importFile({
    files: 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js,css/simpletextrotator.css,css/elusive-webfont.css',
    plugin:'spin',
    check : 'jQuery', //check if it already loaded
    payload:'js/jquery.simple-text-rotator.js'
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

    this.load('jquery.simple-text-rotator.js', function() {

        if(!/^#|\./i.test(element_id)) {
            element_id = '#' +element_id;
        }

        setTimeout(function() {
            $(element_id).textrotator({
                animation: animation,
                separator: ", "
            });
        },3000);


    });

}