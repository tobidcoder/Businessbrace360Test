<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('responsibility')->nullable();
            $table->string('qualification');
            $table->decimal('remuneration', '20', '2')->nullable();
            $table->string('employment_type');
            $table->string('job_function');
            $table->string('industry')->nullable();
            $table->string('seniority_level')->nullable();
            $table->string('pay_range')->nullable();
            $table->enum('jobs_status', ['open', 'closed', 'filled', 'internal', 'draft']);
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
        Schema::dropIfExists('jobs');
    }
}
