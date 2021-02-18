<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scraping_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account')->nullable();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->string('message')->nullable();
            $table->string('timestamp_id')->nullable();
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
        Schema::dropIfExists('scraping_lists');
    }
}
