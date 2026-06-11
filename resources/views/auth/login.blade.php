@extends('layouts.app')

@section('title', 'Masuk Admin')

@section('content')
<div class="auth-wrapper">
    <div class="glass-card auth-card">
        <div class="auth-header">
            <h2>Masuk Admin</h2>
            <p>Silakan masuk untuk mengelola data anggota kelompok</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" 
                    placeholder="nama@email.com" 
                    required 
                    autofocus
                >
                @error('email')
                    <span class="form-error">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="••••••••" 
                    required
                >
                @error('password')
                    <span class="form-error">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group">
                <label class="form-check">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</div>
@endsection
