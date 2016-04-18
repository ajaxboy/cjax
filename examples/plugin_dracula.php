<?php

require_once "ajax.php";

$dracula = $ajax->dracula("sortable"); 

$dracula->drake(["left-defaults", "right-defaults"]);

$dracula->drake(["left-copy", "right-copy"], ["copy" => true]);

$dracula->drake(["left-rm-spill", "right-rm-spill"], ["removeOnSpill" => true]);

$events = ["drag" => "function (el) { el.className = el.className.replace('ex-moved', ''); }",
                 "drop" => "ajax.php?dragula/drop", 
                 "over" => "function (el, container) { container.className += ' ex-over'; }",
                 "out" => "function (el, container) { container.className = container.className.replace('ex-over', ''); }"];
$dracula->drake(['left-events', 'right-events'], [], $events);



?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Plugin Dracula - Cjax Plugin</title>
<link href='resources/css/dragula.css' rel='stylesheet' type='text/css' />
<?php echo $ajax->init(false);?>
</head>

<body>
<h3>Ajax Drag and Drop with Dracula</h3>
This Plugins uses Dragula plugin to handle drag and drop of elements, it is especially good for exchanging data between containers. The basic syntax is: 
<br /><br />
<?php 
echo $ajax->code('
$ajax->dracula($containers, $options, $events);
');?>
<br />
If you have multiple drag/drop containers, you can call the drake method on Dracula plugin object. This ensures that the events assigned on each group of containers will not interfere with each other. 
<br /><br />
<?php 
echo $ajax->code('
$dracula = $ajax->dracula($containers, $options, $events);
$dracula->drake($containers2, $options2, $events2);
$dracula->drake($containers3, $options3, $events3);
');?>
<br />

Note the original plugin library is actually named 'Dragula', but it is called 'Dracula' here to avoid javascript function naming conflict. You can view the original plugin for Dragula from the following links:
<ul>
 <li><a target="_blank" href="https://github.com/bevacqua/dragula">https://github.com/bevacqua/dragula</a></li>
 <li><a target="_blank" href="http://bevacqua.github.io/dragula/">http://bevacqua.github.io/dragula/</a></li>
</ul>
<br />

<h3>Sort elements Inside One Container</h3>
Sort Stuff inside one container is extremely easily. All you need is to drag and drop elements in different positions of the container.
<div class="examples">
  <div class='parent'>
    <div class='wrapper'>
      <div id='sortable' class='container'>
        <div id="sortable-1">Clicking on these elements triggers a regular <code>click</code> event you can listen to.</div>
        <div id="sortable-2">Try dragging or clicking on this element.</div>
        <div id="sortable-3">Note how you can click normally?</div>
        <div id="sortable-4">Drags don't trigger click events.</div>
        <div id="sortable-5">Clicks don't end up in a drag, either.</div>
        <div id="sortable-6">This is useful if you have elements that can be both clicked or dragged.</div>
      </div>
    </div>
  </div>
</div>

<br />
Code Used:
<?php 

echo $ajax->code('
$ajax->dracula(["sortable"]);
');
?>
<br />

<h3>Move elements Between two Containers</h3>
You can also move stuff between two containers, simply pass an array of containers into the first parameter for $ajax->dracula($containers).
<div class='examples'>
  <div class='parent'>
    <div class='wrapper'>
      <div id='left-defaults' class='container'>
        <div id="left-default-1">You can move these elements between these two containers</div>
        <div id="left-default-2">Moving them anywhere else isn't quite possible</div>
        <div id="left-default-3">Anything can be moved around. That includes images, <a href='https://github.com/bevacqua/dragula'>links</a>, or any other nested elements.
        <div id="left-default-4" class='image-thing'><img src='http://bevacqua.github.io/dragula/resources/icon.svg' onerror='this.src="http://bevacqua.github.io/dragula/resources/logo.png"' alt='dragula'/></div><sub>(You can still click on links, as usual!)</sub>
        </div>
      </div>
      <div id='right-defaults' class='container'>
        <div id="right-default-1">There's also the possibility of moving elements around in the same container, changing their position</div>
        <div id="right-default-2">This is the default use case. You only need to specify the containers you want to use</div>
        <div id="right-default-3">More interactive use cases lie ahead</div>
        <div id="right-default-4">Moving <code>&lt;input/&gt;</code> elements works just fine. You can still focus them, too. <input placeholder='See?' /></div>
        <div id="right-default-5">Make sure to check out the <a href='https://github.com/bevacqua/dragula#readme'>documentation on GitHub!</a></div>
      </div>
    </div>
  </div>
</div>

<br />
Code Used:
<?php 

echo $ajax->code('
$ajax->dracula(["left-defaults", "right-defaults"]);
');
?>
<br />

<h3>Copy elements Between two Containers</h3>
You can specify options for the second parameter of $ajax->dracula($containers, $options), $options should be an associative array.
Below is an example of specifying the 'copy' options, which results in elements being copied between two containers, rather than moved/cut.
<div class='examples'>
  <div class='parent'>
    <div class='wrapper'>
      <div id='left-copy' class='container'>
        <div id="left-copy-1">When elements are copyable, they can't be sorted in their origin container</div>
        <div id="left-copy-2">Copying prevents original elements from being dragged. A copy gets created and <em>that</em> gets dragged instead</div>
        <div id="left-copy-3">Whenever that happens, a <code>cloned</code> event is raised</div>
      </div>
      <div id='right-copy' class='container'>
        <div id="right-copy-1">Note that the clones get destroyed if they're not dropped into another container</div>
        <div id="right-copy-2">You'll be dragging a copy, so when they're dropped into another container you'll see the duplication.</div>
      </div>
    </div>
  </div>
</div>

<br />
Code Used:
<?php 

echo $ajax->code('
$ajax->dracula(["left-copy", "right-copy"], ["copy" => true]);
');
?>
<br />

You are also able to quickly delete stuff when it spills out of the chosen containers. Note how you can easily sort the items in any containers by just dragging and dropping.
<div class='examples'>
  <div class='parent'>
    <div class='wrapper'>
      <div id='left-rm-spill' class='container'>
        <div id="left-rm-spill-1">Anxious Cab Driver</div>
        <div id="left-rm-spill-2">Thriving Venture</div>
        <div id="left-rm-spill-3">Such <a href='http://ponyfoo.com'>a good blog</a></div>
        <div id="left-rm-spill-4">Calm Clam</div>
      </div>
      <div id='right-rm-spill' class='container'>
        <div id="left-rm-spill-1">Banana Boat</div>
        <div id="left-rm-spill-2">Orange Juice</div>
        <div id="left-rm-spill-3">Cuban Cigar</div>
        <div id="left-rm-spill-4">Terrible Comedian</div>
      </div>
    </div>
  </div>
</div>

<br />
Code Used:
<?php 

echo $ajax->code('
$dracula->drake(["left-rm-spill", "right-rm-spill"], ["removeOnSpill" => true]);
');
?>
<br />

<h3>Dracula with javascript/AJAX events</h3>
You can also assign events for Dracula, which can be a string of javascript function, or a string that contains the request url for AJAX call.<br />
<ul>
  <li>For javascript functions, they will be registered as callback functions without triggering an AJAX request. It can be useful for simple operations fully on client side.</li>
  <li>An AJAX request will send XML data with new orders of items in affected containers, which you can use to perform server side actions such as saving new orders to database.</li>
  <li>To acquire the orders of elements in your controller, simply call $this->loadElementsOrders() and then you gain access to property $this->elementsOrders.</li>
  <li>In your AJAX controller, you may also accept a parameter $element, which passes the id of the element being dragged/dropped into your controller.</li>
</ul>
For references of Dracula event listeners, check out <a href='https://github.com/bevacqua/dragula#drakeon-events'>all of them</a> in the docs!
<div class='examples'>
  <div class='parent'>
    <div class='wrapper'>
      <div id='left-events' class='container'>
        <div id="left-event-1">As soon as you start dragging an element, a <code>drag</code> event is fired</div>
        <div id="left-event-2">Whenever an element is cloned because <code>copy: true</code>, a <code>cloned</code> event fires</div>
        <div id="left-event-3">The <code>shadow</code> event fires whenever the placeholder showing where an element would be dropped is moved to a different container or position</div>
        <div id="left-event-4">A <code>drop</code> event is fired whenever an element is dropped anywhere other than its origin <em>(where it was initially dragged from)</em></div>
      </div>
      <div id='right-events' class='container'>
        <div id="right-event-1">If the element gets removed from the DOM as a result of dropping outside of any containers, a <code>remove</code> event gets fired</div>
        <div id="right-event-2">A <code>cancel</code> event is fired when an element would be dropped onto an invalid target, but retains its original placement instead</div>
        <div id="right-event-3">The <code>over</code> event fires when you drag something over a container, and <code>out</code> fires when you drag it away from the container</div>
        <div id="right-event-4">Lastly, a <code>dragend</code> event is fired whenever a drag operation ends, regardless of whether it ends in a cancellation, removal, or drop</div>
      </div>
    </div>
  </div>
</div>

<br />
Code Used:
<?php 

echo $ajax->code("
\$events = [\"drag\" => \"function (el) { el.className = el.className.replace('ex-moved', ''); }\",
           \"drop\" => \"ajax.php?dragula/events\", 
           \"over\" => \"function (el, container) { container.className += ' ex-over'; }\",
           \"out\" => \"function (el, container) { container.className = container.className.replace('ex-over', ''); }\"];
\$dracula->containers(['left-events', 'right-events'], [], \$events);
");
?>
<br />

</body>
</html>