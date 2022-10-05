<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday')->default(null)->nullable()->change();
            $table->text('job')->default(null)->nullable()->change();
            $table->text('address')->default(null)->nullable()->change();
            $table->float('height')->default(null)->nullable()->change();
            $table->text('pathology')->default(null)->nullable()->change();
            $table->integer('sex')->default(0)->change();
            $table->float('weight')->default(null)->nullable()->change();
            $table->float('service_point')->default(null)->nullable()->change();
            $table->text('other_info')->default(null)->nullable()->change();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
