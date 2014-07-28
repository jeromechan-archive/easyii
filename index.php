<?php
header("Access-Control-Allow-Origin: *");
$yii = dirname(__FILE__).'/../../../framework/yii-1.1.15/yiilite.php';
$config=dirname(__FILE__).'/protected/config/main.php';

define('YII_DEBUG', true);

require_once($yii);
Yii::createWebApplication($config)->run();