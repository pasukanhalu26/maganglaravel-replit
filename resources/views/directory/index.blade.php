@extends('layouts.app')

@section('content')
<div class="text-center mt-12 mb-20">
    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Cek Siapa yang Menelponmu</h2>
    <p class="text-gray-600 mb-10 text-lg">Lindungi diri Anda dari penipuan dengan database publik kami.</p>
    
    <form action="{{ route('search') }}" method="GET" class="flex items-center w-full max-w-lg mx-auto bg-white rounded-full shadow-lg border border-gray-200 overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition-all">
        <input type="text" name="phone" placeholder="Contoh: 081234567890" required class="flex-grow px-6 py-4 outline-none text-gray-800 placeholder-gray-400 font-medium text-lg" />
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 transition-colors">
            Cari Nomor
        </button>
    </form>
    @error('phone')
        <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
    @enderror
</div>
@endsection
