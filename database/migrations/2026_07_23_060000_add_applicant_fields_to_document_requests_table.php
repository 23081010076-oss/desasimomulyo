<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom warga untuk permohonan tanpa akun (guest submission).
     * Kolom user_id tetap ada untuk backward compatibility.
     */
    public function up(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->string('applicant_name')->nullable()->after('user_id');
            $table->string('applicant_nik', 20)->nullable()->after('applicant_name');
            $table->string('applicant_phone', 20)->nullable()->after('applicant_nik');
            $table->text('purpose')->nullable()->after('applicant_phone'); // keperluan surat
            $table->string('tracking_code', 20)->nullable()->unique()->after('purpose');
        });

        // Buat user_id nullable agar warga tidak perlu akun
        Schema::table('document_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->dropColumn(['applicant_name', 'applicant_nik', 'applicant_phone', 'purpose', 'tracking_code']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
