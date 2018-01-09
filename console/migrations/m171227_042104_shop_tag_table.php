<?php

use yii\db\Migration;

/**
 * Class m171227_042104_shop_tag_table
 */
class m171227_042104_shop_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull()->unique(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_tags-slug}}', '{{%shop_tags}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_tags}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171227_042104_shop_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
