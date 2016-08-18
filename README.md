# Cjax Web Development Ajax Framework

## 70+ Demos/Examples/Docs, APIs  available. http://cjax.sourceforge.net/examples/

## Requirements

+    PHP 5.2+



## Cjax 5.9

Version 5.9  brings scalabity improvements and processing power to work on heavy duty ajax. It improves upon caching and processing core functionality, plugin processing, speed. So you definitely want this version (currently on the master branch)



Note: SourceForge is not longer the official download location.


## Instructions / Download 

**NEW Instructions**

There are multiple ways you can install Cjax, here are several ways:


The old fasion way:
```
Download zip from git 
```

git clone:
```
git clone https://github.com/ajaxboy/cjax.git
```


Use wget in terminal:

First CD into the directory you intend to install it.
```
wget -N https://github.com/ajaxboy/cjax/archive/5.9rc.zip ; unzip '5.9rc.zip' ;  cp -rf cjax-5.9rc/* . ; rm -fr cjax-5.9rc ;  rm 5.9rc.zip
```

Any of these ways work, the bottom line is to get the files on the root (public directory) of your website.

````
                         INTEGRATION
Note:  Cjax 5.9 has integration support for CodeIgniter built-in.
For further CodeIgniter Cjax Docs visit CI's wiki: https://github.com/bcit-ci/CodeIgniter/wiki/Ajax-Framework-For-CodeIgniter
There are other integrations being worked on, such as for Laravel.
If you download this package and figure out how to integrate it anywhere else, contact me @ajaxboy
and we can work together to incorporate that.
````

boom! you are set.

##Testing

