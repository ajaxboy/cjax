

//CJAX.debug = true;

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
        visiblePages: 5,
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
        cache: false
    };

    if(typeof this.options == 'object') {
        for (var x in this.options) {
            $options[x] = this.options[x];
        }
    }

    $options.onPageClick = function (event, page) {

        if($options.cache) {
            CJAX.ajaxSettings.cache = true;
        }

        var url = $options.url;
        CJAX.get(url + '/' + page, function (response) {

            CJAX.update($options.pageContainer, response);

        });
    };

    this.load('jquery.twbsPagination.js', function(object) {

        pagination.payload(element_id, function(ul) {

            if(typeof  display_num == 'undefined') {
                display_num = 10;
            }

            var tries = 0;

            var paginatin = function() {
                try {
                    $(ul).twbsPagination($options);
                    return true;
                } catch(e) {
                    if(tries >= 15) {
                        CJAX.warning("Could not generate pagination.");
                        console.error("Could not generate pagination.", e);
                        return false;
                    }
                    setTimeout(function() {
                        paginatin();
                    },100);
                    tries++;
                    return false;
                }

            };

            paginatin();


        });

    });
}