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
        DB_Capsule::schema()->table('<%= props.tableName %>', function ($table) {
            <% for(var i = 0; i < props.fields.length; i++) {%><%-  props.fields[i].join('->')  %>;
            <% } %>
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB_Capsule::schema()->table('<%= props.tableName %>', function ($table) {
            <% for(var i = 0; i < props.fieldNames.length; i++) {%>$table->dropColumn('<%-  props.fieldNames[i]%>');
            <% } %>
        });
    }
}
