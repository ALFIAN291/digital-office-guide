@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Ganti Password</span>
    </div>

    <div>
        <h1 class="text-2xl font-extrabold text-[#0f2e54]">Perbarui Kata Sandi (Password)</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ubah kata sandi akun administrator untuk menjaga keamanan sistem CMS</p>
    </div>

    <form action="{{ route('admin.password.update') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Password Saat Ini:</label>
            <input type="password" name="current_password" required
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Password Baru (Minimal 8 Karakter):</label>
            <input type="password" name="new_password" required
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Password Baru:</label>
            <input type="password" name="new_password_confirmation" required
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-md transition">
                Simpan Password Baru
            </button>
        </div>
    </form>

</div>
@endsection

