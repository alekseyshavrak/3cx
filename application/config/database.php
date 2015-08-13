<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
    'default' => array
    (
        'type'       => 'PostgreSQL',
        'connection' => array(
            'hostname'   => 'localhost',
            'port'       => '5480',
            'username'   => 'username',
            'password'   => 'password',
            'database'   => 'database',
            'ssl'        => FALSE,
        ),
        'primary_key'  => '',   // Column to return from INSERT queries, see #2188 and #2273
        'schema'       => '',
        'table_prefix' => FALSE,
        'charset'      => 'utf8',
        'caching'      => FALSE,
    ),
);