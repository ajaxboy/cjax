<?php

/**
 * Cjax Settings, all settings are optional preferences.
 */


/**
 * Setting to where the js directory is.
 * Eg: http://yoursite.com/cjax/
 */
$config->js_path = '';


/**
* Having issues on page load not loading some times?
* Cjax uses PHP sessions to pass data across, some times sessions fail or some setting on the server's cache
* may cause unexpented behavior, and could cause cjax not to able to pass the data - in that  case 
* this option allows cjax to fallback on a small footprint on the page to be able to pass the pending data.
* 
 */
$config->fallback = false;

/**
 * This setting bypasses fallback. Don't turn on fallback and caching at the same time, do one of the two.
 */
$config->caching = false;

/**
* Allows the access to ajax.php from browser where otherwise it would  only allow access to ajax request or inclusion.
 */
$config->ajax_view = false;

/**
 * Config displays javaScript debug information in firebug console.
 */
$config->debug = false;

/**
 * Only debug for this IP:
 * Enter an IP below if you want to debug ONLY for this specific IP.
 * You may also enter an array of IPs
 * 
 */
$config->ip_debug = '';

/**
 * Init URL
 * 
 * $ajax->init() - prints the script tags to include the framework.
 * 
 * Generally you won't need to touch this. If you experience problems where the script path is not being 
 * set correctly, or you are using very fancy URLs where the paths can be confusing, then you might find
 * this helpful. This will help the framework find the correct path to the js file in a case where it cannot 
 * be found.
 * 
 * Eg: http://your/site/url (where ajax.php is located).
 */
$config->init_url = '';

/**
 * Use camel case in class names
 * 
 * Make class names 
 * readLikeThis
 * instead of:
 * read_like_this
 * or
 * true is default.
 */
$config->camelize = true;
/**
 * if camerilize is true,
 * is the first letter capitalize?
 */
$config->camelizeUcfirst = false;

/**
 * Optionally, you may opt to specify a default upload location.
 * Uploading plugins may upload files may access a default upload location
 * specify that path here. The path may or may not end with a slash.
 */
$config->upload_dir = '';


/**
 * URL of directory where images are uploaded.
 * Eg: http://yoursite.com/uploads/
 * This setting is used by any feature that would display images
 * including the ajax uploader plugin.
 */
$config->preview_url = '';




