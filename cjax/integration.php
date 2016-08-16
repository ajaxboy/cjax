<?php


// Function to remove folders and files
function rrmdir($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                rrmdir("$dir/$file");
            }
        }
        rmdir($dir);
    } else if (file_exists($dir)) {
        unlink($dir);
    }
}

// Function to Copy folders and files
function rcopy($src, $dst, $rm = false) {
    if (file_exists ( $dst ))
        !$rm ||  rrmdir ( $dst );

    echo "Copying $src - $dst <br />";
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
        $cwd = dirname(__FILE__);

        $dir = dirname($cwd);

        $files = array(
            '%s/cjax/integration/default/ajax.php' => '%s/application/libraries/ajax.php',
            '%s/cjax/integration/codeigniter/ajax.php' => '%s/ajax.php',
            '%s/cjax/integration/codeigniter/application/' => '%s/application/',
            '%s/cjax/' => '%s/application/libraries/cjax'
        );

        foreach( $files $ $src => $dist) {
            rcopy(sprintf($src, $dir), sprtinf($dist,$dir));
        }

        unlink(sprintf('%s/application/libraries/cjax/ajax.php',$dir));
        @unlink('testing.php');
        @unlink('README.md');
        rrmdir(sprintf('%s/cjax',$dir));

        @unlink(__file__);

        $url = $_SERVER['REQUEST_URI'];
        if(!$_SERVER['QUERY_STRING']) {
            $url = '?test/test';
        }

        exit(header("Location: {$url}"));
    }
}