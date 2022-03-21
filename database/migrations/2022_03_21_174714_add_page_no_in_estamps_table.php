<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPageNoInEstampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estamps', function (Blueprint $table) {
            $table->bigInteger('pdf_page_no')->after('used_in_agreement')->nullable()->define('When a stamp used for PDF');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estamps', function (Blueprint $table) {
            $table->dropColumn('pdf_page_no');
        });
    }
}