Now, go to your website's url,  http://yoursite.com/ajax.php?test/test
(replace http://yoursite.com with the base directory where your site resides)

To this point you are done, successfully installing and using Cjax,  the screen should give further instructions.

You will see a test to prove that Cjax is working on your site, if you see a success message, then that means Cjax is fully
operational on your website.

Review the examples, and the code samples, and start using, as simple as that.

Have any question? Open an issue here on the issues tab or contact me @ajaxboy, I will be happy to assit.

Please do note that I do offer profesional installation, should you need that service.



## Introduction

Cjax is a small lightweight but very powerful Ajax Framework that translate PHP Code into User Interface Actions. It can 
help to develop Ajax applications in record time, saving you up to 60% of development time once you are familiar with the
simple to use Cjax API.
  
Cjax is simplistic and uses Convention  Over Configuration model approach. With its MVC design makes it quite easy to integrate
into existing PHP-Frameworks (such as Zend, CodeIgnater, cakePHP, Yii, etc). However it does not require a framework, it can very well work on itself, on any site.

In most cases all you need is one line of code. Cjax carries a plugin system (as well as the core) that makes PHP and JavaScript look like lovers, meaning that
it is the most seemless integration of PHP and JavaScript that you can find.

Unlike others libraries that try to mimic Cjax, for cjax there is no 'client' side involved, there is no inlines codes, there is no process request, all you need is your php code and that's it.
 

##Background##

Cjax allows you to write ajax in the PHP side, it gives you many tools that you can use to make your deveploment experience a smooth ride. It also saves you tons of time from re-inventing the wheel, - you see, I spent years perfecting this tool, now you can just come and use and not spend all that time - and money! - not to mention the research, gone overboard.

Cjax comes with over 70 examples/samples/docs and APIs that can let you do amazing things with a single line of code, that otherwise would take you hours or days, or even weeks!. You know, the usual success message, to lightbox, submitting forms with ajax, and uploading files with ajax, you know - the usual stuff that you would use in your application or website, each one of these things I just mentioned took me days and weeks to code, and overtime they have improved, Cjax has become an e-cosystem of ajax functions.

Cjax consolidates all your ajax code in a single place. Making your code more secure. Cjax also has only one point of access. Making your application or website very secure. Cjax lets you use classes and routes your ajax calls through a dispatcher to reach your ajax controller. Includes a callback system, that lets you do ajax requests when the page loads, but also, when you trigger your ajax request once on the server, it lets you run more ajax code, and interact with your application or website right from the back-end, right from your controller. This gives you the freedom to go back and forth, from one ajax method to the other, working in harmony. Also includes a way that you can maninupate all the elements on the page, right from the back-end, all done within one ajax call.

Cjax is a piece of machinery to build ajax features . Uses unconventional methods to push the bounderies in allowing you to just write very few short lines of code .

Cjax has the power to allow you to to call and use your existing JavaScript, without making changes to it. It really lets express yourself in the way that you want to express. You have old, or new custom JavaScript, execute it with Cjax - you can pass data to your existing functions, instanciate them, right from the back-end. You use other 3rd party libraries or code - no problem. Cjax lets you execute it, and pass data to it, right from the back-end, you can call them as many times as you want, no limit, only the sky. You can pass from simple strings, or integers, to entire arrays or objects. Guess what, As a matter of fact, that is what Cjax's plugins are, 'plugins' is just a formality, but what they really are - custom code ran with Cjax. If you run your custom code, you already built a Cjax plugin!

Cjax code is simple easy to understand, and uses convention over configuration approach to do the most, with less.



## Examples, more Examples, the CJax's way, one line of php code does it all

### Example #1 - Ajax Call

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

### Example #2 - Ajax Form

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

### Example #3 - Ajax Overlay, Lightbox

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



### Example #4 - Get Json Object with Cjax

In this example, we introduce you to Ajax Controllers. An ajax controller is php file dedicated to serving ajax requests for any purposer on your application or website. In fact the entire directory is dedicated to ajax requests. To reach this ajax controller, you go through a dispatcher file called ajax.php. The dispatcher will route your request to the controller.

To get a json object, simply return an array from your ajax method.

```php
<?php
$ajax->click('#anchor_id' , $ajax->call(array('JsoncController','JsonData')));
?>
<!doctype html>
<html>
	<head>
		<?php echo $ajax->init();?>
	</head>
	<body>
		<a id='anchor_id' href='#'>Click to get Jason object</a>
	</body>
</html>


File:  controllers/JsonData.php

Class JsoncController {
	
	public function JsonData() {
	
		return $_SERVER;;
	}
	
}


```

## Example code

Check out the live examples/demos at http://cjax.sourceforge.net/examples/

Of course you can just download and see the examples work on your dev enviroment, that is even better.

## Full API Documentation

http://cjax.sourceforge.net/docs/ 



### Q/A For critics:

#### Does cjax add a bunch of code/footprint to my page?
No!, absolutely no!. Cjax works with PHP Sessions, it saves a variable to keep track of your ajax actions. This variable in array format, is converted into an xml string, this string is processed by Cjax's engine, once interpreted it serves the desired functionality, cjax uses the best methods to interact with the DOM elements, it doesn't require any code on the page. There is absolutely zero code printed on the page!, and that is why Cjax is the fastest!.

#### Is Cjax in competition with jQuery?
A few people have asked this question, there is a large explation for it. But I will sumarize in a brief. 

Cjax works well with jQuery. Although Cjax and jQuery can do a few of the same things, they are not exclusive to each other, you can use both. Cjax doesn't require it, or needs it, but it will work in friendly terms with it. Cjax can use jQuery selector engine or Sizzle. ajax controllers will even process ajax requests made with jQuery as if you made it with Cjax itself. For these that wish to use jQuery to make ajax request, they can absolutely use the Cjax processing engine, and Ajax Controllers, using an ajax framework for ajax is the same as using a php framework for php, Ajax controllers although similar to other frameworks controllers, it is different, it is less heavy, and it is dedicated. 

#### Why do I need to write server side code from client, if I can just write client side?
Well this is true, but then you know there are other projects like node.js that lets you write client side code entirely, and no one is complaining, braking convention is not unheard of. There are different ways to do different thigns. There are other projects out there that in some way have similarities to Cjax, but they do it wrong, they add pages footprint, they make you add inline codes on the page, or simply they want to try to be a client side library on the server side, and that is not right not even for us!. Fortunately Cjax does none of these things. it is a unique well established ajax framework (over 10 years old), these are some preconceptions some people may have, but they just have to try it and investigate better to see that Cjax is not just any library, Cjax will go through great extents to make sure you write the less amount of code, and will use not only the best practices to get things done, in fact is the only piece of software in the world known to use even listerner from the server side, what this translates to is - no footprint on your pages, and less work for you.
