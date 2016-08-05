<?php


Class Call {


    public function options()
    {

        ajax()->alert(print_r(func_get_args(),1));
    }

    public function cache()
    {
        $message = "
         The ajax request you made when you clicked the link triggered this overlay from the backend.
         <br />
         controller file: examples/controllers/call.php method name is cache().
         <br />
         The overlay is not part of this demo on itself, it is just data being cache.
         <br />
         Anything, any response would otherwise be cache.
         <br />
         if you click the link again it will trigger this overlay window again,
         <br />
         only the ajax request is not longer made.
         <br />
         You can use this option to cache large amounts of data, and make less requests to the server.
         <br />
        ";

        ajax()->dialog($message, 'Cached');
    }

    public function container()
    {
        echo "This text was echo'ed from the ajax controller.";
    }

    public function confirm()
    {
        $ajax = ajax();
        $ajax->info("You clicked yes,  then lets do some dangerous operation that required confirmation!", 8);
    }

}