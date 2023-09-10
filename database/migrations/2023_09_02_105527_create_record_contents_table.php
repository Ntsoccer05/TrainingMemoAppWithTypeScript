<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_contents', function (Blueprint $table) {
            $table->id();
            //外部キーに紐づくテーブルはreferences->onかconstrained
            $table->foreignId('user_id')->constrained('users');
            //外部キーの制約（null許容）はforeignIdの直後
            $table->foreignId('category_id')->nullable()->references('id')->on('categories');
            $table->foreignId('menu_id')->nullable()->constrained();
            $table->foreignId('record_states_id')->nullable()->constrained();
            $table->integer('weight')->nullable();
            $table->integer('right-weight')->nullable();
            $table->integer('left-weight')->nullable();
            $table->integer('set')->nullable();
            $table->integer('rep')->nullable();
            $table->string('memo')->nullable();
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
        Schema::dropIfExists('record_contents');
    }
};
