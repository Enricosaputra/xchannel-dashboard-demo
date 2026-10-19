<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('frequency', 20);
            $table->string('stream_url')->nullable();
            $table->string('stream_status')->default('offline'); // live, idle, offline
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hosts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Production stores the announcers of a show as free text ("Ubed & Karim").
        Schema::create('host_show', function (Blueprint $table) {
            $table->foreignId('show_id')->constrained()->cascadeOnDelete();
            $table->foreignId('host_id')->constrained()->restrictOnDelete();
            $table->primary(['show_id', 'host_id']);
        });

        // One table for every station, instead of production's jdwl_radio_<city> table per station.
        // One row is one show on one day; times are minutes since midnight, so 24:00 is 1440.
        Schema::create('schedule_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained()->restrictOnDelete();
            $table->foreignId('show_id')->constrained()->restrictOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 1 Monday ... 7 Sunday (ISO-8601)
            $table->unsignedSmallInteger('starts_at');
            $table->unsignedSmallInteger('ends_at');
            $table->timestamps();
            $table->index(['station_id', 'day_of_week', 'starts_at']);
        });
    }

    public function down(): void
    {
        foreach (['schedule_slots', 'host_show', 'shows', 'hosts', 'stations'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
