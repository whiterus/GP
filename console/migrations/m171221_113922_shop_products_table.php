<?php

use yii\db\Migration;

/**
 * Class m171221_113922_productsTable
 */
class m171221_113922_shop_products_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'title' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'meta_json' => 'JSON NOT NULL',
            'price' => $this->integer(),
            'available' => $this->integer(),
            'category_id' => $this->integer()->notNull(),
            'comment_count' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%shop_products}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171221_113922_productsTable cannot be reverted.\n";

        return false;
    }
    */
}
