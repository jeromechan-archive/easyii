<?php
/**
 * 跨域、编码、时区设置
 */
header("Access-Control-Allow-Origin: *");
//header("Content-Type:text/html;charset=utf-8");
//header(date_default_timezone_set('PRC'));

/**
 * DEBUG模式开关
 */
error_reporting(E_ERROR);
//defined('YII_DEBUG') or define('YII_DEBUG', true);

/**
 * 应用运行环境切换
 */
defined('ENV') or define('ENV', 'stable');

/**
 * 初始化加载
 */
$yii = dirname(__FILE__).'/../../../framework/yii-1.1.15/yiilite.php';
$config = dirname(__FILE__).'/protected/config/' . ENV . '/main.php';
require_once($yii);
Yii::createWebApplication($config)->run();