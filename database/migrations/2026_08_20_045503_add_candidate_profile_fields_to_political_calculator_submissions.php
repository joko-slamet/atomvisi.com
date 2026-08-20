<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('political_calculator_submissions', function (Blueprint $table) {
            $table->string('age_range')->nullable()->after('target_jabatan');
            $table->string('candidate_status')->nullable()->after('age_range');
            $table->string('public_recognition')->nullable()->after('candidate_status');
            $table->string('voter_target')->nullable()->after('public_recognition');
            $table->string('main_goal')->nullable()->after('voter_target');
            $table->json('local_issues')->nullable()->after('main_goal');
            $table->text('about_you')->nullable()->after('local_issues');
        });
    }

    public function down(): void
    {
        Schema::table('political_calculator_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'age_range',
                'candidate_status',
                'public_recognition',
                'voter_target',
                'main_goal',
                'local_issues',
                'about_you',
            ]);
        });
    }
};
