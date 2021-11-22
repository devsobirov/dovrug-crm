<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->foreignId('depository_id')->constrained('depositories');
            $table->foreignId('material_id')->constrained('materials');
            $table->string('balance')->nullable()->default(0);
            
            $table->boolean('triggered')->default(false);
            $table->boolean('on_stock')->default(false);

            $table->unique(['material_id','depository_id'], 'material_in_depository');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
