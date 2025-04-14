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
        Schema::table('class_teacher', function (Blueprint $table) {
            // $table->unsignedBigInteger('subject_id')->after('teacher_id');
            // $table->foreign('subject_id')->references('id')->on('subjects');

            // // Hapus duplikasi data jika ada
            // $table->dropUnique(['class_id', 'teacher_id']);
            // $table->unique(['class_id', 'teacher_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_teacher', function (Blueprint $table) {
            // $table->dropForeign(['subject_id']);
            // $table->dropColumn('subject_id');
            // $table->unique(['class_id', 'teacher_id']);
        });
    }
};