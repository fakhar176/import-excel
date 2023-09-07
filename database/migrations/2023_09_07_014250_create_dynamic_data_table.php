<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uploaded_file_id');
            $table->string('column_name');
            $table->string('data_type');
            $table->text('cell_value');
            $table->timestamps();
            // Define foreign key constraint
            $table->foreign('uploaded_file_id')->references('id')->on('uploaded_files')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dynamic_data');
    }
}
