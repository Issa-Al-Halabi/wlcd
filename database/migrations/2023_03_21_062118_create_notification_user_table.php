<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notification_user')) {

            Schema::create('notification_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->onDelete('cascade')->nullable();
                $table->foreignId('notification_id')->onDelete('cascade')->nullable();
                $table->boolean('status')->default(0)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_user');
    }
}
