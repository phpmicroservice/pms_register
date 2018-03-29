<?php
global $last_mtime;
$last_mtime = time();
#1
swoole_timer_tick(3000, function ($timer_id)use($server) {
    reload(ROOT_DIR.'/core/',$server,$timer_id);
    reload(ROOT_DIR.'/app/',$server,$timer_id);
    reload(ROOT_DIR.'/core/',$server,$timer_id);

});
/**
 * 重新加载
 * @param $dir
 */
function reload($dir,$server,$timer_id)
{
    global $last_mtime;
    // recursive traversal directory
    $dir_iterator = new \RecursiveDirectoryIterator($dir);
    $iterator = new \RecursiveIteratorIterator($dir_iterator);
    foreach ($iterator as $file) {
        if(substr($file,-1) != '.'){
            if(substr($file,-3)=='php'){
                // only check php files
                // check mtime
                $getMTime = $file->getMTime();
                if ($last_mtime < $getMTime) {
                    $last_mtime =time();
                    echo $file . " ---|lasttime :$last_mtime and getMTime:$getMTime update and reload \n";
                    if(in_array($file,get_included_files())){
                        echo  "关闭系统!";
                        $server->shutdown();
                    }else{

                        echo  "重启系统!";
                        $server->reload();
                    }
                    break;
                }
            }
        }
    }
}

// check files func
