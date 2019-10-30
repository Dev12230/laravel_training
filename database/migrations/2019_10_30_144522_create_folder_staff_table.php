<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->integer('folder_id')->unsigned();
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->softDeletes();
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
        Schema::dropIfExists('folder_staff');
    }
}
