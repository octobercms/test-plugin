<?php

use October\Rain\Database\Updates\Migration;

/**
 * Drops the october_test tables left by earlier versions, as fixture-only tooling for the edit-in-place and plugin:refresh workflow that should not be copied.
 */
return new class extends Migration
{
    public function up()
    {
        $prefix = Db::getTablePrefix();

        // Laravel lists the tables of every schema the connection can see, so only list the current one
        foreach (Schema::getTableListing(Schema::getCurrentSchemaName(), false) as $table) {
            if (str_starts_with($table, $prefix . 'october_test_')) {
                Schema::drop(substr($table, strlen($prefix)));
            }
        }
    }

    public function down()
    {
    }
};
