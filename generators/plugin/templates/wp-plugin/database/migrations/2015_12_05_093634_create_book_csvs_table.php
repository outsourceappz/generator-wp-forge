<?php

use Illuminate\Database\Capsule\Manager as DB_Capsule;
use Illuminate\Database\Migrations\Migration;

class CreateBookCsvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB_Capsule::schema()->create('book_csvs', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->float('price');
            $table->string('csv_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB_Capsule::schema()->drop('book_csvs');
    }
}
