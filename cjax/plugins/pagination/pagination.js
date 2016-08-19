/**
 * Author:  Cj Galindo
 * included here, the works of Eugene Simakin
 */

CJAX.importFile({
        files: 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js,pagination.css',
        plugin:'pagination',
        check: 'jQuery',
        payload: 'js/jquery.twbsPagination.js'
    });
//docs:
//http://esimakin.github.io/twbs-pagination/
function pagination(element_id, options)
{
    if(typeof options == 'object') {
        this.options = options;
    }

    var $options = {
        totalPages: 0,
        startPage: 1,
        visiblePages: 7,
        initiateStartPageClick: false,
        href: false,
        hrefVariable: '{{number}}',
        first: 'First',
        prev: 'Previous',
        next: 'Next',
        last: 'Last',
        loop: false,
        onPageClick: null,
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled',
        pageContainer: 'page',
        cache: false,
    };

    if(typeof this.options == 'object') {
        for (var x in this.options) {
            $options[x] = this.options[x];
        }
    }

    //at this point the file already loaded.
    this.load('jquery.twbsPagination.js', function(object) {


            var n = Math.floor((Math.random() * 100) + 1);

            var content = 'content'+n;
            var pagination_class = 'pagination';

            page_wrapper = 'page_wrapper'
            if($options.wrapperClass) {
                page_wrapper = $options.wrapperClass;
            }

            if($options.pageClass) {
                page_class = $options.pageClass;
            }
            if($options.paginationClass) {
                pagination_class = $options.paginationClass;
            }

            if($options.size && $options.size == 'small') {
                pagination_class += ' pagination-sm';
            }

            $container = $("<div class='"+page_wrapper+"'><div><span class='page_content' id='"+content+"'></span></div><div><nav aria-label='"+page_class+" navigation'><ul class='"+pagination_class+"' id='pagination"+n+"'></ul> </nav></div></div>");

            if(!/^#|\./i.test(element_id)) {
                element_id = '#' +element_id;
            }

            $(element_id).wrapInner($container.clone());


            $options.onPageClick = function (event, page) {

                if($options.cache) {
                    CJAX.ajaxSettings.cache = true;
                }

                var url = $options.url;
                CJAX.get(url + '/' + page, function (response) {

                    CJAX.update(content, response);

                });
            };


            //allows to delegate the element in question, it will execute this function.
            //even if the element doesn't exist, it adds the function to queue
            pagination.payload('pagination'+n, function(ul) {

                var paginatin = function() {
                    $(ul).twbsPagination($options);
                };


                //basically calls the function paginatin(), and if it fails,
                // (most likely because jquery hasn't processed the plugin yet, or dom not ready)
                //adds a few milliseconds, then tries to execute again, does this a few times, allows for failsafe.

                pagination.ready(function() {
                    pagination.repeat(paginatin, 300);
                })
            });

    });

}