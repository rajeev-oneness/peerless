<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->comment('input text, input email, textarea, select');
            $table->longText('value')->nullable()->comment('comma separated value of fields');
            $table->string('key_name');
            $table->tinyInteger('required')->default(0)->comment('1 is required, 0 is not');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['name' => 'Name prefix', 'type' => '7', 'value' => 'Mr., Mrs., Miss', 'key_name' => 'nameprefix'],
            ['name' => 'First name', 'type' => '1', 'value' => '', 'key_name' => 'firstname'],
            ['name' => 'Middle name', 'type' => '1', 'value' => '', 'key_name' => 'middlename'],
            ['name' => 'Last name', 'type' => '1', 'value' => '', 'key_name' => 'lastname'],
            ['name' => 'Date of birth', 'type' => '4', 'value' => '', 'key_name' => 'dateofbirth'],
            ['name' => 'Marital status', 'type' => '7', 'value' => 'Married, Unmarried, Divorced, Widowed', 'key_name' => 'maritalstatus'],
            ['name' => 'Email id', 'type' => '2', 'value' => '', 'key_name' => 'emailid'],
            ['name' => 'Phone number', 'type' => '3', 'value' => '', 'key_name' => 'phonenumber'],
        ];

        DB::table('fields')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
