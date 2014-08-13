<?php
/**
 * Coypright © 2014 Jerome Chan. All rights reserved.
 * Author: chenjinlong
 * Date: 7/5/14
 * Time: 2:36 AM
 * Description: database.php
 */
$databaseConfig = array(
    'myii_master'=>array(
        'connectionString' => 'mysql:host=127.0.0.1;dbname=myii;port=3306',
        'emulatePrepare' => false,
        'username' => 'root',
        'password' => 'root',
        'class' => 'CDbConnection',
        'charset' => 'utf8',
		'autoConnect'=>false
    ),
);
