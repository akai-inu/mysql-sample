<?php

function create_table($dba)
{
    $queries = [
        'DROP TABLE IF EXISTS `users`;',
    <<<'EOL'
    CREATE TABLE `users` (
        id int unsigned primary key auto_increment not null,
        name varchar(16) not null,
        level smallint unsigned not null,
        created_at datetime not null,
        updated_at datetime not null,
        deleted_at datetime default null
    );
EOL
    ,
        'DROP TABLE IF EXISTS `user_cards`;',
        <<<'EOL'
    CREATE TABLE `user_cards` (
        id bigint unsigned primary key auto_increment not null,
        user_id int unsigned not null,
        card_id int unsigned not null,
        level smallint unsigned not null,
        created_at datetime not null,
        updated_at datetime not null,
        deleted_at datetime default null
    );
EOL
    ,
        'DROP TABLE IF EXISTS `cards`;',
        <<<'EOL'
    CREATE TABLE `cards` (
        id int unsigned primary key auto_increment not null,
        card_model_id int unsigned not null,
        level int unsigned not null,
        attack int unsigned not null,
        hp int unsigned not null
    );
EOL
    ,
        'DROP TABLE IF EXISTS `card_models`;',
        <<<'EOL'
        CREATE TABLE `card_models` (
          id int unsigned primary key auto_increment not null,
          type tinyint unsigned not null,
          rarity tinyint unsigned not null,
          name varchar(32) not null,
          max_level int unsigned not null,
          description text not null
      );
EOL
    ];

    foreach ($queries as $query) {
       $dba->query($query);
    }
}