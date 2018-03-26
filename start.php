<?php
define('ROOT_DIR', __DIR__);
//注册自动加载;采用Phalcon的自动加载
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
    [
        'app' => ROOT_DIR . '/app/',
        'core' => ROOT_DIR . '/core/',
    ]
);
$loader->register();
define("SERVICE_NAME", "REGISTER");# 设置服务名字
$server = new swoole_server('0.0.0.0', 9502, SWOOLE_BASE, SWOOLE_SOCK_TCP);

# 设置运行参数
$server->set(array(
    'daemonize' => false,
));

# 主进程启动
$server->on('Start', function ($server) {
    # 配置自动加载
    var_dump(get_included_files()); //此数组中的文件表示进程启动前就加载了，所以无法reload
    include ROOT_DIR . "/filemonitor.php";

    # 配置更新
    $server->tick(5000,'\core\ConfigInit::update');
});
# Work进行 启动
$server->on('WorkerStart', function ($server, $worker_id){
    # 应用初始化
    \core\App::init($server,$worker_id);
});
# 设置基本回调
$server->on('Connect', '\core\App::connect');
$server->on('Receive', '\core\App::receive');
$server->on('Close', '\core\App::close');



$server->start();
