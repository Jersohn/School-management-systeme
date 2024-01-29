<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalFeesToDiscountStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_students', function (Blueprint $table) {
            $table->decimal('final_fees', 10, 2)->after('discount')->nullable();
        });
    }

    public function down()
    {
        Schema::table('discount_students', function (Blueprint $table) {
            $table->dropColumn('final_fees');
        });
    }
}
