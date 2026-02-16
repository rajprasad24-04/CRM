<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeClientFieldsNullable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('account_type')->nullable()->change();
            $table->string('family_code')->nullable()->change();
            $table->string('family_head')->nullable()->change();
            $table->string('client_name')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('primary_mobile_number', 13)->nullable()->change();
            $table->string('primary_email_number')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('zip_code')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('account_type')->nullable(false)->change();
            $table->string('family_code')->nullable(false)->change();
            $table->string('family_head')->nullable(false)->change();
            $table->string('client_name')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->date('dob')->nullable(false)->change();
            $table->string('primary_mobile_number', 13)->nullable(false)->change();
            $table->string('primary_email_number')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('zip_code')->nullable(false)->change();
        });
    }
}
