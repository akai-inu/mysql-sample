<?php

function get_datetime_list($faker)
{
    $created_at = $faker->dateTimeBetween('-1 years')->format('Y-m-d H:i:s');
    $updated_at = $faker->dateTimeBetween($created_at)->format('Y-m-d H:i:s');
    $deleted_at = ($faker->boolean(10) ? $updated_at : null);
    return compact('created_at', 'updated_at', 'deleted_at');
}

function create_records($dba, $user_count = 500000, $card_count = 300)
{
    $faker = Faker\Factory::create();
    $faker->seed(1);

    // insert card_models
    $buffer = new BufferInserter($dba, 'card_models');
    for ($i = 0; $i < $card_count; $i++) {
        $buffer->push([
            'id' => $i + 1,
            'type' => $faker->numberBetween(0, 10),
            'rarity' => $faker->numberBetween(1, 5),
            'name' => $faker->word,
            'max_level' => 99,
            'description' => $faker->text(256),
        ]);
    }
    $buffer->finish();
    printf(
        'inserted %d records to %s%s',
        $buffer->getTotal(),
        $buffer->getTable(),
        PHP_EOL
    );

    // insert cards
    $buffer = new BufferInserter($dba, 'cards');
    for ($i = 0; $i < $card_count; $i++) {
        $rarity = $faker->numberBetween(1, 5);
        $attack_base = $faker->numberBetween(100, 500);
        $hp_base = $faker->numberBetween(100, 500);
        for ($level = 1; $level < 99; $level++) {
            $buffer->push([
                'card_model_id' => $i + 1,
                'level' => $level,
                'attack' => $attack_base + $level * 50,
                'hp' => $hp_base + $level * 50,
            ]);
        }
    }
    $buffer->finish();
    printf(
        'inserted %d records to %s%s',
        $buffer->getTotal(),
        $buffer->getTable(),
        PHP_EOL
    );

    // insert users
    $buffer = new BufferInserter($dba, 'users');
    for ($i = 0; $i < $user_count; $i++) {
        $buffer->push(array_merge([
            'id' => $i + 1,
            'name' => $faker->word,
            'level' => $faker->numberBetween(1, 255),
        ], get_datetime_list($faker)));
    }
    $buffer->finish();
    printf(
        'inserted %d records to %s%s',
        $buffer->getTotal(),
        $buffer->getTable(),
        PHP_EOL
    );

    // insert user_cards
    $buffer = new BufferInserter($dba, 'user_cards');
    for ($i = 0; $i < $user_count; $i++) {
        for ($j = 0; $j < $faker->numberBetween(10, 500); $j++) {
            $buffer->push(array_merge([
                'user_id' => $i + 1,
                'card_id' => $faker->numberBetween(1, $card_count - 1),
                'level' => $faker->numberBetween(1, 99),
            ], get_datetime_list($faker)));
        }
    }
    $buffer->finish();
    printf(
        'inserted %d records to %s%s',
        $buffer->getTotal(),
        $buffer->getTable(),
        PHP_EOL
    );
}