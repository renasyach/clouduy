@extends('layouts.app')

@section('title', 'Daftar Anggota Kelompok')

@section('content')
<div class="section-header">
    <h1 class="section-title">Anggota Kelompok Kami</h1>
    <p class="section-desc">Kenali anggota tim Clouduy yang berkolaborasi dalam membangun arsitektur aplikasi berbasis cloud computing.</p>
</div>

<!-- Members Grid -->
<div class="member-grid">
    @forelse($members as $member)
        <div class="member-card" 
             data-nama="{{ $member->nama }}"
             data-nim="{{ $member->nim }}"
             data-tanggung_jawab="{{ $member->tanggung_jawab ?? 'Belum ada deskripsi tanggung jawab.' }}"
             data-foto="{{ asset($member->foto ?? 'images/default-avatar.png') }}">
            
            <div class="member-photo-container">
                <img src="{{ asset($member->foto ?? 'images/default-avatar.png') }}" alt="{{ $member->nama }}" class="member-photo">
            </div>
            
            <div class="member-info">
                <div class="member-nim">{{ $member->nim }}</div>
                <h3 class="member-name">{{ $member->nama }}</h3>
                <p class="member-role">{{ $member->tanggung_jawab }}</p>
            </div>
        </div>
    @empty
        <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
            <i class="fa-solid fa-users-slash" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3>Belum ada anggota terdaftar</h3>
            <p style="color: var(--text-secondary); margin-top: 0.5rem;">Silakan masuk sebagai admin untuk menambah anggota.</p>
        </div>
    @endforelse
</div>

<!-- Modal Detail Anggota -->
<div class="modal" id="memberModal">
    <div class="modal-content">
        <button class="modal-close" id="closeModal">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="modal-grid">
            <div class="modal-photo-container">
                <img src="" alt="" class="modal-photo" id="modalPhoto">
            </div>
            <div class="modal-body">
                <div class="member-nim" id="modalNim">NIM</div>
                <h2 class="member-name" id="modalNama" style="font-size: 1.75rem;">Nama Lengkap</h2>
                <div class="member-role" id="modalTanggungJawab" style="margin-bottom: 1rem; color: var(--primary);">Tanggung Jawab</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.member-card');
        const modal = document.getElementById('memberModal');
        const closeModal = document.getElementById('closeModal');
        
        const modalPhoto = document.getElementById('modalPhoto');
        const modalNim = document.getElementById('modalNim');
        const modalNama = document.getElementById('modalNama');
        const modalTanggungJawab = document.getElementById('modalTanggungJawab');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const nama = card.getAttribute('data-nama');
                const nim = card.getAttribute('data-nim');
                const tanggungJawab = card.getAttribute('data-tanggung_jawab');
                const foto = card.getAttribute('data-foto');

                modalPhoto.src = foto;
                modalPhoto.alt = nama;
                modalNim.textContent = nim;
                modalNama.textContent = nama;
                modalTanggungJawab.textContent = tanggungJawab;

                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        const doClose = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };

        closeModal.addEventListener('click', doClose);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) doClose();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) doClose();
        });
    });
</script>
@endsection
