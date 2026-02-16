<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDataTable extends Migration
{
    public function up()
    {
        Schema::create('financial_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Foreign key referencing clients table
            $table->decimal('life', 15, 2)->nullable();
            $table->decimal('health', 15, 2)->nullable();
            $table->decimal('pa', 15, 2)->nullable();
            $table->decimal('critical', 15, 2)->nullable();
            $table->decimal('motor', 15, 2)->nullable();
            $table->decimal('general', 15, 2)->nullable();
            $table->decimal('fd', 15, 2)->nullable();
            $table->decimal('mf', 15, 2)->nullable();
            $table->decimal('pms', 15, 2)->nullable();
            $table->decimal('income_tax', 15, 2)->nullable();
            $table->decimal('gst', 15, 2)->nullable();
            $table->decimal('accounting', 15, 2)->nullable();
            $table->decimal('others', 15, 2)->nullable();
            $table->decimal('tds', 15, 2)->nullable();
            $table->decimal('pt', 15, 2)->nullable();
            $table->decimal('vat', 15, 2)->nullable();
            $table->decimal('roc', 15, 2)->nullable();
            $table->decimal('cma', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_data');
    }
}

