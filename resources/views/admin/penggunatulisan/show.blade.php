@extends('admin.layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Review Tulisan: {{ $tulisan->judul }}</h1>
    <a href="{{ route('admin.penggunatulisan.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Konten</h6>
            </div>
            <div class="card-body">
                @if($tulisan->gambar_array)
                    <div class="mb-4">
                        <h6>Galeri Gambar:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(json_decode($tulisan->gambar_array, true) as $gbr)
                                <div class="border p-1 rounded" style="width: 150px;">
                                    <img src="{{ asset('img/' . $gbr['file_gambar']) }}" alt="Gambar" class="img-fluid rounded" style="height: 100px; object-fit: cover; width: 100%;">
                                    <small class="d-block mt-1 text-muted text-center" style="font-size: 10px;">{{ $gbr['deskripsi'] ?? '-' }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($tulisan->gambar)
                    <div class="mb-4 text-center">
                        <img src="{{ asset('img/' . $tulisan->gambar) }}" alt="Cover" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                @endif
                
                <h5>Sinopsis</h5>
                <p class="text-muted">{{ $tulisan->sinopsis ?? 'Tidak ada sinopsis' }}</p>
                <hr>
                
                <h5>Konten Lengkap</h5>
                <div class="p-3 border rounded bg-light" style="min-height: 300px;">
                    {!! $tulisan->konten !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi & Aksi</h6>
            </div>
            <div class="card-body">
                <p><strong>Pengirim:</strong> <br> {{ $tulisan->pengguna->nama }} ({{ $tulisan->pengguna->email }})</p>
                <p><strong>Kategori:</strong> <br> {{ $tulisan->kategori->nama }}</p>
                <p><strong>Tanggal Kirim:</strong> <br> {{ $tulisan->created_at->format('d M Y H:i') }}</p>
                
                <hr>
                
                <p><strong>Status Saat Ini:</strong> 
                    @if($tulisan->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                        @if($tulisan->artikel_id)
                            <span class="badge badge-primary"><i class="fas fa-edit"></i> Revisi Baru</span>
                        @endif
                    @elseif($tulisan->status == 'disetujui')
                        <span class="badge badge-success">Disetujui</span>
                    @else
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </p>

                <div class="mt-4">
                    <a href="{{ route('admin.penggunatulisan.preview', $tulisan->id) }}" target="_blank" class="btn btn-info btn-block mb-3">
                        <i class="fas fa-desktop"></i> Simulasi Pratinjau (Live Preview)
                    </a>
                    <hr>

                @if($tulisan->status == 'pending')
                    <button type="button" class="btn btn-success btn-block mb-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="fas fa-check"></i> {{ $tulisan->artikel_id ? 'Setujui & Update Artikel' : 'Setujui & Publish' }}
                    </button>
                    
                    <button type="button" class="btn btn-warning btn-block mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times"></i> Tolak Tulisan
                    </button>

                @elseif($tulisan->status == 'ditolak')
                    <div class="mb-3 p-3 bg-warning text-dark rounded" style="font-size: 0.9rem;">
                        <strong>Alasan Penolakan:</strong><br>
                        {{ $tulisan->alasan_penolakan }}
                    </div>
                    
                    <form action="{{ route('admin.penggunatulisan.approve', $tulisan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tarik kembali penolakan dan terbitkan tulisan ini?');">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block mb-2"><i class="fas fa-undo"></i> Tarik Kembali & Setujui</button>
                    </form>

                @elseif($tulisan->status == 'disetujui')
                    @if($tulisan->pesan_revisi)
                        <div class="mb-3 p-3 rounded" style="background-color: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8; font-size: 0.9rem;">
                            <strong><i class="fas fa-info-circle"></i> PENGGUNA MEMINTA IZIN PENGEDITAN</strong><br>
                            Alasan: <em>"{{ $tulisan->pesan_revisi }}"</em>
                        </div>
                        
                        <form action="{{ route('admin.penggunatulisan.approve_revisi', $tulisan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui permintaan edit? Artikel akan ditarik ke draft agar pengguna bisa mengubahnya.');">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block mb-2"><i class="fas fa-check"></i> Setujui & Turunkan Artikel</button>
                        </form>

                        <form action="{{ route('admin.penggunatulisan.reject_revisi', $tulisan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak permintaan edit? Artikel tetap tayang dan pesan ini akan dihapus.');">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-block mb-3"><i class="fas fa-times"></i> Tolak Permintaan Edit</button>
                        </form>
                        <hr>
                    @endif

                    @if($tulisan->artikel_id)
                        <a href="{{ route('admin.artikel.edit', $tulisan->artikel_id) }}" class="btn btn-primary btn-block mb-2"><i class="fas fa-edit"></i> Edit Artikel Ini</a>
                    @endif

                    <button type="button" class="btn btn-warning btn-block mb-2" data-bs-toggle="modal" data-bs-target="#unpublishModal">
                        <i class="fas fa-file-export"></i> Batalkan Publikasi (Tarik ke Draft)
                    </button>
                @endif
                
                <hr>
                <form action="{{ route('admin.penggunatulisan.destroy', $tulisan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tulisan ini SECARA PERMANEN? Tindakan ini tidak bisa dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Hapus Permanen</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
@if($tulisan->status == 'pending')
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel">{{ $tulisan->artikel_id ? 'Konfirmasi & Update Artikel' : 'Konfirmasi & Setujui Tulisan' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.penggunatulisan.approve', $tulisan->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            @if($tulisan->artikel_id)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Ini adalah revisi dari artikel yang <strong>sudah tayang</strong>. Mengeklik tombol di bawah ini akan <strong>menimpa (update)</strong> isi artikel yang lama dengan teks terbaru dari draft ini, tanpa mengubah Link URL.
                </div>
            @endif
            <p>Periksa kembali detail berikut sebelum artikel benar-benar tayang di publik.</p>
            
            <div class="form-group mb-3">
                <label for="judul">Judul Artikel</label>
                <input type="text" class="form-control" name="judul" id="judul" value="{{ $tulisan->judul }}" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="kategori_id">Kategori</label>
                <select class="form-control" name="kategori_id" id="kategori_id" required>
                    @foreach(\App\Models\Kategori::all() as $kat)
                        <option value="{{ $kat->id }}" {{ $tulisan->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mb-3">
                <label for="jenis_artikel">Jenis Artikel</label>
                <select class="form-control" name="jenis_artikel" id="jenis_artikel" required>
                    <option value="free" {{ $tulisan->jenis_artikel == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="premium" {{ $tulisan->jenis_artikel == 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
                <small class="text-muted">Pilih "Premium" jika artikel ini berpotensi tinggi atau sangat eksklusif.</small>
            </div>
            
            <div class="form-group mb-3">
                <label for="tanggal_publikasi">Jadwalkan Tanggal Publikasi (Opsional)</label>
                <input type="datetime-local" class="form-control" name="tanggal_publikasi" id="tanggal_publikasi" value="{{ $tulisan->tanggal_publikasi ? date('Y-m-d\TH:i', strtotime($tulisan->tanggal_publikasi)) : '' }}">
                <small class="text-muted">Biarkan kosong jika ingin diterbitkan saat ini juga.</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ $tulisan->artikel_id ? 'Update Sekarang' : 'Publish Sekarang' }}</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endif

<!-- Reject Modal -->
@if($tulisan->status == 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Tolak Tulisan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.penggunatulisan.reject', $tulisan->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
                <label for="alasan_penolakan">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea class="form-control" name="alasan_penolakan" id="alasan_penolakan" rows="4" required placeholder="Jelaskan alasan mengapa tulisan ini ditolak agar pengguna dapat memperbaikinya..."></textarea>
                <small class="text-muted">Pesan ini akan ditampilkan di halaman dashboard profil pengguna.</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Tolak Tulisan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endif

<!-- Unpublish Modal -->
@if($tulisan->status == 'disetujui')
<div class="modal fade" id="unpublishModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unpublishModalLabel">Batalkan Publikasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.penggunatulisan.unpublish', $tulisan->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            <p>Artikel yang sudah terbit di web akan dihapus dan status kiriman akan dikembalikan ke <strong>Pending</strong>.</p>
            <div class="form-group">
                <label for="alasan_batal">Catatan / Alasan Penarikan (Opsional)</label>
                <textarea class="form-control" name="alasan_batal" id="alasan_batal" rows="3" placeholder="Misal: Ada kesalahan ketik yang perlu diperbaiki ulang..."></textarea>
                <small class="text-muted">Jika diisi, pesan ini akan muncul di dasbor pengguna meskipun statusnya kembali menjadi Pending.</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-warning">Tarik ke Draft</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endif

@endsection
