<?php

/**
 * Header HTTP_X_REQUESTED_WITH allows to identify where the request is coming from, 
 * requests are blocked, if they come from sources that are not an HRX request, Flash request or similar type of request,
 * such as regular browser view.
 */
#Normally you would not be able to read the response on a regular browser.
#For security reasons, you need this to be able to bypass the security feature and see the  response on the browser.
#in other words, without this, you can't view ajax.php on  your browser.
$_SERVER['HTTP_X_REQUESTED_WITH'] = 'CJAX FRAMEW0RK';

#Controllers directory
define('AJAX_CD','response');

require 'ajax.php';