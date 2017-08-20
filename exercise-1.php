<?php
require_once __DIR__ . '/vendor/autoload.php';

$dba = new Medoo\Medoo([
    'database_type' => 'mysql',
    'database_name' => 'optimization_sample',
    'server' => 'localhost',
    'username' => getenv('USERNAME'),
    'password' => getenv('PASSWORD')
]);

// ユーザのカード一覧を取得する
$query = 'SELECT SQL_NO_CACHE * FROM `user_cards` WHERE `user_id` = :userid; AND `state` = :state';
$now = microtime(true);
$records = $dba->query($query, [':userid' => 100, ':state' => 0])->fetchAll();
$diff = microtime(true) - $now;

printf(
    'Executed Query %s%sExecute time: %.2f ms%s',
    $query,
    PHP_EOL,
    $diff,
    PHP_EOL
);
