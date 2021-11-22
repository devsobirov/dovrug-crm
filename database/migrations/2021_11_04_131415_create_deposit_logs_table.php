<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('depository_id')->constrained('depositories');
            $table->foreignId('user_id')->constrained('users');
            $table->string('description')->nullable();
            $table->string('amount');
            $table->integer('type');
            $table->string('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_logs');
    }
}
