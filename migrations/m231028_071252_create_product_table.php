<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m231028_071252_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->decimal(10,0)->notNull(),
            'image_url' => $this->string()->notNull(),
            'sub_title' => $this->string(),
            'description' => $this->text(),
            'status' => $this->tinyInteger(),
            'created_at' => $this->dateTime()->defaultExpression("NOW()"),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
