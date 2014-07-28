<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 *
 * @author chenjinlong
 * @date 7/5/14
 * @time 11:14 PM
 * @description app.php
 */
$appConfig = array(
    'HOST' => '127.0.0.1',
);

$memcache = array(
    'cache' => array(
        'class' => 'system.caching.CMemCache',
        'servers' => array(
            array(
                'host' => '127.0.0.1',
                'port' => '12311',
            ),
            array(
                'host' => '127.0.0.1',
                'port' => '12312',
            )
        ),
    ),
);
