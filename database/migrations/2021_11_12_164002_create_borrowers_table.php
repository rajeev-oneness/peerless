<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string('name_prefix', 50)->comment('Mr., Ms., Mrs.');
            $table->string('full_name')->default('');
            $table->string('first_name')->default('');
            $table->string('middle_name')->default('');
            $table->string('last_name')->default('');
            $table->string('gender', 30)->default('');
            $table->string('email');
            $table->string('mobile', 20)->nullable();
            $table->bigInteger('agreement_id')->default(0);
            $table->string('occupation');
            $table->date('date_of_birth');
            $table->string('marital_status', 30)->comment('Married, Unmarried, Divorced, Widowed');
            $table->string('image_path')->default('admin/dist/img/generic-user-icon.png');
            $table->string('signature_path')->default('');
            $table->string('street_address');
            $table->string('city');
            $table->string('pincode');
            $table->string('state');
            $table->integer('block')->default(0)->comment('0 is active, 1 is blocked');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = ['name_prefix' => 'Mr.', 'full_name' => 'Yash Vardhan', 'gender' => 'male', 'email' => 'vardhan.yash@email.com', 'mobile' => '9038775709', 'occupation' => 'IT analyst', 'date_of_birth' => '1996-11-07', 'marital_status' => 'unmarried', 'street_address' => 'B/19 HN road', 'city' => 'Kolkata', 'pincode' => '700067', 'state' => 'West Bengal'];

        DB::table('borrowers')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowers');
    }
}
