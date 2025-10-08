<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Tutorial extends Component
{
    public $items = [];

    public function mount()
    {
        $this->setDataByRole();
    }

    protected function setDataByRole()
    {
        $user = Auth::user();
        $role = $user->role;

        $general = $this->getGeneralTutorialItems();

        if ($role === \App\Enums\UserRole::BUYER || $role->value === 'buyer') {
            $this->items = array_merge([
                $this->getBuyerRegistrationItem()
            ], $general);
        } elseif ($role === \App\Enums\UserRole::SELLER || $role->value === 'seller') {
            $this->items = array_merge([
                $this->getSellerRegistrationItem()
            ], $general);
        } else {
            $this->items = $general;
        }
    }


    protected function getBuyerRegistrationItem()
    {
        return [
            'title' => 'Panduan Registrasi Akun',
            'content' => <<<'HTML'
Selamat datang di platform exploranusantara. Untuk menggunakan berbagai fitur kami sebagai buyer, Anda perlu terlebih dahulu melakukan registrasi akun. Proses ini dirancang agar cepat, aman, dan sesuai dengan standar profesional.

Untuk memulai, Anda dapat mengunjungi halaman registrasi melalui link https://exploranusantara.com/register  dan mengisi formulir pendaftaran dengan informasi dasar seperti:
• Username Nama untuk login ke akun.
• Password dan Konfirmasi Password Kata sandi yang aman untuk melindungi akun.
• Nomor Telepon Aktif  Digunakan untuk verifikasi tambahan dan komunikasi transaksi.
• Tipe Akun Pilih kolom  Buyer untuk mengakses fitur-fitur yang disediakan khusus pembeli.

Setelah Anda mengirim formulir tersebut, sistem kami akan mengirimkan kode OTP (One-Time Password) ke alamat email yang Anda daftarkan. Kode OTP ini berfungsi sebagai langkah verifikasi email untuk memastikan bahwa akun dibuat oleh pengguna yang sah dan menggunakan email yang valid. Pengguna harus memasukkan kode tersebut ke dalam kolom verifikasi yang tersedia dalam batas waktu tertentu agar proses aktivasi dapat dilanjutkan. Jika Anda tidak menerima kode dalam beberapa menit, Anda dapat memilih opsi “Kirim Ulang OTP”.

Apabila telah berhasil memverifikasi, pengguna akan diarahkan ke tahap selanjutnya, yaitu melengkapi data profil sesuai dengan tipe akun Buyer. Pada bagian ini, pengguna diharuskan untuk mengisi informasi tambahan seperti detail pribadi, alamat operasional, serta data perusahaan jika diperlukan. Data yang lengkap dan akurat sangat penting karena akan mempermudah proses transaksi dan meningkatkan kepercayaan Seller terhadap Buyer dalam sistem perdagangan global yang dijalankan oleh platform ini.

Jika seluruh proses registrasi berjalan dengan baik, Anda akan langsung diarahkan ke homepage khusus untuk buyer. Di sana, Anda dapat mulai menjelajahi produk, menghubungi supplier, atau mengelola permintaan penawaran secara efisien.
HTML
        ];
    }

    protected function getSellerRegistrationItem()
    {
        return [
            'title' => 'Panduan Registrasi Akun',
            'content' => <<<'HTML'
Selamat datang di platform ExploraNusantara. Untuk mulai menggunakan layanan kami sebagai seller (penjual), Anda diwajibkan untuk melakukan registrasi akun terlebih dahulu. Proses ini dirancang agar mudah, cepat, dan aman, serta sesuai dengan kebutuhan pelaku usaha. Silakan buka halaman pendaftaran melalui tautan berikut: https://exploranusantara.com/register

Di halaman tersebut, Anda akan diminta untuk mengisi informasi berikut:
- Username
- Password
- Konfirmasi password
- Nomor telepon yang aktif
- serta memilih tipe akun “Seller”

Setelah Anda melengkapi dan mengirimkan formulir tersebut, sistem kami akan mengirimkan kode OTP (One-Time Password) ke alamat email yang Anda daftarkan. Silakan masukkan kode tersebut di halaman verifikasi untuk menyelesaikan proses registrasi awal. Apabila Anda belum menerima kode dalam beberapa menit, gunakan fitur “Kirim Ulang OTP”.

Setelah kode OTP berhasil diverifikasi, Anda akan diarahkan ke halaman “Complete the Seller Data” untuk melengkapi informasi profil perusahaan secara menyeluruh. Tahap ini wajib diselesaikan sebelum Anda dapat mulai menggunakan sistem. Di halaman ini, Anda akan diminta untuk mengisi informasi seperti informasi pribadi, informasi perusahaan, informasi keuangan dan mengunggah dokumen pendukung (mis. pas foto, scan KTP, surat rekomendasi dari dinas provinsi).
HTML
        ];
    }

    protected function getGeneralTutorialItems()
    {
        return [
            [
                'title' => 'Tutorial Menjelajahi Produk',
                'content' => <<<'HTML'
Platform Explora Nusantara menyediakan halaman Product yang berfungsi sebagai etalase digital, tempat Buyer dapat menelusuri beragam produk ekspor unggulan dari seluruh Indonesia dan mancanegara. Halaman ini dirancang untuk memberikan informasi visual dan deskriptif yang menarik sekaligus fungsional, dengan gambar produk, nama produk, deskripsi singkat, label produk, serta search bar yang membantu Buyer dalam mengambil keputusan pembelian yang tepat.

Apabila buyer tertarik pada salah satu produk dan mengklik produk tersebut, akan muncul informasi detail produk yang menampilkan informasi lengkap terkait penawaran. Informasi utama yang ditampilkan antara lain Minimum Order Quantity (MOQ), International Commercial Terms (Incoterms) yang menjelaskan skema pengiriman dan tanggung jawab transaksi internasional (mis. FOB, CIF, EXW), serta ketersediaan stok (Stock Availability). Setiap produk dilengkapi dengan deskripsi singkat yang memberikan gambaran umum mengenai karakteristik produk, bahan baku, atau asal produk. Beberapa produk juga diberi label seperti “New” atau “Popular” untuk membantu Buyer mengenali produk unggulan.
HTML
            ],
            [
                'title' => 'Cara Melihat Stok dan Spesifikasi Produk',
                'content' => <<<'HTML'
Pada halaman detail produk, Buyer dapat melihat informasi stok dan spesifikasi produk yang lengkap. Informasi utama mencakup:
• Minimum Order Quantity (MOQ) — jumlah minimal pemesanan untuk produk.
• Stock Availability — jumlah stok saat ini yang tersedia untuk dipesan.
• Incoterms — skema pengiriman dan pembagian tanggung jawab (mis. FOB, CIF, EXW).
• Deskripsi produk — informasi bahan baku, ukuran, dan karakteristik lain yang relevan.

Gunakan fitur pencarian dan filter pada halaman katalog untuk menyaring produk berdasarkan kategori, asal daerah, jenis komoditas, atau sertifikasi. Jika membutuhkan detail teknis tambahan, buka halaman detail produk untuk melihat spesifikasi lengkap dan informasi kontak penjual.
HTML
            ],
            [
                'title' => 'Langkah-langkah Menggunakan Fitur Live Chat',
                'content' => <<<'HTML'
Fitur Live Chat memungkinkan Buyer dan Seller berkomunikasi langsung secara dua arah yang terekam dalam sistem. Alur umum penggunaan:
• Dari halaman detail produk, Buyer dapat menghubungi Seller melalui tombol chat atau melalui halaman transaksi jika sudah mengirimkan permintaan pemesanan.
• Setelah pesan dikirim, Seller menerima notifikasi dan dapat merespons secara langsung.
• Live Chat dapat digunakan untuk menanyakan spesifikasi, MOQ, estimasi pengiriman, metode pembayaran, atau meminta sampel.
• Semua pesan tersimpan dalam riwayat sistem dan dapat diakses kembali oleh kedua pihak. Jika ingin menutup jendela chat, gunakan tombol “Close”; ini hanya menutup tampilan tanpa menghapus riwayat percakapan.

Catatan: Live Chat umumnya tersedia selama status transaksi aktif; beberapa jenis percakapan administratif juga dapat direkam dan dipantau oleh Admin.
HTML
            ],
            [
                'title' => 'Panduan Berpartisipasi dalam Trade Meeting',
                'content' => <<<'HTML'
Halaman Trade Meeting berfungsi sebagai pusat manajemen pertemuan virtual antar pengguna. Fitur ini memungkinkan pengguna menjadwalkan, mengakses, dan memantau pertemuan dengan informasi seperti agenda, password meeting, start time, durasi, dan status approval. Untuk membuat atau bergabung ke meeting:
• Buka halaman Trade Meeting lalu klik "Create New Meeting" untuk menjadwalkan.
• Isi kolom Agenda, Duration (menit), Password, Start Time & End Time, dan pilih transaksi terkait.
• Submit permintaan akan dikirim ke Admin untuk validasi dan approval; setelah disetujui, meeting akan muncul pada dashboard peserta.
• Ketika meeting sudah dijadwalkan dan waktunya tiba, klik "Join Now" untuk masuk ke ruang virtual. Tombol join akan membawa pengguna ke tautan meeting yang disediakan (mis. Zoom).

Gunakan fitur ini untuk presentasi produk, negosiasi detail, atau pembahasan kerjasama yang lebih mendalam.
HTML
            ],
            [
                'title' => 'Cara Mengunggah Dokumen Verifikasi',
                'content' => <<<'HTML'
Untuk melengkapi proses verifikasi, pengguna (Seller/Buyer bila diminta) perlu mengunggah dokumen pendukung seperti pas foto, scan KTP, surat rekomendasi dari dinas provinsi, atau dokumen legalitas perusahaan (mis. NIB, NPWP). Langkah umum:
• Buka halaman profil atau halaman pengunggahan dokumen yang diminta.
• Pilih file menggunakan opsi "Drag and Drop" atau "Tambahkan File".
• Pastikan format file sesuai (JPG, PNG, PDF) dan ukuran tidak melebihi batas (biasanya 10 MB).
• Setelah file terunggah, klik "Save" atau "Upload" untuk menyimpan. Sistem akan menyimpan dokumen tersebut dan menandai status unggahan untuk proses verifikasi oleh Admin.

Catatan: Pastikan dokumen yang diunggah terbaca jelas; jika ada masalah, gunakan fitur "Edit File" untuk mengganti file.
HTML
            ],
        ];
    }

    public function render()
    {
        return view('livewire.tutorial');
    }
}
