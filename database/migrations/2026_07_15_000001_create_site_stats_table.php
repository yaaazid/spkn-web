<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_stats', function (Blueprint $table) {
            $table->id();
            $table->string('icon');   // nama icon Bootstrap Icons, mis. "bi-people-fill"
            $table->string('value');  // mis. "1.500+"
            $table->string('label');  // mis. "Pengunjung Bulan Ini"
            $table->unsignedInteger('order')->default(0); // urutan tampil di hero
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_stats');
    }
};