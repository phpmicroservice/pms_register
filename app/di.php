<?php

/**
 * Services are globally registered in this file
 * 服务的全局注册都这里,依赖注入
 */

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Events\Manager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;


//注册自动加载
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
    [
        'app' => ROOT_DIR . '/app/',
        'pms' => ROOT_DIR . '/pms/',
        'tool' => ROOT_DIR . '/tool/',
    ]
);
$loader->register();


/**
 * The FactoryDefault Dependency Injector automatically registers the right
 * services to provide a full stack framework.
 */
$di = new Phalcon\DI\FactoryDefault();

$di->setShared('dConfig', function () {
    #Read configuration
    $config = new Phalcon\Config(require ROOT_DIR . '/config/config.php');
    return $config;
});

$di->setShared('config', function () {
    #Read configuration
    $config = new Phalcon\Config([]);
    return $config;
});

/**
 * 本地缓存
 */
$di->setShared('cache', function () {
    // Create an Output frontend. Cache the files for 2 days
    $frontCache = new \Phalcon\Cache\Frontend\Data(
        [
            "lifetime" => 172800,
        ]
    );

    $cache = new \Phalcon\Cache\Backend\File(
        $frontCache, [
            "cacheDir" => CACHE_DIR,
        ]
    );
    return $cache;
});

/**
 * 全局缓存
 */
$di->setShared('gCache', function () use ($di) {
    // Create an Output frontend. Cache the files for 2 days
    $frontCache = new \Phalcon\Cache\Frontend\Data(
        [
            "lifetime" => 172800,
        ]
    );
    output($di['config']->cache->host,'gCache');
    $op=[ "host" => $di['config']->cache->host,
        "port" => $di['config']->cache->port,
        "auth" => $di['config']->cache->auth,
        "persistent" => $di['config']->cache->persistent,
        'prefix' => $di['config']->cache->prefix,
        "index" => $di['config']->cache->index];
    if(!$di['config']->cache->auth){
        unset($op['auth']);
    }


    $cache = new \Phalcon\Cache\Backend\Redis(
        $frontCache, $op   );
    return $cache;
});


//注册过滤器,添加了几个自定义过滤方法
$di->setShared('filter', function () {
    $filter = new \Phalcon\Filter();
//    $filter->add('json', new \core\Filter\JsonFilter());
    return $filter;
});
//事件管理器
$di->setShared('eventsManager', function () {
    $eventsManager = new \Phalcon\Events\Manager();
    return $eventsManager;
});


//注册过滤器,添加了几个自定义过滤方法
$di->setShared('filter', function () {
    $filter = new \Phalcon\Filter();
//    $filter->add('json', new \core\Filter\JsonFilter());
    return $filter;
});


$di->set(
    "modelsManager", function () {
    return new \Phalcon\Mvc\Model\Manager();
});


$di->setShared('logger', function () {
    $logger = new \pms\Logger\Adapter\MysqlLog('log');
    return $logger;
});


/**
 * Database connection is created based in the parameters defined in the
 * configuration file
 */
$di["db"] = function () use ($di) {
    var_dump($di['config']->database);
    return new DbAdapter(
        [
            "host" => $di['config']->database->app_mysql_host,
            "port" => $di['config']->database->app_mysql_port,
            "username" => $di['config']->database->app_mysql_username,
            "password" => $di['config']->database->app_mysql_password,
            "dbname" => $di['config']->database->app_mysql_dbname,
            "options" => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                \PDO::ATTR_CASE => \PDO::CASE_LOWER,
            ],
        ]
    );
};





