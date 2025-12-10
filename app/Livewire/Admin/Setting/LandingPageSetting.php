<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LandingSetting;
use Illuminate\Support\Facades\Storage;

class LandingPageSetting extends Component
{
    use WithFileUploads;

    public $tagline, $judul_hero, $deskripsi_hero, $text_cta;
    public $alamat, $telepon, $email;
    public $gambar_hero_baru; // Untuk upload
    public $gambar_hero_lama; // Untuk preview

    public function mount()
    {
        // Ambil data pertama (dan satu-satunya)
        $setting = LandingSetting::first();

        if ($setting) {
            $this->tagline = $setting->tagline;
            $this->judul_hero = $setting->judul_hero;
            $this->deskripsi_hero = $setting->deskripsi_hero;
            $this->text_cta = $setting->text_cta;
            $this->alamat = $setting->alamat;
            $this->telepon = $setting->telepon;
            $this->email = $setting->email;
            $this->gambar_hero_lama = $setting->gambar_hero;
        }
    }

    public function update()
    {
        $this->validate([
            'tagline' => 'required',
            'judul_hero' => 'required',
            'gambar_hero_baru' => 'nullable|image|max:15048', // Max 15MB
        ]);

        // Ambil data setting, atau buat instance baru jika kosong
        $setting = LandingSetting::firstOrNew();

        // Ambil path gambar lama (jika ada)
        $pathGambar = $setting->gambar_hero;

        // Jika ada upload gambar baru
        if ($this->gambar_hero_baru) {
            // Hapus gambar lama jika ada datanya DAN filenya ada di storage
            if ($pathGambar && Storage::disk('public')->exists($pathGambar)) {
                Storage::disk('public')->delete($pathGambar);
            }
            // Simpan gambar baru
            $pathGambar = $this->gambar_hero_baru->store('landing-page', 'public');
        }

        // Update atribut model (gunakan fill atau set manual)
        $setting->tagline = $this->tagline;
        $setting->judul_hero = $this->judul_hero;
        $setting->deskripsi_hero = $this->deskripsi_hero;
        $setting->text_cta = $this->text_cta;
        $setting->alamat = $this->alamat;
        $setting->telepon = $this->telepon;
        $setting->email = $this->email;
        $setting->gambar_hero = $pathGambar;

        // Simpan ke database (save() akan otomatis Insert jika baru, atau Update jika lama)
        $setting->save();

        session()->flash('message', 'Pengaturan Landing Page berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.setting.landing-page-setting');
    }
}