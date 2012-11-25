# Cjax Web Development Ajax Framework

## What do I need?

+    PHP 5.2 or PHP 5.3
+    Strict Standards turned off

## Instructions

This reposition is for Folk only and contributions only, for downloads go to: http://cjax.sourceforge.net/. We build the releases internally because there are different packages that derive from this project (examples, plugins, docs, and 2 versions of Cjax).

## Introduction

Cjax is a small lightweight but very powerful Ajax Framework that translate PHP Code into User Interface Actions. It can 
help to develop Ajax applications in record time, saving you up to 60% of development time once you are familiar with the
simple to use Cjax API.
  
Cjax is simplistic and uses Convention  Over Configuration model approach. With its MVC design makes it quite easy to integrate
into existing PHP-Frameworks (such as Zend, CodeIgnater, cakePHP, Yii, etc).

In most cases all you need is one line of code. Cjax carries a plugin system (as well as the core) that makes PHP and JavaScript look like lovers, meaning that
it is the most seemless integration of PHP and JavaScript that you can find.

Unlike others libraries that try to mimic Cjax, for cjax there is no 'client' side involved, there is no inlines codes, there is no process request, all you need is your php code and that's it.

Cjax is so easy to use that even a 12 year old could figure it out, go ahead, give it a try.

## Example code

Check the a lot of examples and code at http://cjax.sourceforge.net/examples/

## Full API Documentation

http://cjax.sourceforge.net/docs/ (Also anyone can contribute/folk to the docs on this repo).

## Documentation

It's really simple as


## Example #1 - Ajax Call
```php
<?php
$ajax->click('#element_id , $ajax->call('controller/the_function/'));
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
```php
<?php
$ajax->click('#element_id , $ajax->form('controller/the_function/'));
?>
<!doctype html>
<html>
	<head>
		<?php echo $ajax->init();?>
	</head>
	<body>
	<form>
		Field #1 <input type='text' name='field1' />
		<br />
		Field #2 <input type='text' name='field2' />
		<br />
		<a id='element_id' href='#'>Click me To Submit Form</a>
	</form>
	</body>
</html>
```


