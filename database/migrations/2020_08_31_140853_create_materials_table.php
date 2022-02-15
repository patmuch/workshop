<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('material_name');
            $table->string('material_code')->unique();
            $table->text('description');
            $table->integer('reorder_level');
            $table->decimal('costprice',10,2)->default('0.00');
            $table->integer('quantity')->default('0');
            $table->integer('committed')->default('0');
            $table->bigInteger('material_category_id')->unsigned();
            $table->bigInteger('uom_id')->unsigned();
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
        Schema::dropIfExists('materials');
    }
}
