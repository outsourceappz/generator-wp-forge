<?php

use Illuminate\Database\Capsule\Manager as DB_Capsule;
use Illuminate\Database\Migrations\Migration;

class Create<%= changeCase.title(props.tableName).replace(/ /g, "") %>Table extends Migration
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
            $table->float('price');
            $table->string('csv_file');
            $table->timestamps();
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
