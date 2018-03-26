<?php
global $last_mtime;
$last_mtime = time();
swoole_timer_tick(2000, function () {

    echo "reload";
    reload(ROOT_DIR . '/app/');
    reload(ROOT_DIR . '/core/');
});
/**
 * 重新加载
 * @param $dir
 */
function reload($dir)
{
    global $last_mtime;
    global $server;
    // recursive traversal directory
    $dir_iterator = new \RecursiveDirectoryIterator($dir);
    $iterator = new \RecursiveIteratorIterator($dir_iterator);
    foreach ($iterator as $file) {
        // only check php files
        // check mtime
        $getMTime = $file->getMTime();

        if ($last_mtime < $getMTime) {
            echo $file . " -|lasttime :$last_mtime and getMTime:$getMTime update and reload\n";
            // send SIGUSR1 signal to master process for reload
            $server->reload();
            break;
        }
    }
}

// check files func
