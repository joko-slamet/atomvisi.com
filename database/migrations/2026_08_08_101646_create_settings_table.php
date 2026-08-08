<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('whatsapp_message')->nullable();
            $table->string('email');
            $table->text('address');
            $table->text('map_embed_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'phone' => '6282191292596',
            'whatsapp_message' => 'Halo, saya ingin bertanya tentang layanan Atom Visi Indonesia.',
            'email' => 'cs@atomvisi.com',
            'address' => "Lantai 3 Setiabudi 2 Building\nKuningan, Jakarta Selatan",
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d7932.719263300207!2d106.830164!3d-6.216214!3m2!1i1024!2i768!4f13.1!2m1!1sSetiabudi%202%20Building!5e0!3m2!1sen!2sus!4v1785980614006!5m2!1sen!2sus',
            'instagram_url' => 'https://www.instagram.com/atomvisi.id',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
