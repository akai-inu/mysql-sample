<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/BufferInserter.php';
require_once __DIR__ . '/create_table.php';
require_once __DIR__ . '/create_records.php';

$dba = new Medoo\Medoo([
    'database_type' => 'mysql',
    'database_name' => 'optimization_sample',
    'server' => 'localhost',
    'username' => getenv('USERNAME'),
    'password' => getenv('PASSWORD')
]);

create_table($dba);
create_records($dba, 500000);
echo PHP_EOL;
