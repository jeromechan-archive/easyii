<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 *
 * @author chenjinlong
 * @date 7/5/14
 * @time 11:14 PM
 * @description main.php
 */
require_once(dirname(__FILE__).'/url_manager.php');
require_once(dirname(__FILE__).'/database.php');
require_once(dirname(__FILE__).'/app.php');

$urlManager = array(
    'urlManager'=>array(
        'urlFormat'=>'path',
        'rules'=> require(dirname(__FILE__).'/../extensions/mrestserver/routes.php'),
        'caseSensitive' => false,
    ),
);

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'import'=>array(
        'application.extensions.mrestserver.*',
        'application.extensions.mrestclient.*',
        'application.models.*',
    ),
    'components'=>array_merge($urlManager, $databaseConfig),
    'modules'=>array(
        'module_name',
    ),
    'params'=>$appConfig,
);