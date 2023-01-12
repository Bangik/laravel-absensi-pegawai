<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('activity');
            $table->string('target');
            $table->string('report');
            $table->enum('status',['Belum Selesai', 'Proses','Selesai','Tidak Selesai']);
            $table->enum('approval',['Tertunda','Disetujui','Ditolak']);
            $table->string('note')->nullable();
            $table->date('dates');
            $table->date('due_date');
            $table->time('start');
            $table->time('end');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_schedules');
    }
}
