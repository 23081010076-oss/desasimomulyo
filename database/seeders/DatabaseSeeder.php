<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\HotlineMessageStatus;
use App\Enums\ReportStatus;
use App\Models\Article;
use App\Models\BudgetTransaction;
use App\Models\DocumentType;
use App\Models\HotlineMessage;
use App\Models\ProfileGalleryImage;
use App\Models\Product;
use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@profildesa.test'],
            [
                'name' => 'Admin Desa',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $citizen = User::firstOrCreate(
            ['email' => 'citizen@profildesa.test'],
            [
                'name' => 'Citizen Demo',
                'password' => Hash::make('password'),
                'role' => 'citizen',
            ]
        );

        $roadCategory = ReportCategory::firstOrCreate(
            ['slug' => 'jalan-dan-infrastruktur'],
            [
                'name' => 'Jalan dan Infrastruktur',
                'description' => 'Kerusakan jalan, drainase, dan fasilitas umum.',
            ]
        );

        $securityCategory = ReportCategory::firstOrCreate(
            ['slug' => 'keamanan-dan-ketertiban'],
            [
                'name' => 'Keamanan dan Ketertiban',
                'description' => 'Gangguan keamanan, kebisingan, dan ketertiban lingkungan.',
            ]
        );

        DocumentType::firstOrCreate(
            ['code' => 'SKTM'],
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'description' => 'Dokumen keterangan tidak mampu untuk keperluan administrasi.',
            ]
        );

        DocumentType::firstOrCreate(
            ['code' => 'SKD'],
            [
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Dokumen keterangan domisili warga desa.',
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'musyawarah-desa-pembangunan-2026'],
            [
                'title' => 'Musyawarah Desa Pembangunan 2026',
                'excerpt' => 'Warga dan perangkat desa membahas prioritas pembangunan tahun berjalan.',
                'content' => 'Musyawarah desa tahun 2026 membahas prioritas pembangunan jalan, saluran air, dan penguatan layanan publik. Hasil forum akan ditindaklanjuti melalui APBDes.',
                'featured_image' => null,
                'published_at' => now()->subDays(2),
                'is_published' => true,
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'pelatihan-digital-marketing-umkm'],
            [
                'title' => 'Pelatihan Digital Marketing UMKM',
                'excerpt' => 'Pelaku UMKM dibekali cara promosi produk lewat media digital.',
                'content' => 'Program pelatihan ini membantu pelaku UMKM memasarkan produk secara online, membuat katalog, dan memahami dasar promosi digital.',
                'featured_image' => null,
                'published_at' => now()->subDay(),
                'is_published' => true,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'keripik-singkong-rasa-balado'],
            [
                'name' => 'Keripik Singkong Rasa Balado',
                'description' => 'Keripik singkong renyah dengan bumbu balado khas rumahan.',
                'price' => 15000,
                'image_path' => null,
                'vendor_name' => 'UMKM Bu Sari',
                'is_active' => true,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'kopi-bubuk-desaku'],
            [
                'name' => 'Kopi Bubuk Desaku',
                'description' => 'Kopi lokal sangrai dengan aroma kuat dan rasa seimbang.',
                'price' => 25000,
                'image_path' => null,
                'vendor_name' => 'Kelompok Tani Kopi',
                'is_active' => true,
            ]
        );

        BudgetTransaction::firstOrCreate(
            ['title' => 'Pembangunan Drainase Dusun Timur', 'transaction_date' => now()->toDateString()],
            [
                'category' => 'Belanja Pembangunan',
                'amount' => 45000000,
                'notes' => 'Penguatan saluran air untuk mencegah banjir lokal.',
            ]
        );

        BudgetTransaction::firstOrCreate(
            ['title' => 'Pelatihan UMKM Digital', 'transaction_date' => now()->subDays(5)->toDateString()],
            [
                'category' => 'Pemberdayaan Masyarakat',
                'amount' => 7500000,
                'notes' => 'Workshop promosi dan katalog online untuk UMKM.',
            ]
        );

        HotlineMessage::firstOrCreate(
            ['subject' => 'Lampu jalan mati di RT 03'],
            [
                'name' => 'Warga RT 03',
                'email' => 'warga03@example.com',
                'phone' => '081234567890',
                'message' => 'Lampu jalan di depan pos ronda sudah mati selama 3 malam.',
                'is_urgent' => true,
                'status' => HotlineMessageStatus::PENDING,
            ]
        );

        HotlineMessage::firstOrCreate(
            ['subject' => 'Pertanyaan layanan surat domisili'],
            [
                'name' => 'Ibu Rina',
                'email' => 'rina@example.com',
                'phone' => '081298765432',
                'message' => 'Berapa lama proses pengurusan surat domisili?',
                'is_urgent' => false,
                'status' => HotlineMessageStatus::RESPONDED,
            ]
        );

        ProfileGalleryImage::firstOrCreate(
            ['title' => 'Kantor Kelurahan Simomulyo'],
            [
                'caption' => 'Pusat layanan administrasi dan informasi warga Simomulyo.',
                'image_path' => 'images/profile/kantor-kelurahan.svg',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        ProfileGalleryImage::firstOrCreate(
            ['title' => 'Warga dan Kegiatan Lingkungan'],
            [
                'caption' => 'Dokumentasi partisipasi warga dalam kegiatan kelurahan.',
                'image_path' => 'images/profile/warga-berkumpul.svg',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        ProfileGalleryImage::firstOrCreate(
            ['title' => 'Visual Wilayah Simomulyo'],
            [
                'caption' => 'Ikhtisar visual wilayah dan titik layanan yang terhubung.',
                'image_path' => 'images/profile/wilayah-simomulyo.svg',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        Report::firstOrCreate(
            ['title' => 'Jalan berlubang di dekat pasar', 'user_id' => $citizen->id],
            [
                'report_category_id' => $roadCategory->id,
                'description' => 'Permukaan jalan berlubang dan membahayakan pengendara roda dua.',
                'latitude' => -6.20000000,
                'longitude' => 106.81666600,
                'image_path' => 'reports/jalan-berlubang.jpg',
                'status' => ReportStatus::PROCESSED->value,
                'is_emergency' => false,
                'metadata' => ['source' => 'web'],
            ]
        );

        Report::firstOrCreate(
            ['title' => 'Gangguan keamanan malam hari', 'user_id' => $citizen->id],
            [
                'report_category_id' => $securityCategory->id,
                'description' => 'Ada keributan dan suara kendaraan sangat keras pada malam hari.',
                'latitude' => -6.20150000,
                'longitude' => 106.81700000,
                'image_path' => 'reports/gangguan-keamanan.jpg',
                'status' => ReportStatus::EMERGENCY->value,
                'is_emergency' => true,
                'metadata' => ['source' => 'panic_button'],
            ]
        );
    }
}

