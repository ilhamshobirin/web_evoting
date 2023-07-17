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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('user_name')->unique();
            $table->string('password');
            $table->string('ktp')->unique();
            $table->integer('age')->default('0');
            $table->string('address')->default('');
            $table->integer('user_level')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['name' => 'Admin Utama', 'user_name' => 'admin', 'password' => '$2y$10$BffN3/ssZNYDlKx3Y6E8XOHrZWHEDKOGKuH4424fOB77LmtVPuLg.', 
                'ktp' => '36740420001', 'user_level' => '10',]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
