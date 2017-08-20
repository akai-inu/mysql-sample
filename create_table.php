<?php

function create_table($dba)
{
    $queries = [
        'DROP TABLE IF EXISTS `users`;',
    <<<'EOL'
    CREATE TABLE `users` (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
        state TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '0=存在,1=削除済',
        name VARCHAR(16) NOT NULL,
        level SMALLINT UNSIGNED NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL
    );
EOL
    ,
        'DROP TABLE IF EXISTS `user_cards`;',
        <<<'EOL'
    CREATE TABLE `user_cards` (
        id bigINT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
        state TINYINT UNSIGNED NOT NULL COMMENT '0=所持中,1=受け取りBOX,2=削除済',
        user_id INT UNSIGNED NOT NULL,
        card_id INT UNSIGNED NOT NULL,
        level SMALLINT UNSIGNED NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL
    );
EOL
    ,
        'DROP TABLE IF EXISTS `cards`;',
        <<<'EOL'
    CREATE TABLE `cards` (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
        card_model_id INT UNSIGNED NOT NULL,
        level INT UNSIGNED NOT NULL,
        attack INT UNSIGNED NOT NULL,
        hp INT UNSIGNED NOT NULL
    );
EOL
    ,
        'DROP TABLE IF EXISTS `card_models`;',
        <<<'EOL'
        CREATE TABLE `card_models` (
          id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
          type TINYINT UNSIGNED NOT NULL,
          rarity TINYINT UNSIGNED NOT NULL,
          name VARCHAR(32) NOT NULL,
          description TEXT NOT NULL
      );
EOL
    ];

    foreach ($queries as $query) {
       $dba->query($query);
    }
}