<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->boolean('cancellable')->default(true); // Assuming booking is cancellable by default
        });
    }
    
    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('cancellable');
        });
    }
    
};
