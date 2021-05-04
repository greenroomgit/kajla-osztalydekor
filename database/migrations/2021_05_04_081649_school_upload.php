<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SchoolUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photo_uploads', function (Blueprint $table) {
            $table->longText('school')->create();
            $table->string('class')->create();
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('postal');

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
}
