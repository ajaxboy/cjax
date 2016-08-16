<?php


// Function to remove folders and files
function rrmdir($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file)
            if ($file != "." && $file != "..") rrmdir("$dir/$file");
        rmdir($dir);
    }
    else if (file_exists($dir)) unlink($dir);
}

// Function to Copy folders and files
function rcopy($src, $dst, $rm = false) {
    if (file_exists ( $dst ))
        !$rm ||  rrmdir ( $dst );
    if (is_dir ( $src )) {
        is_dir($dst) || mkdir ( $dst );
        $files = scandir ( $src );
        foreach ( $files as $file )
            if ($file != "." && $file != "..")
                rcopy ( "$src/$file", "$dst/$file" );
    } else if (file_exists ( $src ))
        copy ( $src, $dst );
}

if(is_file('composer.json')) {
    $composer = json_decode(file_get_contents('composer.json'));
    if($composer->name == 'codeigniter/framework') {


        copy('cjax/integration/default/ajax.php','application/libraries/ajax.php');
        copy('cjax/integration/codeigniter/ajax.php','ajax.php');
        rcopy('cjax/','application/libraries/cjax');
        rcopy('cjax/integration/codeigniter/application/','application/');

        rrmdir('cjax/');
        unlink('application/libraries/cjax/integration.php');
        @unlink('testing.php');
        @unlink('README.md');

        @unlink(__file__);

        $url = $_SERVER['REQUEST_URI'];
        if(!$_SERVER['QUERY_STRING']) {
            $url = '?test/test';
        }

        exit(header("Location: {$url}"));
    }
}