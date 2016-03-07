<?php

use Illuminate\Database\Capsule\Manager as DB_Capsule;
use Illuminate\Database\Migrations\Migration;

class <%= schemaHelper.camelToClassName(props.fileNameSuffix) %> extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB_Capsule::schema()->create('<%= props.tableNameSingular1 %>_<%= props.tableNameSingular2 %>', function ($table) {

            $table->bigInteger('<%= props.tableNameSingular1 %>_id')->unsigned()->index();
            $table->foreign('<%= props.tableNameSingular1 %>_id')->references('id')->on('<%= props.tableName1 %>')->onDelete('cascade');
            $table->bigInteger('<%= props.tableNameSingular2 %>_id')->unsigned()->index();
            $table->foreign('<%= props.tableNameSingular2 %>_id')->references('id')->on('<%= props.tableName1 %>')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB_Capsule::schema()->drop('<%= props.tableNameSingular1 %>_<%= props.tableNameSingular2 %>');
    }
}
