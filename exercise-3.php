<?php
require_once __DIR__ . '/vendor/autoload.php';

$dba = new Medoo\Medoo([
    'database_type' => 'mysql',
    'database_name' => 'optimization_sample',
    'server' => 'localhost',
    'username' => getenv('USERNAME'),
    'password' => getenv('PASSWORD')
]);

// ユーザのレベルランキングを取得する
$query = <<<'QUERY'
SELECT SQL_NO_CACHE
    *
FROM
    `users`
WHERE
    `state` = :state
ORDER BY
    level DESC
LIMIT
    100
;
QUERY;
$now = microtime(true);
$records = $dba->query($query, [':state' => 0])->fetchAll();
$diff = microtime(true) - $now;

printf(
    'Executed Query %s%sExecute time: %.2f ms%s',
    $query,
    PHP_EOL,
    $diff,
    PHP_EOL
);
