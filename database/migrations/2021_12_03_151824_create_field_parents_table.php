<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFieldParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_parents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softdeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['name' => 'Borrower details'],
            ['name' => 'Co-borrower details'],
            ['name' => 'Guarantor details'],
            ['name' => 'Witness 1 details'],
            ['name' => 'Witness 2 details'],
            ['name' => 'Others'],
        ];

        DB::table('field_parents')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_parents');
    }
}
