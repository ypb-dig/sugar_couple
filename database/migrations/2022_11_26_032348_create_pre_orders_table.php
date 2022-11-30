<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("user_uid");
            $table->string("packge_plans");
            $table->unsignedBigInteger('status_order_code_id');
            $table->boolean('payed');
            $table->integer('payment_type')->nullable();
            $table->timestamps();

            // Contrains
            $table->foreign('status_order_code_id')->references('id')->on('status_order_codes');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('pre_orders', function (Blueprint $table) {
            $table->dropForeign('pre_orders_status_order_code_id_foreign');
            $table->dropColumn('status_order_code_id');
        });
        
        Schema::dropIfExists('pre_orders');
    }
}
