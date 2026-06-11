@extends('layouts.app')

@section('title', 'Edit Anggota Kelompok')

@section('content')
<div class="glass-card" style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--card-border); padding-bottom: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.25rem;">Edit Anggota Kelompok</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Ubah data identitas atau perbarui foto profil anggota kelompok.</p>
    </div>

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 2rem;">
            <!-- Left Side: Photo upload and preview -->
            <div>
                <span class="form-label">Foto Profil</span>
                <div style="width: 100%; height: 220px; border-radius: var(--radius-md); border: 2px dashed var(--card-border); display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; background: rgba(15, 23, 42, 0.4); position: relative;" id="previewContainer">
                    <img 
                        src="{{ $member->photo ? asset($member->photo) : '' }}" 
                        id="photoPreview" 
                        style="width: 100%; height: 100%; object-fit: cover; display: {{ $member->photo ? 'block' : 'none' }};"
                    >
                    <div id="previewPlaceholder" style="text-align: center; padding: 1rem; color: var(--text-muted); display: {{ $member->photo ? 'none' : 'block' }};">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--primary);"></i>
                        <div style="font-size: 0.75rem; font-weight: 600;">Klik untuk upload</div>
                        <div style="font-size: 0.65rem;">Max size: 2MB</div>
                    </div>
                    <input 
                        type="file" 
                        name="photo" 
                        id="photoInput" 
                        accept="image/*" 
                        style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5;"
                    >
                </div>
                @error('photo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Right Side: Text inputs -->
            <div>
                <!-- Name Input -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        value="{{ old('name', $member->name) }}" 
                        placeholder="Masukkan nama lengkap" 
                        required
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIM & Role Input Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                        <input 
                            type="text" 
                            name="nim" 
                            id="nim" 
                            class="form-control" 
                            value="{{ old('nim', $member->nim) }}" 
                            placeholder="NIM Anggota" 
                            required
                        >
                        @error('nim')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Peran / Jabatan</label>
                        <input 
                            type="text" 
                            name="role" 
                            id="role" 
                            class="form-control" 
                            value="{{ old('role', $member->role) }}" 
                            placeholder="Contoh: Frontend Developer" 
                            required
                        >
                        @error('role')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Email & Phone Input Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control" 
                            value="{{ old('email', $member->email) }}" 
                            placeholder="nama@student.univ.ac.id" 
                            required
                        >
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telepon / WA</label>
                        <input 
                            type="text" 
                            name="phone" 
                            id="phone" 
                            class="form-control" 
                            value="{{ old('phone', $member->phone) }}" 
                            placeholder="Contoh: +62812345678"
                        >
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Social Links Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="github" class="form-label">Link GitHub (Opsional)</label>
                        <input 
                            type="url" 
                            name="github" 
                            id="github" 
                            class="form-control" 
                            value="{{ old('github', $member->github) }}" 
                            placeholder="https://github.com/username"
                        >
                        @error('github')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="linkedin" class="form-label">Link LinkedIn (Opsional)</label>
                        <input 
                            type="url" 
                            name="linkedin" 
                            id="linkedin" 
                            class="form-control" 
                            value="{{ old('linkedin', $member->linkedin) }}" 
                            placeholder="https://linkedin.com/in/username"
                        >
                        @error('linkedin')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Bio / Deskripsi -->
                <div class="form-group">
                    <label for="bio" class="form-label">Biografi Singkat</label>
                    <textarea 
                        name="bio" 
                        id="bio" 
                        rows="4" 
                        class="form-control" 
                        placeholder="Deskripsikan secara singkat keahlian, tugas, atau biografi anggota di kelompok ini..."
                    >{{ old('bio', $member->bio) }}</textarea>
                    @error('bio')
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
                <i class="fa-solid fa-save"></i> Perbarui Anggota
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                    previewPlaceholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
