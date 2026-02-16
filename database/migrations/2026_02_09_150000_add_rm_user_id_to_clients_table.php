<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRmUserIdToClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('rm_user_id')->nullable()->constrained('users')->nullOnDelete()->after('rm');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['rm_user_id']);
            $table->dropColumn('rm_user_id');
        });
    }
}
