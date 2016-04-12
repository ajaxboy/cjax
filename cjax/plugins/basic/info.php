<?php

/** For comments only**/
// Please  note, that is not a functional script
//  and will NOT run on your browser. It  is only comments to illustrate
// how to create a very basic plugin.

//this is  a dummy file that mimic  your own controller, for demontration purpose only

// get instance of the framework (you first would need to include the ajax file)
// require_once 'ajax.php';
$ajax = ajax();

// call your plugin
// please note that you do not need a class or a php file, to create  a plugin.
// all you need is your javascript file, in this case basic.js
$basic  = $ajax->basic();
//you could pass parameters in the constructor, and you will get them in the basic.js file.


//passing variables
$basic->set('test','Hello'); 
//or 
$basic->test = 'Hello';

//Now in your plugin basis.js you can access this variable as:

alert(this.test);



//to update  parameters sent to the plugin, you would use alphabetic  letters, a to z,
//Example:

$basic->set('a', 'Hello');
$basic->set('b', 'Hello');
$basic->set('c', 'Hello');

//Now all 3 variables above would be accessibly through parameters in your plugin basic.js. 
//You may also pass arrays, they will be returned as json objects.

//These are means to transfer data across

//You may also use:

$basic->save('test','Hello'); 

// it will save your setting in a session or cookie.
// this is specifially useful when using ajax controllers.

$basic->get('test');

//There you go.. Look in Example plugin if you
//are looking for a more meaningful way and power to develop robust functionality.









