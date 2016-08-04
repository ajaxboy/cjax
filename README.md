# Cjax Web Development Ajax Framework

## Requirements

+    PHP 5.2+
+    Strict Standards turned off


## Links

 Official Site: http://cjax.sourceforge.net/

 Official Repo: https://github.com/ajaxboy/cjax

 Official Download Location: https://sourceforge.net/projects/cjax/files/


## Instructions

*NEW Instructions*

Download zip from git 

or 

git clone https://github.com/ajaxboy/cjax.git

boom! you are set. First thing you want to do is go to the examples directory on your install. Review the examples, and the code samples, and start using, as simple as that. Have any question? Open an issue here on the issues tab. 


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

## The CJax's way, one line of php code does it all

## Example #1 - Ajax Call
```php
<?php
$ajax->click('#element_id' , $ajax->call('controller/the_function/'));
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
$ajax->click('#element_id' , $ajax->form('controller/the_function/'));
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
		<a id='element_id' href='#'>Click me To Submit Form</a>
	</form>
	</body>
</html>
```

## Example #3 - Ajax Overlay, Lightbox
```php
<?php
$ajax->click('#element_id' , $ajax->overlay('some/splash/html'));
?>
<!doctype html>
<html>
	<head>
		<?php echo $ajax->init();?>
	</head>
	<body>
		<a id='element_id' href='#'>Click Show Overlay</a>
	</body>
</html>
```

## 40+ more examples here: http://cjax.sourceforge.net/examples/
