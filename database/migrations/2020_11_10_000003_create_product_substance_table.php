<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProductSubstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->statement
        (
            "CREATE TABLE `product_substance` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `product_id` int(10) unsigned NOT NULL,
              `substance_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`) USING BTREE,
              KEY `product_id` (`product_id`) USING BTREE,
              KEY `substance_id` (`substance_id`) USING BTREE,
              CONSTRAINT `product_substance_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
              CONSTRAINT `product_substance_ibfk_2` FOREIGN KEY (`substance_id`) REFERENCES `substances` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::getConnection()->statement
        (
            "DROP TABLE IF EXISTS `product_substance`;"
        );
    }

}
