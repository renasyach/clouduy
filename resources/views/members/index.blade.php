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
             data-name="{{ $member->name }}" 
             data-nim="{{ $member->nim }}" 
             data-role="{{ $member->role }}" 
             data-email="{{ $member->email }}" 
             data-phone="{{ $member->phone ?? 'Tidak ada' }}" 
             data-github="{{ $member->github }}" 
             data-linkedin="{{ $member->linkedin }}" 
             data-bio="{{ $member->bio ?? 'Anggota ini belum menambahkan deskripsi biografi.' }}" 
             data-photo="{{ asset($member->photo ?? 'images/default-avatar.png') }}">
            
            <div class="member-photo-container">
                <img src="{{ asset($member->photo ?? 'images/default-avatar.png') }}" alt="{{ $member->name }}" class="member-photo">
            </div>
            
            <div class="member-info">
                <div class="member-nim">{{ $member->nim }}</div>
                <h3 class="member-name">{{ $member->name }}</h3>
                <p class="member-role">{{ $member->role }}</p>
                
                <div class="member-socials">
                    @if($member->github)
                        <a href="{{ $member->github }}" target="_blank" class="social-link" title="GitHub" onclick="event.stopPropagation();">
                            <i class="fa-brands fa-github"></i>
                        </a>
                    @endif
                    @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" target="_blank" class="social-link" title="LinkedIn" onclick="event.stopPropagation();">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                    @endif
                    <a href="mailto:{{ $member->email }}" class="social-link" title="Kirim Email" onclick="event.stopPropagation();">
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
            <i class="fa-solid fa-users-slash" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3>Belum ada anggota terdaftar</h3>
            <p style="color: var(--text-secondary); margin-top: 0.5rem;">Silakan masuk sebagai admin untuk melakukan seeding data atau menambah anggota.</p>
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
                <h2 class="member-name" id="modalName" style="font-size: 1.75rem;">Nama Lengkap</h2>
                <div class="member-role" id="modalRole" style="margin-bottom: 1rem; color: var(--primary);">Jabatan / Peran</div>
                
                <p class="modal-bio" id="modalBio">Deskripsi biografi anggota kelompok...</p>
                
                <div style="margin-top: 1.5rem; border-top: 1px solid var(--card-border); padding-top: 1.25rem;">
                    <div class="modal-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span id="modalEmail">email@student.univ.ac.id</span>
                    </div>
                    <div class="modal-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span id="modalPhone">+62 812-3456-7890</span>
                    </div>
                </div>

                <div class="member-socials" style="margin-top: 1.5rem; border: none; padding: 0;" id="modalSocialsContainer">
                    <!-- Dinamis terisi link medsos -->
                </div>
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
        
        // Modal elements
        const modalPhoto = document.getElementById('modalPhoto');
        const modalNim = document.getElementById('modalNim');
        const modalName = document.getElementById('modalName');
        const modalRole = document.getElementById('modalRole');
        const modalBio = document.getElementById('modalBio');
        const modalEmail = document.getElementById('modalEmail');
        const modalPhone = document.getElementById('modalPhone');
        const modalSocialsContainer = document.getElementById('modalSocialsContainer');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const name = card.getAttribute('data-name');
                const nim = card.getAttribute('data-nim');
                const role = card.getAttribute('data-role');
                const email = card.getAttribute('data-email');
                const phone = card.getAttribute('data-phone');
                const github = card.getAttribute('data-github');
                const linkedin = card.getAttribute('data-linkedin');
                const bio = card.getAttribute('data-bio');
                const photo = card.getAttribute('data-photo');

                // Populate Modal Data
                modalPhoto.src = photo;
                modalPhoto.alt = name;
                modalNim.textContent = nim;
                modalName.textContent = name;
                modalRole.textContent = role;
                modalBio.textContent = bio;
                modalEmail.textContent = email;
                modalPhone.textContent = phone;

                // Populate Social Links
                let socialsHtml = '';
                if (github && github !== 'null') {
                    socialsHtml += `<a href="${github}" target="_blank" class="social-link" title="GitHub"><i class="fa-brands fa-github"></i> GitHub</a>`;
                }
                if (linkedin && linkedin !== 'null') {
                    socialsHtml += `<a href="${linkedin}" target="_blank" class="social-link" title="LinkedIn" style="margin-left: 1rem;"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>`;
                }
                modalSocialsContainer.innerHTML = socialsHtml;

                // Show Modal
                modal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Disable page scrolling
            });
        });

        // Close Modal events
        const doClose = () => {
            modal.classList.remove('active');
            document.body.style.overflow = ''; // Restore page scrolling
        };

        closeModal.addEventListener('click', doClose);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                doClose();
            }
        });

        // Close on ESC key press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                doClose();
            }
        });
    });
</script>
@endsection
