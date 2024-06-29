<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            $table->integer('age')->after('image')->nullable();
            $table->string('category')->after('age')->nullable();
            $table->date('date_of_birth')->after('category');
        });
    }
};
