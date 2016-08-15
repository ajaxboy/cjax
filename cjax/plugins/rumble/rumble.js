
CJAX.importFile({
    files: 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
    plugin:'rumble',
    callback: function() {

        //you can import several files by separating them with a comman,
        //however usin callback makes sure the previous file is already loaded before loading this one.
        CJAX.importFile({
             files: 'js/jquery.jrumble.1.3.min.js',
             plugin:'rumble'
         });
    }
});

function rumble(element_id)
{
    setTimeout(function() {
        var element = CJAX.$(element_id);

        $(element).jrumble({
            speed: 300
        })

        $(element).trigger('startRumble');
        setTimeout(function() {
            $(element).trigger('stopRumble');
        },2000);
    },8000);

}