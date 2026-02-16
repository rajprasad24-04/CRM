<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Primary Key

            // Basic Info
            $table->string('account_type');
            $table->string('family_code')->index();
            $table->string('family_head')->index();
            $table->string('client_code')->nullable()->index();
            $table->string('abbr', 10)->nullable(); // Mr, Mrs, etc.
            $table->string('client_name');
            $table->string('gender');

            // PAN and Dates
            $table->string('pan_card_number')->unique();
            $table->date('dob'); // Date of Birth
            $table->date('doa')->nullable(); // Date of Anniversary
            $table->date('date_of_join')->nullable(); // ✅ New
            $table->date('close_date')->nullable(); // ✅ New

            // Contact Info
            $table->string('primary_mobile_number', 13);
            $table->string('primary_email_number');
            $table->string('secondary_mobile_number', 13)->nullable();
            $table->string('secondary_email_number')->nullable();

            // Other Details
            $table->string('category')->nullable();
            $table->string('rm')->nullable(); // Relationship Manager short form
            $table->string('partner')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('tax_status')->nullable();

            // Address
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');

            // Notes
            $table->text('notes')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
