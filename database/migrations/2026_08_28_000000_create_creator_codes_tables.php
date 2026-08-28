<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('creatorcodes_creators', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('code', 32)->unique();
            $table->decimal('percentage', 5, 2);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('creatorcodes_bindings', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary();
            $table->unsignedInteger('creator_id');
            $table->string('code', 32);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('creator_id')->references('id')->on('creatorcodes_creators')->cascadeOnDelete();
        });

        Schema::create('creatorcodes_payments', function (Blueprint $table) {
            $table->unsignedInteger('payment_id')->primary();
            $table->unsignedInteger('creator_id');
            $table->string('code', 32);
            $table->decimal('percentage', 5, 2);
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('creatorcodes_creators')->cascadeOnDelete();
        });

        Schema::create('creatorcodes_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('buyer_id');
            $table->unsignedInteger('payment_id')->nullable()->unique();
            $table->string('code', 32);
            $table->decimal('percentage', 5, 2);
            $table->decimal('neos_bought', 12, 2);
            $table->decimal('neos_rewarded', 12, 2);
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('creatorcodes_creators')->cascadeOnDelete();
            $table->foreign('buyer_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creatorcodes_rewards');
        Schema::dropIfExists('creatorcodes_payments');
        Schema::dropIfExists('creatorcodes_bindings');
        Schema::dropIfExists('creatorcodes_creators');
    }
};
