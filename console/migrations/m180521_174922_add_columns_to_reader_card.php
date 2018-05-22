<?php

use yii\db\Migration;

/**
 * Class m180521_174922_add_columns_to_reader_card
 */
class m180521_174922_add_columns_to_reader_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   
        $this->addColumn('{{%reader_card}}', '[[status]]', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%reader_card}}', '[[status]]');
    }
}
