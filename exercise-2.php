<?php
require_once __DIR__ . '/vendor/autoload.php';

$dba = new Medoo\Medoo([
    'database_type' => 'mysql',
    'database_name' => 'optimization_sample',
    'server' => 'localhost',
    'username' => getenv('USERNAME'),
    'password' => getenv('PASSWORD')
]);

// ユーザのカード詳細一覧を取得する
$query = <<<'QUERY'
SELECT SQL_NO_CACHE
    *
FROM
    user_cards AS uc
INNER JOIN
    card_models AS cm ON cm.id = uc.card_model_id
INNER JOIN
    cards AS c ON c.card_model_id = cm.id AND c.level = uc.level
WHERE
    user_id = :userid
    AND user_cards.state = :state
;
QUERY;
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
