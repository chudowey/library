<?php

use yii\db\Migration;

/**
 * Class m180522_203332_add_user_init
 */
class m180522_203332_add_user_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            '[[username]]'      => 'admin',
            '[[email]]'         => 'admin@admin.admin',
            '[[password_hash]]' => '$2y$13$8rCtmww3NL/ENpk.tvQGSelxXfF3nz.cPMxQNjvgt1LHpSdBcYbwy',
            '[[role]]'          => \common\models\User::ROLE_EMPLOYEE,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
