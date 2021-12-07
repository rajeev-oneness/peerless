<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBankListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_lists', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('type')->comment('Public-sector banks, Private-sector banks');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['name' => 'Bank of Baroda', 'type' => 'Public-sector banks'],
            ['name' => 'Vijaya Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Dena Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Bank of India', 'type' => 'Public-sector banks'],
            ['name' => 'Bank of Maharashtra', 'type' => 'Public-sector banks'],
            ['name' => 'Canara Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Syndicate Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Central Bank of India', 'type' => 'Public-sector banks'],
            ['name' => 'Indian Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Allahabad Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Indian Overseas Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Punjab and Sind Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Punjab National Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Oriental Bank of Commerce', 'type' => 'Public-sector banks'],
            ['name' => 'United Bank of India', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of India', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Bikaner & Jaipur', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Hyderabad', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Indore', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Mysore', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Patiala', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Saurashtra', 'type' => 'Public-sector banks'],
            ['name' => 'State Bank of Travancore', 'type' => 'Public-sector banks'],
            ['name' => 'Bhartiya Mahila Bank', 'type' => 'Public-sector banks'],
            ['name' => 'UCO Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Union Bank of India', 'type' => 'Public-sector banks'],
            ['name' => 'Andhra Bank', 'type' => 'Public-sector banks'],
            ['name' => 'Corporation Bank', 'type' => 'Public-sector banks'],
        ];

        DB::table('bank_lists')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_lists');
    }
}
