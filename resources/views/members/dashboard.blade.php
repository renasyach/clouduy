@extends('layouts.app')

@section('title', 'Kelola Anggota')

@section('content')
<div class="glass-card">
    <div class="dashboard-actions">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.25rem;">Kelola Anggota Kelompok</h1>
            <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola data identitas dan foto profil masing-masing anggota kelompok.</p>
        </div>
        <div>
            <a href="{{ route('members.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i> Tambah Anggota
            </a>
        </div>
    </div>

    <!-- Table Responsive Container -->
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>NIM</th>
                    <th>Peran</th>
                    <th>Kontak</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td>
                            <div class="table-member-profile">
                                <img src="{{ asset($member->photo ?? 'images/default-avatar.png') }}" alt="{{ $member->name }}" class="table-member-photo">
                                <div>
                                    <div class="table-member-name">{{ $member->name }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $member->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-family: monospace; font-size: 0.95rem; font-weight: 600;">{{ $member->nim }}</span>
                        </td>
                        <td>
                            <span style="background: rgba(99, 102, 241, 0.15); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; border: 1px solid rgba(99, 102, 241, 0.25);">
                                {{ $member->role }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; color: var(--text-secondary);">
                                <div><i class="fa-solid fa-phone" style="width: 14px; font-size: 0.75rem; color: var(--text-muted);"></i> {{ $member->phone ?? '-' }}</div>
                                @if($member->github)
                                    <div><i class="fa-brands fa-github" style="width: 14px; font-size: 0.75rem; color: var(--text-muted);"></i> GitHub terhubung</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="actions-cell">
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-secondary btn-sm" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Anggota">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
                            <i class="fa-solid fa-users-slash" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 0.75rem; display: block;"></i>
                            Belum ada anggota terdaftar. Klik tombol <strong>Tambah Anggota</strong> untuk menambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
