# Cjax Web Development Ajax Framework

## Requirements

+    PHP 5.2+


## 5.9

Version 5.9  brings scalabity improvements to work on heave duty ajax projects. It improves upon caching and processing core functionality. So you defintely want this version (currently on the master branch)


## Instructions / Download 

*NEW Instructions*

Download zip from git 

or 

git clone https://github.com/ajaxboy/cjax.git

boom! you are set. First thing you want to do is go to the examples directory on your install. Review the examples, and the code samples, and start using, as simple as that. Have any question? Open an issue here on the issues tab. 

Review the examples below on this readme. If you can understand these examples from the get-go, you're absoletely going to love Cjax because there isn't much more needed to be done, except adding a ajax controller.


## Introduction

Cjax is a small lightweight but very powerful Ajax Framework that translate PHP Code into User Interface Actions. It can 
help to develop Ajax applications in record time, saving you up to 60% of development time once you are familiar with the
simple to use Cjax API.
  
Cjax is simplistic and uses Convention  Over Configuration model approach. With its MVC design makes it quite easy to integrate
into existing PHP-Frameworks (such as Zend, CodeIgnater, cakePHP, Yii, etc). However it does not require a framework, it can very well work on itself, on any site.

In most cases all you need is one line of code. Cjax carries a plugin system (as well as the core) that makes PHP and JavaScript look like lovers, meaning that
it is the most seemless integration of PHP and JavaScript that you can find.

Unlike others libraries that try to mimic Cjax, for cjax there is no 'client' side involved, there is no inlines codes, there is no process request, all you need is your php code and that's it.

## Example code

Check out the live examples/demos at http://cjax.sourceforge.net/examples/

Of course you can just download and see the examples work on your dev enviroment, that is even better.

## Full API Documentation

http://cjax.sourceforge.net/docs/ 

## Examples, More Examples

It's really simple as

## The CJax's way, one line of php code does it all

## Example #1 - Ajax Call

Self explanatory really, $ajax, element_id .. call.. ajax controller umm need I say more?.

```php
<?php
$ajax->click('#element_id' , $ajax->call('controller/method'));
?>
<!doctype html>
<html>
	<head>
		<?php echo $ajax->init();?>
	</head>
	<body>
		<a id='element_id' href='#'>Click me</a>
	</body>
</html>
```

## Example #2 - Ajax Form

What I love about Cjax, that you take a look a that line of code, and you know exactly what it is doing, even if you didn't know PHP. On this example,  #form_anchor is the element id. You can assign an ajax form to it through the $ajax object, and boom you got an ajax form, you can really assign the form to anything on the page with an id, and when you click it, it submits the form through ajax, to the specified ajax controller, and yes you can even upload files!.

```php
<?php
$ajax->form_anchor = $ajax->form('controller/method');
?>
<!doctype html>
<html>
	<head>
		<?php echo $ajax->init();?>
	</head>
	<body>
	<form>
		Field #1 <input type='text' id='field1' name='field1' />
		<br />
		Field #2 <input type='text' id='field1' name='field2' />
		<br />
		<a id='form_anchor' href='#'>Click me To Submit Form</a>
	</form>
	</body>
</html>
```

## Example #3 - Ajax Overlay, Lightbox

What this line of code does?  It add a click event to element #anchor, when you click this anchor it will trigger an ajax request and load external html from a file or a controller. It will display a lightbox (a new window) displaying the contents gathered from the controller.  All this , with one line of code,  beat that!.

```php
<?php
$ajax->click('#anchor' , $ajax->overlay('controller/splashHTML'));
?>
<!doctype html>
<html>
	<head>
		<?php echo $ajax->init();?>
	</head>
	<body>
		<a id='anchor' href='#'>Click Show Overlay</a>
	</body>
</html>
```

## 40+ more examples here: http://cjax.sourceforge.net/examples/
