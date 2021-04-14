<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->date('date')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}
