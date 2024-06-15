<?php

use yii\db\Migration;

/**
 * Class m240430_114636_fill_tables
 */
class m240430_114636_fill_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // спортивно-игровая площадка, для детей 12+ примерно
        $this->insert('municipality', [
            'id' => 1,
            'name' => 'Area 1',
            'sport_tendency' => 5,
            'game_tendency' => 7,
            'education_tendency' => 2,
            'recreation_tendency' => 3,
        ]);

        // спортивная площадка для подростков 15+
        $this->insert('municipality', [
            'id' => 2,
            'name' => 'Area 2',
            'sport_tendency' => 9,
            'game_tendency' => 2,
            'education_tendency' => 2,
            'recreation_tendency' => 2,
        ]);

        // несовместимые вещи. высший приоритет у спорта и развития
        $this->insert('municipality', [
            'id' => 3,
            'name' => 'Area 3',
            'sport_tendency' => 9,
            'game_tendency' => 3,
            'education_tendency' => 9,
            'recreation_tendency' => 4,
        ]);

        // детская площадка - приоритет у развлечений и развития
        $this->insert('municipality', [
            'id' => 4,
            'name' => 'Area 4',
            'sport_tendency' => 2,
            'game_tendency' => 9,
            'education_tendency' => 8,
            'recreation_tendency' => 3,
        ]);

        // площадка для отдыха и легких тренировок для 40+
        $this->insert('municipality', [
            'id' => 5,
            'name' => 'Area 5',
            'sport_tendency' => 5,
            'game_tendency' => 2,
            'education_tendency' => 1,
            'recreation_tendency' => 9,
        ]);

        // максимально среднее все
        $this->insert('municipality', [
            'id' => 6,
            'name' => 'Area 6',
            'sport_tendency' => 5,
            'game_tendency' => 5,
            'education_tendency' => 5,
            'recreation_tendency' => 5,
        ]);


        // В Area 1 суммарно проживает 570 человек (среднее распределение людей)
        $this->insert('ages', [
            'left_age' => 0,
            'right_age' => 4,
            'count' => 44,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 5,
            'right_age' => 9,
            'count' => 101,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 10,
            'right_age' => 18,
            'count' => 132,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 19,
            'right_age' => 25,
            'count' => 74,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 26,
            'right_age' => 35,
            'count' => 81,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 36,
            'right_age' => 55,
            'count' => 77,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 55,
            'right_age' => 130,
            'count' => 61,
            'municipality_id' => 1,
        ]);


        // В Area 2 суммарно проживает 630 человек (уклон в молодежь, мало семей)
        $this->insert('ages', [
            'left_age' => 0,
            'right_age' => 4,
            'count' => 39,
            'municipality_id' => 2,
        ]);

        $this->insert('ages', [
            'left_age' => 5,
            'right_age' => 9,
            'count' => 57,
            'municipality_id' => 2,
        ]);

        $this->insert('ages', [
            'left_age' => 10,
            'right_age' => 18,
            'count' => 120,
            'municipality_id' => 2,
        ]);

        $this->insert('ages', [
            'left_age' => 19,
            'right_age' => 25,
            'count' => 163,
            'municipality_id' => 2,
        ]);

        $this->insert('ages', [
            'left_age' => 26,
            'right_age' => 35,
            'count' => 158,
            'municipality_id' => 2,
        ]);

        $this->insert('ages', [
            'left_age' => 36,
            'right_age' => 55,
            'count' => 54,
            'municipality_id' => 2,
        ]);

        $this->insert('ages', [
            'left_age' => 55,
            'right_age' => 130,
            'count' => 39,
            'municipality_id' => 2,
        ]);

        // В Area 3 суммарно проживает 690 человек (уклон в молодежь и молодые семьи)
        $this->insert('ages', [
            'left_age' => 0,
            'right_age' => 4,
            'count' => 84,
            'municipality_id' => 3,
        ]);

        $this->insert('ages', [
            'left_age' => 5,
            'right_age' => 9,
            'count' => 61,
            'municipality_id' => 3,
        ]);

        $this->insert('ages', [
            'left_age' => 10,
            'right_age' => 18,
            'count' => 153,
            'municipality_id' => 3,
        ]);

        $this->insert('ages', [
            'left_age' => 19,
            'right_age' => 25,
            'count' => 148,
            'municipality_id' => 3,
        ]);

        $this->insert('ages', [
            'left_age' => 26,
            'right_age' => 35,
            'count' => 136,
            'municipality_id' => 3,
        ]);

        $this->insert('ages', [
            'left_age' => 36,
            'right_age' => 55,
            'count' => 73,
            'municipality_id' => 3,
        ]);

        $this->insert('ages', [
            'left_age' => 55,
            'right_age' => 130,
            'count' => 35,
            'municipality_id' => 3,
        ]);

        // В Area 4 суммарно проживает 770 человек (много семей и детей дошкольного/младшего школьного возраста)
        $this->insert('ages', [
            'left_age' => 0,
            'right_age' => 4,
            'count' => 163,
            'municipality_id' => 4,
        ]);

        $this->insert('ages', [
            'left_age' => 5,
            'right_age' => 9,
            'count' => 144,
            'municipality_id' => 4,
        ]);

        $this->insert('ages', [
            'left_age' => 10,
            'right_age' => 18,
            'count' => 101,
            'municipality_id' => 4,
        ]);

        $this->insert('ages', [
            'left_age' => 19,
            'right_age' => 25,
            'count' => 63,
            'municipality_id' => 4,
        ]);

        $this->insert('ages', [
            'left_age' => 26,
            'right_age' => 35,
            'count' => 92,
            'municipality_id' => 4,
        ]);

        $this->insert('ages', [
            'left_age' => 36,
            'right_age' => 55,
            'count' => 138,
            'municipality_id' => 4,
        ]);

        $this->insert('ages', [
            'left_age' => 55,
            'right_age' => 130,
            'count' => 69,
            'municipality_id' => 4,
        ]);

        // В Area 5 суммарно проживает 750 человек (много пожилых людей, которые любят ОФП)
        $this->insert('ages', [
            'left_age' => 0,
            'right_age' => 4,
            'count' => 45,
            'municipality_id' => 5,
        ]);

        $this->insert('ages', [
            'left_age' => 5,
            'right_age' => 9,
            'count' => 71,
            'municipality_id' => 5,
        ]);

        $this->insert('ages', [
            'left_age' => 10,
            'right_age' => 18,
            'count' => 80,
            'municipality_id' => 5,
        ]);

        $this->insert('ages', [
            'left_age' => 19,
            'right_age' => 25,
            'count' => 92,
            'municipality_id' => 5,
        ]);

        $this->insert('ages', [
            'left_age' => 26,
            'right_age' => 35,
            'count' => 103,
            'municipality_id' => 5,
        ]);

        $this->insert('ages', [
            'left_age' => 36,
            'right_age' => 55,
            'count' => 172,
            'municipality_id' => 5,
        ]);

        $this->insert('ages', [
            'left_age' => 55,
            'right_age' => 130,
            'count' => 181,
            'municipality_id' => 5,
        ]);

        // В Area 6 суммарно проживает 400 человек (среднее распределение людей)
        $this->insert('ages', [
            'left_age' => 0,
            'right_age' => 4,
            'count' => 35,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 5,
            'right_age' => 9,
            'count' => 53,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 10,
            'right_age' => 18,
            'count' => 77,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 19,
            'right_age' => 25,
            'count' => 86,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 26,
            'right_age' => 35,
            'count' => 83,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 36,
            'right_age' => 55,
            'count' => 42,
            'municipality_id' => 1,
        ]);

        $this->insert('ages', [
            'left_age' => 55,
            'right_age' => 130,
            'count' => 24,
            'municipality_id' => 1,
        ]);


        // таблица с весами возрастов. создаем и заполняем

        $this->createTable('ages_weight', [
            'id' => $this->primaryKey(),
            'left_age' => $this->integer(),
            'right_age' => $this->integer(),
            'self_weight' => $this->float(),
            'sport_weight' => $this->float(),
            'game_weight' => $this->float(),
            'education_weight' => $this->float(),
            'recreation_weight' => $this->float(),
        ]);

        $this->insert('ages_weight', [
            'left_age' => 0,
            'right_age' => 4,
            'self_weight' => 0.8,
            'recreation_weight' => 0.1,
            'sport_weight' => 0.1,
            'education_weight' => 0.8,
            'game_weight' => 0.6,
        ]);

        $this->insert('ages_weight', [
            'left_age' => 5,
            'right_age' => 9,
            'self_weight' => 0.6,
            'recreation_weight' => 0.3,
            'sport_weight' => 0.2,
            'education_weight' => 0.4,
            'game_weight' => 0.6,
        ]);

        $this->insert('ages_weight', [
            'left_age' => 10,
            'right_age' => 18,
            'self_weight' => 0.5,
            'recreation_weight' => 0.5,
            'sport_weight' => 0.8,
            'education_weight' => 0.1,
            'game_weight' => 0.3,
        ]);

        $this->insert('ages_weight', [
            'left_age' => 19,
            'right_age' => 25,
            'self_weight' => 0.5,
            'recreation_weight' => 0.6,
            'sport_weight' => 0.9,
            'education_weight' => 0.1,
            'game_weight' => 0.2,
        ]);

        $this->insert('ages_weight', [
            'left_age' => 26,
            'right_age' => 35,
            'self_weight' => 0.5,
            'recreation_weight' => 0.6,
            'sport_weight' => 0.6,
            'education_weight' => 0.1,
            'game_weight' => 0.2,
        ]);

        $this->insert('ages_weight', [
            'left_age' => 36,
            'right_age' => 55,
            'self_weight' => 0.6,
            'recreation_weight' => 0.8,
            'sport_weight' => 0.4,
            'education_weight' => 0.1,
            'game_weight' => 0.1,
        ]);

        $this->insert('ages_weight', [
            'left_age' => 55,
            'right_age' => 130,
            'self_weight' => 0.8,
            'recreation_weight' => 0.9,
            'sport_weight' => 0.2,
            'education_weight' => 0.1,
            'game_weight' => 0.1,
        ]);


        $this->insert('object_type', [
            'name' => 'Рекреационный',
        ]);

        $this->insert('object_type', [
            'name' => 'Спортивный',
        ]);

        $this->insert('object_type', [
            'name' => 'Обучающий',
        ]);

        $this->insert('object_type', [
            'name' => 'Игровой',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ages_weight');
        $this->truncateTable('ages');
        $this->truncateTable('municipality');

        return true;
    }
}
