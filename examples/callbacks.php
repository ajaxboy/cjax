<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$ajax->button1 = $ajax->form(array('controller','method'));


$ajax->on('success',
    array(
        $ajax->click('button3', array(
                $ajax->alert('{response}'),
                $ajax->prop(array('value' => 'Button 3'))
            )
        ),
        $ajax->prop(array('value' => '{response}')),
        $ajax->prop(array('value' => '{response}'),'button3'),
        $ajax->flush('button1'),
        $ajax->click('button1', array(
            $ajax->success('{response}'),
        ))
    )
);


$ajax->click('button2', $ajax->call(array('controller','error')));

$ajax->on('error', $ajax->error('oh No! an error ocurred'));


$ajax->click('button4', $ajax->overlayContent("Testing on-overlayPop!"));

$ajax->on('overlayPop', $ajax->success('overlayPop callback here!'));

$ajax->on('bubbles', $ajax->info('{response}'));


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>ajax Callbacks</title>
    <?php echo $ajax->init(false);?>
</head>
<body>
<header>
    <div style='padding: 15px;'>
        <a href='http://cjax.sourceforge.net'><img src='http://cjax.sourceforge.net/media/logo.png' border=0/></a>
    </div>
</header>
<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"></div></div>
<div id="nav2"><a name="top">&nbsp;</a></div>
<div id="masthead">
    <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
        <tr>
            <td><h1>Cjax Framework</h1></td>
            <td id="breadcrumb_right"><a href="#">Demos</a></td>
        </tr>
    </table>
</div>
<!-- END NAVIGATION -->



