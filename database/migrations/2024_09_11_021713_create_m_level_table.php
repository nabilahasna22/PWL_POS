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
        Schema::create('m_level', function (Blueprint $table) {
            $table->id('level_id'); //membuat kolom primary key auto increment dengan nama level_id
            $table->string('level_kode',10)->unique; //membuat kolom level_kode dengan tipe data varchar(10) dan unique
            $table->string('level_nama', 100); //membuat kolom level nama dg tipe data varchar (100)
            $table->timestamps();//membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_level');
    }
};
