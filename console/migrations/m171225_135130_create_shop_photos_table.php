<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_photos`.
 */
class m171225_135130_create_shop_photos_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{shop_photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
            'alt' => $this->string(),
            'title' => $this->string(),
            'is_main' => $this->boolean()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{idx-shop_photos-product_id}}', '{{shop_photos}}', 'product_id');

        $this->addForeignKey('{{fk-shop_photos-product_id}}', '{{shop_photos}}', 'product_id', '{{shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('shop_photos');
    }
}
