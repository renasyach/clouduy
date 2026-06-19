@extends('layouts.app')

@section('title', 'Tambah Anggota Kelompok')

@section('content')
<div class="glass-card" style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--card-border); padding-bottom: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.25rem;">Tambah Anggota Kelompok</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Masukkan data anggota kelompok beserta foto profil.</p>
    </div>

    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 2rem;">
            <!-- Left Side: Photo upload and preview -->
            <div>
                <span class="form-label">Foto Profil</span>
                <div style="width: 100%; height: 220px; border-radius: var(--radius-md); border: 2px dashed var(--card-border); display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; background: rgba(15, 23, 42, 0.4); position: relative;" id="previewContainer">
                    <img src="" id="photoPreview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                    <div id="previewPlaceholder" style="text-align: center; padding: 1rem; color: var(--text-muted);">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--primary);"></i>
                        <div style="font-size: 0.75rem; font-weight: 600;">Klik untuk upload</div>
                        <div style="font-size: 0.65rem;">Max size: 2MB</div>
                    </div>
                    <input 
                        type="file" 
                        name="foto" 
                        id="fotoInput" 
                        accept="image/*" 
                        style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5;"
                    >
                </div>
                @error('foto')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Right Side: Text inputs -->
            <div>
                <!-- Nama Input -->
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama" 
                        class="form-control" 
                        value="{{ old('nama') }}" 
                        placeholder="Masukkan nama lengkap" 
                        required
                    >
                    @error('nama')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIM Input -->
                <div class="form-group">
                    <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                    <input 
                        type="text" 
                        name="nim" 
                        id="nim" 
                        class="form-control" 
                        value="{{ old('nim') }}" 
                        placeholder="NIM Anggota" 
                        required
                    >
                    @error('nim')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggung Jawab Input -->
                <div class="form-group">
                    <label for="tanggung_jawab" class="form-label">Tanggung Jawab</label>
                    <textarea 
                        name="tanggung_jawab" 
                        id="tanggung_jawab" 
                        rows="4" 
                        class="form-control" 
                        placeholder="Deskripsikan tanggung jawab anggota dalam kelompok..."
                    >{{ old('tanggung_jawab') }}</textarea>
                    @error('tanggung_jawab')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2rem;">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i> Simpan Anggota
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fotoInput = document.getElementById('fotoInput');
        const photoPreview = document.getElementById('photoPreview');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                    previewPlaceholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                photoPreview.src = '';
                photoPreview.style.display = 'none';
                previewPlaceholder.style.display = 'flex';
            }
        });
    });
</script>
@endsection
