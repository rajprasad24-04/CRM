<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangePasswordsPasswordColumnToText extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE passwords MODIFY password TEXT');
    }

    public function down()
    {
        DB::statement('ALTER TABLE passwords MODIFY password VARCHAR(255)');
    }
}
