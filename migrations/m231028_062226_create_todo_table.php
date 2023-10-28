<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%todo}}`.
 */
class m231028_062226_create_todo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%todo}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->boolean(),
            'date' => $this->date(),
            'create_at' =>  $this->dateTime()->defaultExpression("NOW()"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%todo}}');
    }
}
