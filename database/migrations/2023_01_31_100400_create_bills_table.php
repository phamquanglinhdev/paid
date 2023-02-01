<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->foreign("student_id")->references("id")->on("users");
            $table->unsignedBigInteger("staff_id");
            $table->foreign("staff_id")->references("id")->on("users");
            $table->string("method");
            $table->integer("amount");
            $table->date("start");
            $table->date("end");
            $table->longText("image")->nullable();
            $table->integer("disable")->default(0);
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
        Schema::dropIfExists('bills');
    }
};
