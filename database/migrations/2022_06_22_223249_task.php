<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Task extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('customer_created');
            $table->integer('customer_assign');
            $table->string('name')->nullable(); 
            $table->string('start_date')->nullable(); 
            $table->string('end_date')->nullable(); 
            $table->string('type')->nullable(); 
            $table->string('priority')->nullable(); 
            $table->longtext('description')->nullable(); 
            $table->integer('status')->default(0);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
