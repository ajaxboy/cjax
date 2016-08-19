<?php

/**
 * CJAX CI Integration
 */

/**
 * Controllers Directory.
 * Directory where ajax controllers are located.
 * @constant AJAX_CD
 */
if(!defined('AJAX_CD')) {
    define('AJAX_CD', 'application/response');
}

/**
 * Optional
 * Force ajax controller to only be served if requested from this file.
 * This is only needed when calling controllers from files other than 'ajax.php';
 * in case of conflict with other controllers.
 *
 * @var string file name
 */
if(!defined('AJAX_FILE')) {
    define('AJAX_FILE', 'ajax.php');
}


/**
 * Make this directory the main working directory.
 */
chdir(dirname(__FILE__));

/**
 * A request is being made
 */
if(debug_backtrace(false)) {

    return require_once 'cjax/ajax.php';
}


// The controller class file name.  Example:  mycontroller
$routing['controller'] = 'AjaxController';

// The controller function you wish to be called.
$routing['function']	= 'main';

require 'index.php';