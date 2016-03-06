<?php

use Illuminate\Database\Capsule\Manager as DB_Capsule;
use Illuminate\Database\Migrations\Migration;

class Create<%= schemaHelper.camelToClassName(props.tableName) %>Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB_Capsule::schema()->create('<%= props.tableName %>', function ($table) {
            $table->bigIncrements('id')->unsigned();
            <% for(var i = 0; i < props.fields.length; i++) {%><%-  props.fields[i].join('->')  %>;
            <% } %>$table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB_Capsule::schema()->drop('<%= props.tableName %>');
    }
}
