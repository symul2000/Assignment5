<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_cost', 8, 2);
            $table->enum('status', ['Ongoing', 'Completed', 'Cancelled']);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
