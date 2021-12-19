<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsOfBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->bigInteger('CUSTOMER_ID')->after('id');
            $table->string('Customer_Type', 50);
            $table->string('Resident_Status', 50);
            $table->string('Aadhar_Number', 12);
            $table->string('Main_Constitution', 30);
            $table->string('Sub_Constitution', 30);
            $table->date('KYC_Date')->nullable();
            $table->date('Re_KYC_Due_Date')->nullable();

            $table->string('Minor', 5);
            $table->string('Customer_Category', 10);
            $table->string('Alternate_Mobile_No', 20)->nullable();
            $table->string('Telephone_No', 20)->nullable();
            $table->string('Office_Telephone_No', 20)->nullable();
            $table->string('FAX_No', 20)->nullable();
            $table->string('Preferred_Language', 20);
            $table->longText('REMARKS');
            $table->text('KYC_Care_of');
            $table->text('KYC_HOUSE_NO');
            $table->text('KYC_LANDMARK');
            $table->text('KYC_Street');
            $table->text('KYC_LOCALITY');
            $table->string('KYC_PINCODE', 6);
            $table->string('KYC_Country', 100)->default('INDIA');
            $table->string('KYC_State', 100)->default('West Bengal');
            $table->string('KYC_District', 200);
            $table->text('KYC_POST_OFFICE');
            $table->string('KYC_CITY');
            $table->string('KYC_Taluka');
            $table->string('KYC_Population_Group');
            $table->text('COMM_Care_of'); // COMM_Care of -> COMM_Care_of
            $table->text('COMM_HOUSE_NO'); // COMM_HOUSE NO -> COMM_HOUSE_NO
            $table->string('COMM_LANDMARK');
            $table->text('COMM_Street');
            $table->text('COMM_LOCALITY');
            $table->string('COMM_PINCODE', 6);
            $table->string('COMM_Country', 100)->default('INDIA');
            $table->string('COMM_State', 100)->default('West Bengal');
            $table->string('COMM_District');
            $table->text('COMM_POST_OFFICE');
            $table->string('COMM_CITY');
            $table->string('COMM_Taluka');
            $table->string('COMM_Population_Group');
            $table->string('Social_Media');
            $table->text('Social_Media_ID');
            $table->string('PROFESSION');
            $table->string('EDUCATION');
            $table->text('ORGANISATION_NAME');
            $table->double('NET_INCOME', 10, 2);
            $table->double('NET_EXPENSE', 10, 2);
            $table->double('NET_SAVINGS', 10, 2);
            $table->integer('Years_in_Organization');
            $table->integer('CIBIL_SCORE');
            $table->integer('PERSONAL_LOAN_SCORE')->default(0);
            $table->string('GST_EXEMPTED');

            $table->string('RM_EMP_ID');
            $table->string('RM_Designation');
            $table->string('RM_TITLE');
            $table->string('RM_NAME');
            $table->string('RM_Landline_No', 20);
            $table->string('RM_MOBILE_NO', 20);
            $table->string('RM_EMAIL_ID', 200);
            $table->string('DSA_ID');
            $table->string('DSA_NAME');
            $table->string('DSA_LANDLINE_NO', 20);
            $table->string('DSA_MOBILE_NO', 20);
            $table->string('DSA_EMAIL_ID', 200);
            $table->string('GIR_NO');
            $table->string('RATION_CARD_NO');
            $table->string('DRIVING_LINC');
            $table->string('NPR_NO');
            $table->string('PASSPORT_NO');
            $table->string('EXPORTER_CODE');
            $table->string('GST_NO');
            $table->string('Voter_ID', 100);
            $table->string('CUSTM_2');
            $table->string('CATEGORY');
            $table->string('RELIGION', 50);
            $table->string('MINORITY_STATUS');

            // $table->string('CASTE', 30);
            // $table->string('SUB_CAST');
            // $table->string('RESERVATION_TYP');
            // $table->string('Physically_Challenged', 10);
            // $table->string('Weaker_Section');
            // $table->string('Valued_Customer');
            // $table->string('Special_Category_1');
            // $table->string('Vip_Category');
            // $table->string('Special_Category_2');
            // $table->string('Senior_Citizen', 10);
            // $table->date('Senior_Citizen_From')->nullable();
            // $table->integer('NO_OF_DEPEND');
            // $table->integer('SPOUSE');
            // $table->integer('CHILDREN');
            // $table->integer('PARENTS');
            // $table->string('Employee_Staus', 50);
            // $table->integer('Employee_No')->default(0);
            // $table->date('EMP_Date')->nullable();
            // $table->string('Nature_of_Occupation');
            // $table->text('EMPLYEER_NAME');
            // $table->text('Role');
            // $table->string('SPECIALIZATION');
            // $table->string('EMP_GRADE');
            // $table->string('DESIGNATION');
            // $table->text('Office_Address');
            // $table->string('Office_Phone', 20);
            // $table->string('Office_EXTENSION', 20);
            // $table->string('Office_Fax', 20);
            // $table->string('Office_MOBILE', 20);
            // $table->string('Office_PINCODE', 6);
            // $table->string('Office_CITY', 6); // CITY -> Office_CITY

            // $table->year('Working_Since');
            // $table->integer('Working_in_Current_company_Yrs');
            // $table->integer('RETIRE_AGE');
            // $table->string('Nature_of_Business');
            // $table->double('Annual_Income', 10, 2);
            // $table->string('Prof_Self_Employed');
            // $table->double('Prof_Self_Annual_Income', 10, 2)->default(0.00);
            // $table->string('IT_RETURN_YR1');
            // $table->integer('INCOME_DECLARED1')->default(0);
            // $table->integer('TAX_PAID')->default(0);
            // $table->integer('REFUND_CLAIMED1')->default(0);

            // $table->string('IT_RETURN_YR2');
            // $table->integer('INCOME_DECLARED2')->default(0);
            // $table->integer('TAX_PAID2')->default(0);
            // $table->integer('REFUND_CLAIMED2')->default(0);

            // $table->string('IT_RETURN_YR3');
            // $table->integer('INCOME_DECLARED3')->default(0);
            // $table->integer('TAX_PAID3')->default(0);
            // $table->integer('REFUND_CLAIMED3')->default(0);

            // $table->string('Maiden_Title');
            // $table->string('Maiden_First_Name');
            // $table->string('Maiden_Middle_Name');
            // $table->string('Maiden_Last_Name');
            // $table->string('Father_Title');
            // $table->string('Father_First_Name');
            // $table->string('Father_Middle_Name');
            // $table->string('Father_Last_Name');
            // $table->string('Mother_Title');
            // $table->string('Mother_First_Name');
            // $table->string('Mothers_Maiden_Name');
            // $table->string('Generic_Surname');
            // $table->string('Spouse_Title');
            // $table->string('Spouse_First_Name');
            // $table->string('Spouse_Family_Name');
            // $table->string('Identification_Mark');
            // $table->string('Country_of_Domicile');
            // $table->string('Qualification');
            // $table->string('Nationality', 50);
            // $table->string('Blood_Group', 20);
            // $table->string('Offences');
            // $table->string('Politically_Exposed');

            $table->string('Residence_Type');
            $table->string('AREA');
            $table->string('land_mark'); // Land Mark -> land_mark
            $table->string('Owned');
            $table->string('Rented');
            $table->integer('Rent_Per_Month')->default(0);
            $table->string('Ancestral');
            $table->integer('Staying_Since')->default(0)->comment('in months');
            $table->string('EMPLOYERRS');
        });

        DB::statement("ALTER TABLE `borrowers` CHANGE `name_prefix` `Title` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mr., Ms., Mrs.'");
        DB::statement("ALTER TABLE `borrowers` CHANGE `first_name` `FirstName` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `middle_name` `MiddleName` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `last_name` `LastName` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `gender` `Gender` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `date_of_birth` `Birth_Date` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `mobile` `Mobile` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `email` `Email_Id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `marital_status` `Marital_Status` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrowers', function(Blueprint $table) {
            $table->dropColumn('CUSTOMER_ID');
            $table->dropColumn('Customer_Type');
            $table->dropColumn('Resident_Status');
            $table->dropColumn('Aadhar_Number');
            $table->dropColumn('Main_Constitution');
            $table->dropColumn('Sub_Constitution');
            $table->dropColumn('KYC_Date');
            $table->dropColumn('Re_KYC_Due_Date');

            $table->dropColumn('Minor');
            $table->dropColumn('Customer_Category');
            $table->dropColumn('Alternate_Mobile_No');
            $table->dropColumn('Telephone_No');
            $table->dropColumn('Office_Telephone_No');
            $table->dropColumn('FAX_No');
            $table->dropColumn('Preferred_Language');
            $table->dropColumn('REMARKS');
            $table->dropColumn('KYC_Care_of');
            $table->dropColumn('KYC_HOUSE_NO');
            $table->dropColumn('KYC_LANDMARK');
            $table->dropColumn('KYC_Street');
            $table->dropColumn('KYC_LOCALITY');
            $table->dropColumn('KYC_PINCODE');
            $table->dropColumn('KYC_Country');
            $table->dropColumn('KYC_State');
            $table->dropColumn('KYC_District');
            $table->dropColumn('KYC_POST_OFFICE');
            $table->dropColumn('KYC_CITY');
            $table->dropColumn('KYC_Taluka');
            $table->dropColumn('KYC_Population_Group');
            $table->dropColumn('COMM_Care_of'); // COMM_Care of -> COMM_Care_of
            $table->dropColumn('COMM_HOUSE_NO'); // COMM_HOUSE NO -> COMM_HOUSE_NO
            $table->dropColumn('COMM_LANDMARK');
            $table->dropColumn('COMM_Street');
            $table->dropColumn('COMM_LOCALITY');
            $table->dropColumn('COMM_PINCODE');
            $table->dropColumn('COMM_Country');
            $table->dropColumn('COMM_State');
            $table->dropColumn('COMM_District');
            $table->dropColumn('COMM_POST_OFFICE');
            $table->dropColumn('COMM_CITY');
            $table->dropColumn('COMM_Taluka');
            $table->dropColumn('COMM_Population_Group');
            $table->dropColumn('Social_Media');
            $table->dropColumn('Social_Media_ID');
            $table->dropColumn('PROFESSION');
            $table->dropColumn('EDUCATION');
            $table->dropColumn('ORGANISATION_NAME');
            $table->dropColumn('NET_INCOME');
            $table->dropColumn('NET_EXPENSE');
            $table->dropColumn('NET_SAVINGS');
            $table->dropColumn('Years_in_Organization');
            $table->dropColumn('CIBIL_SCORE');
            $table->dropColumn('PERSONAL_LOAN_SCORE');
            $table->dropColumn('GST_EXEMPTED');

            $table->dropColumn('RM_EMP_ID');
            $table->dropColumn('RM_Designation');
            $table->dropColumn('RM_TITLE');
            $table->dropColumn('RM_NAME');
            $table->dropColumn('RM_Landline_No');
            $table->dropColumn('RM_MOBILE_NO');
            $table->dropColumn('RM_EMAIL_ID');
            $table->dropColumn('DSA_ID');
            $table->dropColumn('DSA_NAME');
            $table->dropColumn('DSA_LANDLINE_NO');
            $table->dropColumn('DSA_MOBILE_NO');
            $table->dropColumn('DSA_EMAIL_ID');
            $table->dropColumn('GIR_NO');
            $table->dropColumn('RATION_CARD_NO');
            $table->dropColumn('DRIVING_LINC');
            $table->dropColumn('NPR_NO');
            $table->dropColumn('PASSPORT_NO');
            $table->dropColumn('EXPORTER_CODE');
            $table->dropColumn('GST_NO');
            $table->dropColumn('Voter_ID');
            $table->dropColumn('CUSTM_2');
            $table->dropColumn('CATEGORY');
            $table->dropColumn('RELIGION');
            $table->dropColumn('MINORITY_STATUS');

            // $table->dropColumn('CASTE');
            // $table->dropColumn('SUB_CAST');
            // $table->dropColumn('RESERVATION_TYP');
            // $table->dropColumn('Physically_Challenged');
            // $table->dropColumn('Weaker_Section');
            // $table->dropColumn('Valued_Customer');
            // $table->dropColumn('Special_Category_1');
            // $table->dropColumn('Vip_Category');
            // $table->dropColumn('Special_Category_2');
            // $table->dropColumn('Senior_Citizen');
            // $table->dropColumn('Senior_Citizen_From');
            // $table->dropColumn('NO_OF_DEPEND');
            // $table->dropColumn('SPOUSE');
            // $table->dropColumn('CHILDREN');
            // $table->dropColumn('PARENTS');
            // $table->dropColumn('Employee_Staus');
            // $table->dropColumn('Employee_No');
            // $table->dropColumn('EMP_Date');
            // $table->dropColumn('Nature_of_Occupation');
            // $table->dropColumn('EMPLYEER_NAME');
            // $table->dropColumn('Role');
            // $table->dropColumn('SPECIALIZATION');
            // $table->dropColumn('EMP_GRADE');
            // $table->dropColumn('DESIGNATION');
            // $table->dropColumn('Office_Address');
            // $table->dropColumn('Office_Phone');
            // $table->dropColumn('Office_EXTENSION');
            // $table->dropColumn('Office_Fax');
            // $table->dropColumn('Office_MOBILE');
            // $table->dropColumn('Office_PINCODE');
            // $table->dropColumn('Office_CITY'); // CITY -> Office_CITY

            // $table->dropColumn('Working_Since');
            // $table->dropColumn('Working_in_Current_company_Yrs');
            // $table->dropColumn('RETIRE_AGE');
            // $table->dropColumn('Nature_of_Business');
            // $table->dropColumn('Annual_Income');
            // $table->dropColumn('Prof_Self_Employed');
            // $table->dropColumn('Prof_Self_Annual_Income');
            // $table->dropColumn('IT_RETURN_YR1');
            // $table->dropColumn('INCOME_DECLARED1');
            // $table->dropColumn('TAX_PAID');
            // $table->dropColumn('REFUND_CLAIMED1');

            // $table->dropColumn('IT_RETURN_YR2');
            // $table->dropColumn('INCOME_DECLARED2');
            // $table->dropColumn('TAX_PAID2');
            // $table->dropColumn('REFUND_CLAIMED2');

            // $table->dropColumn('IT_RETURN_YR3');
            // $table->dropColumn('INCOME_DECLARED3');
            // $table->dropColumn('TAX_PAID3');
            // $table->dropColumn('REFUND_CLAIMED3');

            // $table->dropColumn('Maiden_Title');
            // $table->dropColumn('Maiden_First_Name');
            // $table->dropColumn('Maiden_Middle_Name');
            // $table->dropColumn('Maiden_Last_Name');
            // $table->dropColumn('Father_Title');
            // $table->dropColumn('Father_First_Name');
            // $table->dropColumn('Father_Middle_Name');
            // $table->dropColumn('Father_Last_Name');
            // $table->dropColumn('Mother_Title');
            // $table->dropColumn('Mother_First_Name');
            // $table->dropColumn('Mothers_Maiden_Name');
            // $table->dropColumn('Generic_Surname');
            // $table->dropColumn('Spouse_Title');
            // $table->dropColumn('Spouse_First_Name');
            // $table->dropColumn('Spouse_Family_Name');
            // $table->dropColumn('Identification_Mark');
            // $table->dropColumn('Country_of_Domicile');
            // $table->dropColumn('Qualification');
            // $table->dropColumn('Nationality');
            // $table->dropColumn('Blood_Group');
            // $table->dropColumn('Offences');
            // $table->dropColumn('Politically_Exposed');

            $table->dropColumn('Residence_Type');
            $table->dropColumn('AREA');
            $table->dropColumn('land_mark');
            $table->dropColumn('Owned');
            $table->dropColumn('Rented');
            $table->dropColumn('Rent_Per_Month');
            $table->dropColumn('Ancestral');
            $table->dropColumn('Staying_Since');
            $table->dropColumn('EMPLOYERRS');
        });

        DB::statement("ALTER TABLE `borrowers` CHANGE `Title` `name_prefix` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mr., Ms., Mrs.'");
        DB::statement("ALTER TABLE `borrowers` CHANGE `FirstName` `first_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `MiddleName` `middle_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `LastName` `last_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `Gender` `gender` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `Birth_Date` `date_of_birth` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `Mobile` `mobile` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `Email_Id` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE `borrowers` CHANGE `Marital_Status` `marital_status` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''");
    }
}
