<?php

/**
 * CJAX CI Integration
 */

if( isset( $_SERVER['SCRIPT_NAME'] ) )
{
    $url = str_replace( $_SERVER['SCRIPT_NAME'] ,'', $_SERVER['REQUEST_URI'] );
    if( substr( $url ,0 ,1 ) != '?'  ) {
        $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
    }
}

/**
 * Optional
 * Force ajax controler to only be served if requested from this file.
 * This is only needed when calling controllers from files other than 'ajax.php';
 * in case of conflict with other controllers.
 *
 * @var string file name
 */
define('AJAX_FILE', 'ajax.php');

/**
 * Controllers Directory.
 * Directory where ajax controllers are located.
 * @constant AJAX_CD
 */
define('AJAX_CD', 'application/response');

/**
 * Security Feature.
 * Lifts the limited view of ajax response on regular browsers.
 * If you remove this no one will be able to see responses unless from an XHR request, Flash Request, etc.
 *
 * If you are not interested in viewing the response on the browser or you unexpectly see the response,
 * you may remove this setting by removing the line below.
 *
 * @constant AJAX_VIEW
 */
define('AJAX_VIEW', 1);

/**
 *
 * Allows to include 'ajax.php' as well as 'ajaxfw.php' back to back compatibility.
 * @var unknown_type
 */
$included_files = get_included_files();

if(!$included_files) {
    $included_files = get_required_files();
}
if($included_files && count($included_files) > 1) {
    return require_once 'application/libraries/ajax.php';
}


// The controller class file name.  Example:  mycontroller
$routing['controller'] = 'AjaxController';

// The controller function you wish to be called.
$routing['function']	= 'main';

require 'index.php';