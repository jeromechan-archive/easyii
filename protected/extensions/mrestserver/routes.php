<?php
return array(
    'api/<controller:\w+>'=>array('<controller>/MRestGet', 'verb'=>'GET'),
    'api/<controller:\w+>/<id:\w*>'=>array('<controller>/MRestGet', 'verb'=>'GET'),
    'api/<controller:\w+>/<id:\w*>/<var:\w*>'=>array('<controller>/MRestGet', 'verb'=>'GET'),
    'api/<controller:\w+>/<id:\w*>/<var:\w*>/<var2:\w*>'=>array('<controller>/MRestGet', 'verb'=>'GET'),

    array('<controller>/MRestPost', 'pattern'=>'api/<controller:\w+>', 'verb'=>'POST'),
    array('<controller>/MRestPost', 'pattern'=>'api/<controller:\w+>/<id:\w+>', 'verb'=>'POST'),

    array('<controller>/MRestPut', 'pattern'=>'api/<controller:\w+>', 'verb'=>'PUT'),
    array('<controller>/MRestPut', 'pattern'=>'api/<controller:\w+>/<id:\w+>', 'verb'=>'PUT'),

    array('<controller>/MRestDelete', 'pattern'=>'api/<controller:\w+>', 'verb'=>'DELETE'),
    array('<controller>/MRestDelete', 'pattern'=>'api/<controller:\w+>/<id:\w+>', 'verb'=>'DELETE'),

    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
);