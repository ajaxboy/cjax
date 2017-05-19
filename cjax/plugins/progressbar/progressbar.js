/**
 * progressbar  v1.0
 */

CJAX.importFile({
    files: 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js,css/style.css',
    plugin:'progressbar',
    check: 'jQuery'
});
//docs:
function progressbar(element_id, progress, options)
{

    if(!/[^a-zA-Z0-9_]/.test(element_id)) {
        element_id = '#'+element_id;
    }

    CJAX.$(element_id, function(elements) {


        for(x in elements) {

          var new_element = elements[x];


          $(new_element).addClass('progressbar');


          if(!$(new_element).attr('tagged')) {


              $(new_element).unbind('click').on('click',function() {

                  if ($(this).find('.pbinfo').length <= 0) {
                      $(this).append('<div class="pbinfo"><div class="info-inner"></div></div>');

                  }

                  var $info = $(this).find('.pbinfo'),
                      $inner = $(this).find('.info-inner'),
                      $p = $(this).attr("class").match(/p-\w+/).toString().substring(2);


                  $inner.text(parseInt($p) + '%');
                  $info.addClass('js-active');

              });



              var img = $(new_element).find('img');



              if (img.length) {

                  img.addClass('avatar');

                  $(new_element).append($('<div></div>').addClass('avatar').append(img));


              }


              $(new_element).attr('tagged', true);
          }

            $(new_element).attr('class',
                function(i, c){

                    return c.replace(/(^|\s)p-\S+/g, '');
                });


            $(new_element).addClass( "p-" + parseInt(progress) );


            $(element_id).last().trigger('click');

        }

    });
}