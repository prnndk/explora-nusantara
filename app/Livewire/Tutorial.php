<?php

namespace App\Livewire;

use Livewire\Component;

class Tutorial extends Component
{
    public $items = [];

    public function mount()
    {
        $this->setAdminData();
    }

    public function setAdminData()
    {
        $this->items = [
            [
                'title' => 'Panduan registrasi akun buyer',
                'media' => 'https://www.youtube.com/embed/C_n2YyFTb_I?si=VdUB1tHcywEgvwUx',
                'content' => '<p class="text-gray-600">Langkah-langkah daftar akun buyer ...</p>',
            ],
            [
                'title' => 'Tutorial menjelajahi katalog produk',
                'media' => 'https://www.youtube.com/embed/C_n2YyFTb_I?si=VdUB1tHcywEgvwUx',
                'content' => '<p class="text-gray-600">Tutorial menjelajah katalog ...</p>',
                'faqs' => [
                    ['question' => 'Apa itu katalog?', 'answer' => 'Katalog adalah daftar produk ...'],
                    ['question' => 'Kenapa penting?', 'answer' => 'Karena membantu pencarian produk ...'],
                ],
            ],
            [
                'title' => 'Cara melihat stok dan spesifikasi produk',
                'media' => 'https://www.youtube.com/embed/C_n2YyFTb_I?si=VdUB1tHcywEgvwUx',
                'content' => '<p class="text-gray-600">Langkah-langkah melihat stok ...</p>',
            ],
            [
                'title' => 'Langkah-langkah menggunakan fitur Live Chat',
                'content' => '<p class="text-gray-600">Cara menggunakan fitur chat ...</p>',
                'media' => 'https://www.youtube.com/embed/C_n2YyFTb_I?si=VdUB1tHcywEgvwUx',
                'faqs' => [
                    ['question' => 'Bagaimana cara chat?', 'answer' => 'Klik tombol chat di halaman produk ...'],
                ],
            ],
            [
                'title' => 'Panduan berpartisipasi dalam Trade Meeting',
                'media' => 'https://www.youtube.com/embed/C_n2YyFTb_I?si=VdUB1tHcywEgvwUx',
                'content' => '<p class="text-gray-600">Ikut trade meeting itu mudah ...</p>',
            ],
            [
                'title' => 'Cara mengunggah dokumen verifikasi',
                'media' => 'https://www.youtube.com/embed/C_n2YyFTb_I?si=VdUB1tHcywEgvwUx',
                'faqs' => [
                    ['question' => 'Apa benefit jadi buyer?', 'answer' => 'Akses produk eksklusif.'],
                    ['question' => 'Apakah ada biaya?', 'answer' => 'Tidak, proses gratis.'],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.tutorial');
    }
}
