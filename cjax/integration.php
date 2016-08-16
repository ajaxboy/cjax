<?php


// Function to remove folders and files
function rrmdir($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                rrmdir(rtrim($dir,'/') . '/' . $file);
            }
        }
        if(!@rmdir($dir)) {
           // echo "Could not remove directory $dir <br />";

        }
    } else if (file_exists($dir)) {
        unlink($dir);
    }
}

// Function to Copy folders and files
function rcopy($src, $dst, $rm = false) {
    if (file_exists ( $dst ))
        !$rm ||  rrmdir ( $dst );
    if (is_dir ( $src )) {
        is_dir($dst) || mkdir ( $dst );
        //echo "Copying Directory: $src - $dst <br />";
        $files = scandir ( $src );
        foreach ( $files as $file )
            if ($file != "." && $file != "..")
                rcopy ( rtrim($src,'/') . '/' . $file, rtrim($dst,'/'). '/' . $file);
    } else if (file_exists ( $src )) {
        //echo "Copying File: $src - $dst <br />";
        if(is_file($dst)) {
            unlink($dst);
        }
        if(!rename ( $src, $dst )) {
           // echo "Could not copy file." . "<pre>" . print_r(error_get_last(), 1) . "</pre>";
        }
    }
}
function moveSelf()
{
    $cwd = dirname(__FILE__);
    $dir = dirname($cwd);

    rename(sprintf('%s/cjax/integration/codeigniter/application',$dir),sprintf('%s/application',$dir));
    rename(sprintf('%s/cjax',$dir),sprintf('%s/application/libraries/cjax',$dir));
}
if(is_file('composer.json')) {

    $sanity_check = error_get_last();

    $composer = json_decode(file_get_contents('composer.json'));

    if($composer->name == 'codeigniter/framework') {
        $cwd = dirname(__FILE__);

        $dir = dirname($cwd);

        $files = array(
            '%s/cjax/integration/default/ajax.php' => '%s/application/libraries/ajax.php',
            '%s/cjax/integration/codeigniter/ajax.php' => '%s/ajax.php',
        );

        foreach( $files as $src => $dist) {
            rcopy(sprintf($src, $dir), sprintf($dist,$dir));
        }

        @unlink('testing.php');
        @unlink('README.md');


        if(error_get_last() != $sanity_check) {
           // die(sprintf("The following error occured: <pre>%s</pre>", print_r(error_get_last(),1)));
        }

        register_shutdown_function('moveSelf');

        $url = $_SERVER['REQUEST_URI'];
        if(!$_SERVER['QUERY_STRING']) {
            $url = '?test/test';
        }

        exit(header("Location: {$url}"));
    }
}