<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'username' => $this->string()->unique(),
            'surname' => $this->string(),
            'lastname' => $this->string(),
            'email' => $this->string()->notNull(),
            'birthday' => $this->timestamp(),
            'role' => $this->tinyInteger()->defaultValue(1),
            'status' => $this->tinyInteger()->defaultValue(10),
            'address' => $this->string(),
            'phone' => $this->string(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%departments}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'address' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%racks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'genre' => $this->string(),
            'publishing' => $this->string(),
            'public_date' => $this->string()->notNull(),
            'pages' => $this->smallInteger(),
            'departament_id' => $this->integer(),
            'rack_id' => $this->integer(),
            'count' => $this->smallInteger(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%reader_card}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'reader_id' => $this->integer(),
            'employee_id' => $this->integer(),
            'date_operation' => $this->timestamp()->notNull(),
            'date_return' => $this->timestamp(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%departments}}');
        $this->dropTable('{{%racks}}');
        $this->dropTable('{{%books}}');
        $this->dropTable('{{%reader_card}}');
    }
}