<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
    <tr>
        <td id="breadcrumb">
            <a href="http://cjax.sourceforge.net/">Project Home</a> &nbsp;&#8250;&nbsp;
            <a href="./">Demos</a> &nbsp;&#8250;&nbsp;
            Ajax Callbacks
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

    <div style="margin: 20px;"> <div style="font-size: 12px;padding: 5px;">Project development is new to github. Give us a <span id="star">star</span>.</div>
        <iframe id='istar' src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
        <iframe src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=watch&count=true&v=2" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
    </div>

    <h2>Built-in &amp; Custom Callbacks</h2>

    <p>
        <!-- Text -->
        When you make an ajax request, some times you want do something extra with the response of your ajax call, here is where the callback
        system takes place. There are callbacks also available for other events. In addition, you can create custom callbacks, see some examples below.


    </p>



    <h3>Examples</h3>

    <?php

    echo $ajax->code("

     \$ajax->button1 = \$ajax->form(array('controller','method'));
     \$ajax->on('success', \$ajax->alert('{response}'));
     \$ajax->on('error', \$ajax->error('{response}'));
     \$ajax->on('complete', \$ajax->overlayContent('{response}'));

     \$ajax->on('overlayPop', \$ajax->success('An overlay has popped up!'));

    ");
    ?>

    <p>
        Consider the following - an ajax form assigned to a button, that has the id 'button1'.
        <br />
        You can wrap triggers inside the on()  method, you can also assign further actions.
        <br />
        The following actions have no specific purpose, but it shows you an example how you may pass multiple
        actions, and trigger inside the on() callback method. You can also use the tag {response} to replace with the
        actual response of the ajax request. The success callback will only trigger after the ajax request is completed
        and the server response was not an error status code.

    </p>
    <?php
    echo $ajax->code("

     \$ajax->button1 = \$ajax->form(array('controller','method'));


    \$ajax->on('success',
        array(
            \$ajax->click('button3', array(
                    \$ajax->alert('{response}'),
                    \$ajax->prop(array('value' => '{response}'))
                )
            ),
            \$ajax->prop(array('value' => '{response}')),
            \$ajax->prop(array('value' => '{response}'),'button3'),
            \$ajax->flush('button1'),
            \$ajax->click('button1', array(
                \$ajax->success('{response}'),
            ))
        )
    );



    //Add error callback to #button2
    \$ajax->click('button2', \$ajax->call(array('controller','error')));

    \$ajax->on('error', \$ajax->error('oh No! an error ocurred'));


     //add overlayPop callback to #button4
    \$ajax->click('button4', \$ajax->overlayContent('Testing on-overlayPop!'));

    \$ajax->on('overlayPop', \$ajax->success('overlayPop callback here!'));

    ",true, 'flip');
    ?>


    <form>
        <div class="form">
            <div>
                <div>
                    <input type="button" id="button1" value="Success Callback" />
                </div>
                <div>
                    <input type="button" id="button2" value="Error Callback" />
                </div>
            </div>
            <div>
                <div>
                    <input type="button" id="button3" value="Do Nothing" />
                </div>
                <div>
                    <input type="button" id="button4" value="OverlayPop" />
                </div>
            </div>
        </div>
    </form>
    <!-- Code Used -->

    <h4>On Error</h4>

    <p>
    You can catch all, error() responses through the error() callback. You can also catch individual errors responses
    depending on the error response status.
    </p>
    <h5>Error responses you can catch</h5>
    <?php
        echo $ajax->code("
        \$ajax->on('error400', \$ajax->[function]);
        \$ajax->on('error403', \$ajax->[function]);
        \$ajax->on('error404', \$ajax->[function]);
        \$ajax->on('error500', \$ajax->[function]);
        \$ajax->on('error530', \$ajax->[function]);
        ");
        ?>
    </p>
    <p class="note">
        You can catch any error status returned by the server. However, there is a contrast between server errors and php errors.
        Some times the server's response is a 200 (success) status even if there is a php error. In these cases, none of the errors callbacks would  trigger.
        The response then would be considered success.
    </p>
    <!-- HTML -->

    <h4>Built-in callbacks you can use</h4>
    <?php
    echo $ajax->code("
        \$ajax->on('success', \$ajax->[function]);
        \$ajax->on('error', \$ajax->[function]);  //along with all the error statuses
        \$ajax->on('complete', \$ajax->[function]);
        \$ajax->on('overlayPop', \$ajax->[function]);
        ");
    ?>
    </p>
    <br />

    <h4>Custom Callbacks</h4>
    <p class="info">
        <span class="req">Important</span>
        <br />In addition to the provided callbacks indentified on this page, you can also create custom callbacks.
        Which can be accessible through any plugin or through simply JavaScript everywhere on your site.
        You may name your custom callback, anything you like.
        <br />
        <br />
        You may access this callback through a plugin or simply through JavaScript from anywhere:  CJAX.callback.callbackName();
        (just change 'callbackName' for the action name of the callback you invoked.
        <br />

    </p>

    <h5>Examples of custom callbacks</h5>

    <?php
    echo $ajax->code("
        \$ajax->on('bubbles', \$ajax->info('Making Bubbles!'));

        \$ajax->on('dancing', \$ajax->dance()); // triggers a fictional plugin or a existing function called dance!

        \$ajax->on('swimming', \$ajax->swim())); //triggers a fictional plugin or a existing function called swim().

        ");
    ?>

    <?php
    echo $ajax->code("

          //would trigger, bubble callback, which would display an info message saying \"Making Bubbles!\"
          CJAX.callback.bubble();

          //would trigger the dancing callback, this could be used anywhere on your site, or within a custom plugin.
          CJAX.callback.dancing();

          //Would trigger the swimming custom callback called swimming()
          CJAX.callback.swimming();


          //To be on the safe side, you may want to add a check to make sure the callback exists eg:

          if(CJAX.callback.bubble) {
            CJAX.callback.bubble();
          }

        ","JAVASCRIPT");
    ?>
    </p>

    <p>
        You may pass a parateter to your custom callbacks. It would be accessible retroactively to your callback declaration through
        the {response} tag.
    </p>

    <?php
    echo $ajax->code("
        \$ajax->on('bubbles', \$ajax->info('{response}'));


        ");
    ?>


    <?php
    echo $ajax->code("

          //use the CJAX.ready() method if you call the function directly on page load.

          CJAX.ready(function() {

            if(CJAX.callback.bubble) {
                CJAX.callback.bubble('Making Bubble!');
            }

          });

        ","JAVASCRIPT");
    ?>

    <p>
       You can also put your JS directly on the element, as shown below:
    </p>

    <?php
    echo $ajax->code("

           <input type=\"button\" id=\"custom_button1\" value=\"Make Bubbles!\" onclick=\"javascript:CJAX.callback.bubbles('Making Bubble!');\"/>


        ","HTML", true);
    ?>

    <div class="form">
        <div>
            <div>
                <input type="button" id="custom_button1" onclick="javascript:CJAX.callback.bubbles('Making Bubble!');" value="Make Bubbles!" />
            </div>
            <div>
                &nbsp;
            </div>
        </div>

    </div>

    <br />
</div>
<!-- END CONTENT -->

<div id="myfooter">
    <p>
        Previous Topic:&nbsp;&nbsp;<a href="#">Previous Class</a>
        &nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
        <a href="#top">Top of Page</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
        <a href="http://cjax.sourceforge.net/examples">Demos Home</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
        <!-- Next Topic:&nbsp;&nbsp;<a href="#">Next Class</a> -->
    </p>
    <p>
        <a href="http://codeigniter.com">CodeIgniter</a> &nbsp;&middot;&nbsp; Copyright &#169; 2006 - 2012 &nbsp;&middot;&nbsp;
        <a href="http://cjax.sourceforge.net/">Cjax</a>
    </p>
</div>

</body>
</html>
