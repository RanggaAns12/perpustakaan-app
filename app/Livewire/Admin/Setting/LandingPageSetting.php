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
            'gambar_hero_baru' => 'nullable|image|max:15048', // Max 2MB
        ]);

        $setting = LandingSetting::first();

        $pathGambar = $setting->gambar_hero;

        // Jika ada upload gambar baru
        if ($this->gambar_hero_baru) {
            // Hapus gambar lama jika ada
            if ($setting->gambar_hero && Storage::disk('public')->exists($setting->gambar_hero)) {
                Storage::disk('public')->delete($setting->gambar_hero);
            }
            $pathGambar = $this->gambar_hero_baru->store('landing-page', 'public');
        }

        $setting->update([
            'tagline' => $this->tagline,
            'judul_hero' => $this->judul_hero,
            'deskripsi_hero' => $this->deskripsi_hero,
            'text_cta' => $this->text_cta,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'gambar_hero' => $pathGambar,
        ]);

        session()->flash('message', 'Pengaturan Landing Page berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.setting.landing-page-setting');
    }
}