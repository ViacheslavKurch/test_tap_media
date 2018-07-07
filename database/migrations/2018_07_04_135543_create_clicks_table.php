<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('ua');
            $table->string('ip', 20);
            $table->string('ref');
            $table->string('param1');
            $table->string('param2');
            $table->integer('error')->default(0);
            $table->tinyInteger('bad_domain')->default(0);
            $table->unique('id');

            $table->unique(['ua', 'ip', 'ref', 'param1'], 'unique_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clicks');
    }
}
