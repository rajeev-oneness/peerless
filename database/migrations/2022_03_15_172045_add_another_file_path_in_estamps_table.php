<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherFilePathInEstampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('estamps', function (Blueprint $table) {
        //     $table->dropColumn('file_path');
        // });
        Schema::table('estamps', function (Blueprint $table) {
            $table->bigInteger('used_in_agreement')->nullable()->after('unique_stamp_code')->comment('It\'s indicate that for which argument this stamp used');
            $table->tinyInteger('used_flag')->after('unique_stamp_code')->default(0)->comment('0:Used,1:Not Used');
            $table->string('front_file_path')->after('amount');
            $table->string('back_file_path')->after('amount');
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
            $table->dropColumn('front_file_path');
            $table->dropColumn('back_file_path');
            $table->dropColumn('used_flag');
            $table->dropColumn('used_in_agreement');
        });
    }
}
