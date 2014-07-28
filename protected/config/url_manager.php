<?php
/**
 * Copyright © 2014 Jerome Chan. All rights reserved.
 *
 * @author chenjinlong
 * @date 7/5/14
 * @time 11:14 PM
 * @description url_manager.php
 */
$common_rules = array(
    '<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
    'prefix/<modules:\w+>/views/<controller:\w+>/<action:\w+>'=>'<modules>/views/<controller>/<action>',
    //require dirname(__FILE__).'/../extensions/starship/RestfullYii/config/routes.php'
);
