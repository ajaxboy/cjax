

CJAX.importFile({
    files: 'css/style.css',
    plugin:'progressbar',
});
//docs:
function progressbar(element_id, progress)
{

    if(!/[^a-zA-Z0-9_]/.test(element_id)) {
        element_id = '#'+element_id;
    }

    var element = $(element_id);

    $(element).attr('class',
        function(i, c){
            return c.replace(/(^|\s)p-\S+/g, '');
        });



    $(element_id).addClass( "p-" + parseInt(progress) );


    $(element_id).on('click',function(){

        if ($(this).find('.info').length <= 0) {
            $(this).append('<div class="info"><div class="info-inner"></div></div>');
        }

        var $info = $(this).find('.info'),
            $inner= $(this).find('.info-inner'),
            //$p    = $(this).attr("class").match(/p-\w+/).toString().substring(2);
            $p    = $(this).attr("class").match(/p-\w+/).toString().substring(2);

        $inner.text(parseInt(progress)+'%');
        $info.addClass('js-active');
    });

    $(element_id).last().trigger('click');
}