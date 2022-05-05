<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationIdToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->string('application_id')->nullable()->comment('application id from nelito');
        });
        Schema::table('borrower_agreements', function (Blueprint $table) {
            $table->string('application_id')->nullable()->after('uploaded_by')->comment('application id from nelito');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->dropColumn('application_id');
        });
        Schema::table('borrower_agreements', function (Blueprint $table) {
            $table->dropColumn('application_id');
        });
    }
}
