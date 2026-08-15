<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kategori;
use App\Models\PenggunaTulisan;
use App\Models\PenggunaSimpanArtikel;
use App\Models\PenggunaKoleksi;
use App\Models\Pengguna;
use App\Models\Subscriber;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('pengguna')->user();
        $tab = $request->query('tab', 'akun');

        $kategoriList = Kategori::whereIn('nama', ['Buku', 'Fiksi & Puisi', 'Kata & Kota', 'Pemikiran'])->get();
        $userTulisans = PenggunaTulisan::where('pengguna_id', $user->id)->latest()->get();
        
        $savedArtikels = PenggunaSimpanArtikel::where('pengguna_id', $user->id)->with('artikel')->latest()->get();
        $koleksis = PenggunaKoleksi::where('pengguna_id', $user->id)->latest()->get();

        // ── Subscription Logic — 3NF: query via pengguna_id FK ──
        $subscription = Subscriber::where('pengguna_id', $user->id)->first();
        $isPremium = $subscription && $subscription->is_active;

        $edit_id = $request->query('edit_id');
        $editTulisan = null;
        if ($edit_id && $tab == 'kirim-tulisan') {
            $editTulisan = PenggunaTulisan::where('id', $edit_id)->where('pengguna_id', $user->id)->first();
        }

        return view('pages.profile.dashboard', compact('user', 'tab', 'kategoriList', 'userTulisans', 'savedArtikels', 'koleksis', 'editTulisan', 'subscription', 'isPremium'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('pengguna')->user();
        
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email,'.$user->id,
            'bio' => 'nullable|string'
        ]);

        $bio = $request->bio;
        if ($request->filled('bio')) {
            $words = preg_split('/\s+/', trim($bio));
            if (count($words) > 35) {
                $bio = implode(' ', array_slice($words, 0, 35));
            }
        }

        $userToUpdate = Pengguna::find($user->id);
        $oldName = $userToUpdate->nama;
        $oldEmail = $userToUpdate->email;
        $oldBio = $userToUpdate->bio;

        $userToUpdate->nama = $request->nama;
        $userToUpdate->email = $request->email;
        $userToUpdate->bio = $bio;
        
        // Handle cropped photo base64
        if ($request->filled('cropped_foto')) {
            $base64_image = $request->cropped_foto;
            
            // Extract the base64 string from the data URI
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_image, $type)) {
                $base64_image = substr($base64_image, strpos($base64_image, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
            
                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    throw new \Exception('Invalid image type');
                }
                
                $image_data = base64_decode($base64_image);
                $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $type;
                
                \Illuminate\Support\Facades\Storage::disk('public')->put('profile/' . $filename, $image_data);
                $userToUpdate->foto_profil = $filename;
            }
        } elseif ($request->hasFile('foto_profil')) { // Fallback if JS fails
            $file = $request->file('foto_profil');
            $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile', $filename, 'public');
            $userToUpdate->foto_profil = $filename;
        }

        if ($request->filled('password')) {
            $userToUpdate->password = $request->password;
        }
        
        $userToUpdate->save();

        // Update name and bio in Penulis table if it exists and was changed
        if ($oldName !== $request->nama || $oldBio !== $request->bio) {
            $penulis = \App\Models\Penulis::where('nama', $oldName)->first();
            if ($penulis) {
                $penulis->update([
                    'nama' => $request->nama,
                    'biografi' => $request->bio
                ]);
            }
        }

        // 3NF: Sinkronisasi ke subscribers via pengguna_id
        $subscriber = Subscriber::where('pengguna_id', $userToUpdate->id)->first();
        if ($subscriber) {
            if (!$subscriber->pengguna_id) {
                $subscriber->pengguna_id = $userToUpdate->id;
            }
            $subscriber->save(); // model event otomatis sync nama & email dari pengguna
        }

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function storeTulisan(Request $request)
    {
        $user = Auth::guard('pengguna')->user();
        // 3NF: guard via pengguna_id FK
        $subscription = Subscriber::where('pengguna_id', $user->id)->first();
        if (!$subscription || !$subscription->is_active) {
            return redirect()->route('user.profile', ['tab' => 'langganan'])->with('error', 'Akses ditolak. Fitur kirim tulisan hanya tersedia untuk akun Premium (berlangganan aktif).');
        }

        $kategori_id = $request->kategori_id ?? $request->kategori_id_hidden;
        $konten = $request->layout === 'artikel3' ? $request->konten_puisi : $request->konten;

        $request->merge([
            'kategori_id' => $kategori_id,
            'konten' => $konten
        ]);

        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'sinopsis' => 'nullable|string',
            'konten' => 'required|string',
            'layout' => 'required|string',
            'jenis_artikel' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $gambarArray = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $filename = time() . '_user_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public_img')->put($filename, file_get_contents($file));
                $gambarArray[] = [
                    'file_gambar' => $filename,
                    'deskripsi' => $request->deskripsi_gambar[$index] ?? null
                ];
            }
        }

        PenggunaTulisan::create([
            'pengguna_id' => Auth::guard('pengguna')->id(),
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'sinopsis' => $request->sinopsis,
            'konten' => $request->konten,
            'layout' => $request->layout,
            'jenis_artikel' => $request->jenis_artikel,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'sponsor' => null,
            'gambar_array' => json_encode($gambarArray),
            'status' => 'pending',
        ]);

        return redirect()->route('user.profile', ['tab' => 'kelola-tulisan'])->with('success_tulisan', 'Tulisan berhasil dikirim dan sedang menunggu kurasi.');
    }

    public function updateTulisan(Request $request, $id)
    {
        $user = Auth::guard('pengguna')->user();
        // 3NF: guard via pengguna_id FK
        $subscription = Subscriber::where('pengguna_id', $user->id)->first();
        if (!$subscription || !$subscription->is_active) {
            return redirect()->route('user.profile', ['tab' => 'langganan'])->with('error', 'Akses ditolak. Fitur kirim tulisan hanya tersedia untuk akun Premium (berlangganan aktif).');
        }

        $tulisan = PenggunaTulisan::where('id', $id)
            ->where('pengguna_id', $user->id)
            ->firstOrFail();

        if ($tulisan->status == 'disetujui') {
            return redirect()->back()->with('error_tulisan', 'Tulisan yang sudah disetujui tidak bisa diedit.');
        }

        $kategori_id = $request->kategori_id ?? $request->kategori_id_hidden;
        $konten = $request->layout === 'artikel3' ? $request->konten_puisi : $request->konten;

        $request->merge([
            'kategori_id' => $kategori_id,
            'konten' => $konten
        ]);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'konten' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'kategori_id.required' => 'The kategori id field is required.'
        ]);

        $gambarArray = $tulisan->gambar_array ? json_decode($tulisan->gambar_array, true) : [];
        if ($request->hasFile('gambar')) {
            $gambarArray = []; // Reset if they upload new ones
            foreach ($request->file('gambar') as $index => $file) {
                $filename = time() . '_user_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public_img')->put($filename, file_get_contents($file));
                $gambarArray[] = [
                    'file_gambar' => $filename,
                    'deskripsi' => $request->deskripsi_gambar[$index] ?? null
                ];
            }
        }

        $tulisan->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'sinopsis' => $request->sinopsis,
            'konten' => $request->konten,
            'layout' => $request->layout,
            'jenis_artikel' => $request->jenis_artikel,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'gambar_array' => count($gambarArray) > 0 ? json_encode($gambarArray) : $tulisan->gambar_array,
            'status' => 'pending', // Reset status to pending after edit
            'alasan_penolakan' => null // Clear rejection reason
        ]);

        return redirect()->route('user.profile', ['tab' => 'kelola-tulisan'])->with('success_tulisan', 'Tulisan berhasil diperbarui dan sedang menunggu kurasi ulang.');
    }

    public function requestRevisi(Request $request, $id)
    {
        $request->validate([
            'pesan_revisi' => 'required|string|max:500'
        ]);

        $tulisan = PenggunaTulisan::where('id', $id)
            ->where('pengguna_id', Auth::guard('pengguna')->id())
            ->firstOrFail();

        if ($tulisan->status != 'disetujui') {
            return redirect()->back()->with('error_tulisan', 'Hanya tulisan yang sudah disetujui yang bisa diajukan pengeditan.');
        }

        $tulisan->update([
            'pesan_revisi' => $request->pesan_revisi
        ]);

        return redirect()->route('user.profile', ['tab' => 'kelola-tulisan'])->with('success_tulisan', 'Permintaan pengeditan ulang berhasil dikirim ke admin.');
    }

    public function deleteTulisan($id)
    {
        $tulisan = PenggunaTulisan::where('id', $id)
            ->where('pengguna_id', Auth::guard('pengguna')->id())
            ->firstOrFail();

        if ($tulisan->status == 'disetujui') {
            return redirect()->back()->with('error_tulisan', 'Tulisan yang sudah disetujui tidak bisa dihapus.');
        }

        $tulisan->delete();

        return redirect()->route('user.profile', ['tab' => 'kelola-tulisan'])->with('success_tulisan', 'Riwayat tulisan berhasil dihapus.');
    }

    public function saveArtikel(Request $request, $id)
    {
        $userId = Auth::guard('pengguna')->id();
        $exists = PenggunaSimpanArtikel::where('pengguna_id', $userId)->where('artikel_id', $id)->first();
        
        if ($exists) {
            $exists->delete();
            return response()->json(['status' => 'removed', 'message' => 'Artikel dihapus dari simpanan.']);
        } else {
            PenggunaSimpanArtikel::create([
                'pengguna_id' => $userId,
                'artikel_id' => $id,
            ]);
            return response()->json(['status' => 'saved', 'message' => 'Artikel berhasil disimpan.']);
        }
    }

    public function addKoleksi(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:magz,publikasi',
            'item_id' => 'required|integer'
        ]);

        $userId = Auth::guard('pengguna')->id();
        $exists = PenggunaKoleksi::where('pengguna_id', $userId)
            ->where('item_type', $request->item_type)
            ->where('item_id', $request->item_id)
            ->first();

        if ($request->expectsJson()) {
            if ($exists) {
                $exists->delete();
                return response()->json(['status' => 'removed', 'message' => 'Dihapus dari koleksi.']);
            } else {
                PenggunaKoleksi::create([
                    'pengguna_id' => $userId,
                    'item_type' => $request->item_type,
                    'item_id' => $request->item_id,
                ]);
                return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke koleksi.']);
            }
        }

        if (!$exists) {
            PenggunaKoleksi::create([
                'pengguna_id' => $userId,
                'item_type' => $request->item_type,
                'item_id' => $request->item_id,
            ]);
        }

        return redirect()->back()->with('success', ucfirst($request->item_type) . ' berhasil ditambahkan ke koleksi.');
    }
    public function removeArtikel($id)
    {
        $userId = Auth::guard('pengguna')->id();
        PenggunaSimpanArtikel::where('pengguna_id', $userId)->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus dari simpanan.');
    }

    public function removeKoleksi($id)
    {
        $userId = Auth::guard('pengguna')->id();
        PenggunaKoleksi::where('pengguna_id', $userId)->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus dari koleksi.');
    }
}
