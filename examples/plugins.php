<?php

require_once "ajax.php";

?>
<html>
<head>
<title>Creating a Plugin</title>
<?php echo $ajax->init();?>
<link rel="stylesheet" type="text/css" href="resources/css/table.css" media="all">
</head>
<body>
<h2>Plugins</h2>
<?php 
echo $ajax->format->_dialog("
<h3>Download Developer Sample Plugins</h3>
<a target='_blank' href='http://sourceforge.net/projects/cjax/files/API/Developers.ExamplePlugin_1.1.zip/download'>Developer/Example Plugin</a> - Samples Codes and documentation API, on how to create plugins.
<br />
<a target='_blank' href='http://sourceforge.net/projects/cjax/files/API/Developers.basic_plugin.zip/download'>Developer/Basic Plugin</a> - very basic example on how to create plugins with Javascript (without php).

");?>
<br />
<?php 
ob_start()
?>

<h2>Steps for creating a plugin</h2>
<ul>
	<li>Create a Javascript file under cjax/plugins/yourplugin.js
	<ol>
	<br />
	        Or you may also create a directory inside plugins directory like so:  
        cjax/plugins/yourplugin/yourplugin.js,  In case you want to add additional css, images, or other media, etc.
	<br />
	<br />
	</ol>
	</li>
	<li>Add a function <b>yourPlugin</b> in  yourplugin.js <ol> <?php echo $ajax->jsCode(" function yourPlugin() {}")?><br /></ol></li> 
	<li>Call your plugin <ol><br /><?php echo $ajax->code('$ajax->yourPlugin()', false);?><br /></ol></li>  
	<li>Replace "yourPlugin" with the name you would like your plugin to have</li><br />
	<li>Pass parameters 
		<ol><br />
		You may pass strings or arrays through function parameters through your php plugin call.<br />
		 <?php echo $ajax->code("\$ajax->yourPlugin('pass strings', ['pass'=>'arrays'])", false);?> 
		</ol>
		<ol>
		<br />
		Access parameters in your JavaScript Plugin:
		<?php echo $ajax->jsCode("
	//cjax/plugins/yourplugin.js
	function yourPlugin(string, array) {
		alert(string);
		
		//alerts all the items in your array.
		for(item in array) {
			alert(item+ ' '+array[item]);
		}
	}")?>
		</ol>
		<ol>
		    <br />
			Arrays are converted to  Json objects, that is how you would access them.
		</ol>
	</li>
</ul>

<?php 
echo $ajax->format->_dialog(ob_get_clean(),"Creating Plugins");
?>

<?php ob_start();?>
<h2>Hello World Plugin</h2><br /><br />
PHP Code used to call plugin:<br />
<?php 
echo $ajax->code("\$ajax->hello_world('hello', 'world!', ['test']);");
?>

<br />
This is what hello_world.js looks like:
<?php 
echo $ajax->jsCode(
"
function hello_world(a,b,c){
	//sample of importing javascript into the scope
	this.importFile('http://cjax.googlecode.com/svn/trunk/_extra/test_unit/plugins/js/test.js');
	//sample of importing css to the page
	this.importFile('http://cjax.googlecode.com/svn/trunk/_extra/test_unit/plugins/css/test.css');
	
	console.log('File base:', this.base);
	console.log('This file:', this.file);
	console.log('Paramters Passed:', a, b ,c);
}
");

echo $ajax->format->_dialog(ob_get_clean(),"Hello World Sample Plugin");
?>


<h2>Plugins JavaScript API</h2>
<table class='table' style="margin-top:5px; margin-left:20px;">
<thead>
	<tr>
	<th>API</th>
	<th>type</th>
	<th>Params</th>
	<th>Description</th>
	<th>Example(s)</th>
	</tr>
</thead>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->jsCode("this.importFile()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		path - required string
		<br /><br />
		$callback - optional callback function
	</td>
	<td width="300">
		Import and  caches <b>JavaScript</b> or <b>CSS</b>  files. You may use <b>relative path</b> to your plugin, eg: just
		"myfile.js" or "js/myfile.js". You may also import remote CSS or JavaScript.
		You may use the callback as  an indicator that the script/css is fully loaded.
		
	</td>
	<td width="300">
<?php echo  $ajax->jsCode("
this.importFile('css/style.css');

this.importFile('js/myFile.js');

this.importFile('js/myFile2.js', function() {
	alert('script loaded');
	//do something with the loaded file 
});
");?>
	</td>
</tr>

<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.base");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Variable
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td style="vertical-align:middle">
		Returns the full base path url to your plugin directory location.
	</td>
	<td width="300">
		<?php echo $ajax->jsCode("alert('Directory: '+this.base);");?>
	</td>
</tr>

<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.file");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Variable
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td width="250">
		Returns file name, eg.  myplugin.js
	</td>
	<td width="300">
		<?php echo $ajax->jsCode("alert('File: '+this.file);");?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.ajaxFile");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Variable
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td width="250">
		Returns the default path to ajax.php
	</td>
	<td width="300">
		<?php echo $ajax->jsCode("alert('File: '+this.ajaxFile);");?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle">
		<?php echo $ajax->jsCode("this.prevent()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$count - optional integer [default 1]
	</td>
	<td width="250">
		Allows you to intercept the execution of  $ajax object APIs. It returns  a function
		which you can use to trigger the intercepted APIs. If $count is specified,
		you may place how many APIs you want to prevent after  the execution of the plugin API.
		
	</td>
	<td width="300">
		in  your controller...
		<br />
<?php echo  $ajax->code("
\$ajax->yourPlugin();

\$ajax->call(\"ajax.php?controller/functions\");
");
?>
		<br /><br />
		in your js plugin...
		<br />
<?php 
echo $ajax->jsCode("
var func = this.prevent();
//it prevented  \$ajax->call() from  being executed.

//now you have the control of when it should be executed
func();
");
?>
		you may prevent more than one.
	</td>
</tr>




<tr>
	<td style="vertical-align:middle">
		<?php echo $ajax->jsCode("this.serialize()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$form_id - require string
	</td>
	<td width="250">
		Get all values in a form.
		
	</td>
	<td width="300">
<?php echo  $ajax->jsCode("
//c/f = controller/function
this.post(this.AjaxFile+'?c/f', this.serialize('form1'));
");?>
	</td>
</tr>



<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.call()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$mix_url - require mixed [string, object]<br /><br />
		$mix_item - optional mixed [string, object]
	</td>
	<td width="250">
		Create ajax requests
	</td>
	<td width="350">
<?php echo  $ajax->jsCode("
//c/f = controller/function

this.call('ajax.php?c/f');

this.call('ajax.php?c/f', 'container_id');

this.call('ajax.php?c/f', function(response) {

});

this.call({
 url: 'ajax.php?c/f',
 data: 'a=1&b=2&c=3',
 success: function(response) {},
 error: function(error_status) {}
});
");?>
	</td>
</tr>

<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.get()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$url - require mixed [string]<br /><br />
		$mixed - optional mixed [string, object]
	</td>
	<td width="250">
		Create ajax requests with get. $mixed can be a container id
		where the  response html is  sent to or it can be a callback function
		which returns the response.
	</td>
	<td width="350">
<?php echo  $ajax->jsCode("
this.get('ajax.php?c/f');

this.get('ajax.php?c/f', 'container_id');

this.get('ajax.php?c/f', function(response) {

});
");?>
</td>
</tr>


<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.post()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$url - require mixed [string]<br /><br />
		$mixed - optional mixed [string, object]
	</td>
	<td width="250">
		Create ajax requests with post. $mixed can be a container id
		where the  response html is  sent to or it can be a callback function
		which returns the response.
	</td>
	<td width="350">
<?php echo  $ajax->jsCode("
this.post('ajax.php?c/f','a=1&b2&c=3');

this.post('ajax.php?c/f','a=1&b2&c=3', function(response) {

});

this.post('ajax.php?c/f', function(response) {
	
});
");?>
</td>
</tr>


<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.overLayContent()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		content - required [string]<br /><br />
		options - optional mixed [object]
		<div style="margin-left: 15px">
			<i>top</i> - position from top of the page
			<br />
			<i>left</i> - position from left
			<br />
			<i>transparent</i> - from 1 to 100 level of background transparency.
			<br />
			<i>color</i> - color of the background
		</div>
	</td>
	<td width="250">
		Displays a lightbox overlay window with supplied content.
	</td>
	<td width="350">
<?php echo  $ajax->jsCode("
//1
this.overLayContent('Content Here');
//2
this.overLayContent('Content Here', {
	top: '200px',
	left: '200px',
	transparent: '50%',
	color: '#333',
});
");?>
</td>
</tr>



<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.overLay()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		content - required [string]<br /><br />
		options - optional mixed [object]
		<div style="margin-left: 15px">
			<i>top</i> - position from top of the page
			<br />
			<i>left</i> - position from left
			<br />
			<i>transparent</i> - from 1 to 100 level of background transparency.
			<br />
			<i>color</i> - color of the background
			<i>remote</i> - If it is an external url
		</div>
	</td>
	<td width="250">
		Displays a lightbox overlay window with supplied url.
	</td>
	<td width="350">
<?php echo  $ajax->jsCode("
//1
this.overLay('http://url/to/ajax.php?controller/function');
//2
this.overLay('http://url/to/ajax.php?controller/function', {
	top: '200px',
	left: '200px',
	transparent: '50%',
	color: '#333',
});
//3
//triggers crossdomain ajax
this.overLay('http://url/to/remote/location', {
	remote: true
});
");?>
</td>
</tr>



<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.message()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle" width="200">
		message - string<br /><br />
		seconds - optional [default 3]
	</td>
	<td width="250">
		Displays supplied text/content on the screen in form of message. 
	if $seconds is provided, that is how long the message will last on the screen before it disappears, 0 would remove time limit.
	</td>
	<td width="300">
	<?php echo $ajax->jsCode("this.message('Test');");?>
	</td>
</tr>

<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.success()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle" width="200">
		message - string [default 'Success!']<br /><br />
		seconds - optional [default 3]
	</td>
	<td width="250">
		Makes use of this.message() to display a success formatted message.
	</td>
	<td width="300">
	<?php echo $ajax->jsCode("this.success();");?>
	</td>
</tr>

<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.warning()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle" width="200">
		message - string [default 'Invalid Input']<br /><br />
		seconds - optional [default 3]
	</td>
	<td width="250">
		Makes use of this.message() to display a warning formatted message.
	</td>
	<td width="300">
	<?php echo $ajax->jsCode("this.warning();");?>
	</td>
</tr>

<tr>
	<td style="vertical-align:middle">
		<?php echo  $ajax->jsCode("this.error()");?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle" width="200">
		message - string<br /><br />
		seconds - optional [default 3]
	</td>
	<td width="250">
		Makes use of this.message() to display an error formatted message.
	</td>
	<td width="300">
	<?php echo $ajax->jsCode("this.error('Error!');");?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle" colspan="4">
		<h3>Scope</h3>
		All plugins APIS apply to  local scope to each plugin within plugin contructor function.
	</td>
</tr>
</table>


<br />
<?php 
echo $ajax->format->_dialog("
A Plugin can stand on its own  without a php class - and does not require one. However if you require more power in your plugin
extra functions or ajax controllers, Or to overwrite plugin core functionality to customize your plugin even more
then you might be interested in using a php class in your plugin. 
<br />
Some of the functions in plugin PHP APIs are available to all plugins even  if they don't have class.
<br />
These are:  save, get , set, import, imports.
","Plugins PHP API");?>
<br />

<?php 
ob_start()
?>

<h2>Steps for creating a PHP class for your plugin</h2>
<ul>
	<li>Create a PHP file under your plugin directory, name it YourPlugin.php
	<ol>
	<br />
	</ol>
	</li>
	<li>Declare namespace <b>CJAX\Plugins\YourPlugin</b> in  YourPlugin.php <ol> <br />
	<?php echo $ajax->Code("    namespace CJAX\\Plugins\\YourPlugin;")?><br /></ol></li> 
	<li>Add a class <b>YourPlugin</b> in  YourPlugin.php <ol> <br />
	<?php echo $ajax->Code("    namespace CJAX\Plugins\YourPlugin;
	class YourPlugin{
	
	}")?><br /></ol></li> 
	<li>Add a <b>constructor</b> for your plugin<ol><br /> <?php 
	 echo $ajax->Code("    namespace CJAX\Plugins\YourPlugin;
	class YourPlugin{
		
		public function __construct(){
		
		}
	}")?><br />
	</ol>
	</li> 
	<li>Call your plugin <ol><br /><?php echo $ajax->code('$ajax->yourPlugin()', false);?><br /></ol>
		<ol>
			When you call your plugin, the contructor is automatically triggered, all parameters
			passed  in your plugin will be passed in the constructor as well.
			<br /> There are more trigger functions that trigger themselves, look in the PHP plugin API below.<br />
		</ol>
	</li>  <br />
	<li>Replace "YourPlugin" with the name of your plugin</li>
</ul>

<h2>Ajax Controllers for plugins</h2>
<br /><br />
<ul>
    <li>Firstly to start using Ajax Controllers in your plugin, you'd need to create a "controllers" directory in your plugin and then create a controller class. 
 <ol><br /> <?php 
	 echo $ajax->Code("    namespace CJAX\Plugins\YourPlugin\Controllers;
	class YourPlugin{
		
	}")?><br />
	</ol>Note the namespace for plugin controllers is: CJAX\Plugins\YourPlugin\Controllers.
    </li><br />
    <li>Then you are ready to go. The ajax framework through ajax.php automatically detends your plugin if you pass the plugin name as controller.</li><br />
    <li>For example:  ajax.php?yourplugin/funtion1 will automatically go into your plugin and look for controllers/yourplugin.php.</li><br />
    <li>Class name is YourPlugin and function function1 (or any function name you pass through second parameter in the URL).</li>
</ul>

<?php 
echo $ajax->format->_dialog(ob_get_clean(),"Creating a PHP Class for plugin");
?>

<br />
<br />
<h2>Plugins PHP API</h2>
<table class='table' style="margin-top:5px; margin-left:20px;">
<thead>
	<tr>
	<th>API</th>
	<th>type</th>
	<th>Params</th>
	<th>Description</th>
	<th>Example(s)</th>
	</tr>
</thead>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->import()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$url - required string
		<br /><br />
		$load_time - optional integer <br />
		 milliseconds
	</td>
	<td width="300">
		Import and  caches <b>JavaScript</b> or <b>CSS</b>  files. You may use <b>relative path</b> to your plugin, eg: just
		"myfile.js" or "js/myfile.js". You may also import remote CSS or JavaScript.
		<br /><br />
		$load_time  -
		Import scripts are loaded asynchronously, when importing multiple scrips it is possible that a second  script could load before the first one, if it is smaller. 
		You may give extra milliseconds to your import to ensure that it doesn't load too fast or too slow in comparism with others.
		The range should be from 50 to max 400 (4th of a second), depending how big the script is. 
		If you experience issues with one script loading in mixed order use imports() function instead.
	</td>
	<td width="300">
<?php echo  $ajax->Code("
\$myplugin->import('file.js');
\$myplugin->import('file.css');
\$myplugin->import('file2.js');
",false);?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->imports()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$files - required array
		<br /><br />
	</td>
	<td width="300">
		Import and  caches <b>JavaScript</b> or <b>CSS</b>  files. You may use <b>relative path</b> to your plugin, eg: just
		"myfile.js" or "js/myfile.js". You may also import remote CSS or JavaScript.
		<br /><br />
		This function first waits for the previous file to be fully loaded before loading the next  one.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("
\$myplugin->imports('file.js','file2.js','file3.js');
",false);?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->waitfor()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$file - required string
	</td>
	<td width="300">
	Wait for javascript file to be loaded before firing plugin. Currently this function
	only accounts with scripts loaded with import() or imports(). $file is the filename  
	of the javascript file which the plugin depends on, if there are more than one, enter 
	the last file required.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin->waitfor('some_file.js');


",false);?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->set()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$setting - required string
		<br /><br />
		$value - require mixed string
	</td>
	<td width="300">
		Updates plugin parameters and variables of your JavaScript plugin.
		You may use
		a,b,c,d,e,f etc. 
		If you <b>don't</b> use alphabetic letters to update parameters, any other variable name
		will also be accessible within your plugin as eg: this.variable_name.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("
//Setting Paratemers
\$myplugin->set('a','this is parameter one in your script');
\$myplugin->set('b','this is parameter two in your script');

--access parameters

function myplugin(a,b) {

}

//Setting Variables
\$myplugin->set('test1','this is a variable');
\$myplugin->set('test2','this is another variable');

--access  variables in your plugin

function myplugin(a,b,c) {

	alert(this.test1);
	alert(this.test2);
}
",false);?>
	</td>
</tr>




<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin::__construct()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td width="300">
	Trigger Function - 
	This function is a type of constructor function. Is Automatically called at the initiation of your  plugin.
	The paratemers passed when you call your plugin, will be passed through this function in the same order.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin = \$ajax->myplugin(\$arg1, \$arg2);

//plugins/myplugin/myplugin.php
namespace CJAX\\Plugins\\Myplugin;
class Myplugin extends Plugin{
	public function onAjaxLoad(\$arg1, \$arg2){
	
	}
}
",false);?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin::onLoad()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td width="300">
	Trigger Function - 
	This function is a type of constructor function. Is Automatically called at the initiation of your plugin
	in controller (none Ajax Mode).
	The paratemers passed when you call your plugin, will be passed through this function in the same order.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin = \$ajax->myplugin(\$arg1, \$arg2);

//plugins/myplugin/myplugin.php
namespace CJAX\\Plugins\\Myplugin;
class Myplugin extends Plugin{
	public function onLoad(\$arg1, \$arg2){
	
	}
}
",false);?>
	</td>
</tr>



<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin::onAjaxLoad()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td width="300">
	Trigger Function - 
	This function is a type of constructor function. Is Automatically called at the initiation of your  plugin
	<b> in an Ajax Controller</b>.
	The paratemers passed when you call your plugin, will be passed through this function in the same order.
	Thi function is optional.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin = \$ajax->myplugin(\$arg1, \$arg2);

//plugins/myplugin/myplugin.php
namespace CJAX\\Plugins\\Myplugin;
class Myplugin extends Plugin{
	public function onAjaxLoad(\$arg1, \$arg2){
	
	}
}
",false);?>
	</td>
</tr>





<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->save()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$setting - required string
		<br /><br />
		$value - required mixed string
	</td>
	<td width="300">
	Save plugin settings in session or cookie. You may access this data in the plugin's ajax controllers.
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin->save('my_variable','the_value');


",false);?>
	</td>
</tr>




<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->get()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		$setting - required string
	</td>
	<td width="300">
	Get setting that has been saved with save() function. 
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin->get('my_variable');


",false);?>
	</td>
</tr>


<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->prevent()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
	$call_id - required integer<br />
	$count - optional integer [default 1]<br />
	</td>
	<td width="300">
This function is capable of intercepting APIs and prevent them from being fired, and return them in callback function. Due to asynchronicity there are times the actions are ran before
		they can be intercepted in the existing plugin's this.prevent() function. This method is added to PHP to ensure that APIs can be catched before they are fired. 
		If simply this.prevent() can't catch the APIs you might want to use $ajax->prevent($this->_id); (inside a php plugin class).
		More than one API can be prevented if $count is incremented. If used outside a plugin use $id = $ajax->lastId(); ajax->prevent($id);, you may also retrieve the functions/actions in js by using CJAX.callback_cache[id_here] (id_here - the id passed)
	
		
	</td>
	<td width="300">
<?php echo  $ajax->Code("

\$myplugin->prevent();


",false);?>
	</td>
</tr>



<tr>
	<td style="vertical-align:middle" width="100">
		<?php echo  $ajax->code("\$myplugin->filter()",false);?>
	</td>
	<td style="vertical-align:middle" width="60">
		Function
	</td>
	<td style="vertical-align:middle">
		-
	</td>
	<td width="300">
	Triger Function - This function is automatically called at the end of the processing.
	It passes the raw data being sent from your plugin.
	<br />
	$cache variable  holds all the raw data being sent from the plugin, you may make careful changes still.
	return the $cache, if you don't return anything no changes will be made.
	</td>
	<td width="300">
<?php echo  $ajax->Code("

//plugins/myplugin/myplugin.php
class Myplugin extends Plugin{
	public function filter(\$cache){
		return \$cache;
	}
}
",false);?>
	</td>
</tr>



</table>
&copy; Cj Galindo
</body>
</html>