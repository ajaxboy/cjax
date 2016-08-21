<?php

class Params {


    function data($data, $data2)
    {

        $ajax = ajax();

        $ajax->info($data . ' ' . $data2, 6);

    }

}