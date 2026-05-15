@extends('layouts.app')

@section('content')
<!-- Form Pencarian Ulang -->
<form action="{{ route('search') }}" method="GET" class="flex mb-8 shadow-sm">
    <input type="text" name="phone" value="{{ request('phone') }}" required class="flex-grow px-5 py-3 border rounded-l-lg outline-none focus:border-blue-500" />
    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 font-medium">Cari</button>
</form>

<div class="bg-white rounded-2xl shadow-sm border p-6 mb-8 text-center">
    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wide">Hasil Pencarian</p>
    <h2 class="text-4xl font-black text-gray-900 mt-2">{{ $cleanPhone }}</h2>
</div>

@if($number && $number->tags->isNotEmpty())
    <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
        Menemukan {{ $number->tags->count() }} Penanda (Tags)
    </h3>
    
    <div class="space-y-3">
        @foreach($number->tags as $index => $tag)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="bg-blue-50 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg mr-4 flex-shrink-0">
                    {{ strtoupper(substr($tag->name, 0, 1)) }}
                </div>
                <p class="text-gray-800 font-medium text-lg">{{ $tag->name }}</p>
            </div>

            <!-- [3] SLOT ADSENSE: In-Article (Ditengah list tag) -->
            @if($index == 2)
                <div class="w-full h-auto py-6 bg-gray-50 border border-dashed border-gray-300 flex items-center justify-center text-gray-500 text-sm my-4">
                    [ KODE ADSENSE IN-ARTICLE ]
                </div>
            @endif
        @endforeach
    </div>
@else
    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-8 text-center mt-6">
        <p class="text-gray-500 text-lg mb-4">Belum ada penanda untuk nomor ini.</p>
        <p class="text-sm text-gray-400">Jadilah yang pertama menandai nomor ini untuk membantu orang lain!</p>
    </div>
@endif

@auth
<div class="mt-12 pt-8 border-t text-center">
    <h4 class="text-lg font-bold text-gray-800 mb-2">Kontrol Privasi</h4>
    <p class="text-sm text-gray-500 mb-4">Jika ini nomor Anda, Anda bisa menyembunyikannya dari pencarian publik.</p>
    
    <form action="{{ route('privacy.toggle') }}" method="POST" class="inline-block">
        @csrf
        <input type="hidden" name="phone_number" value="{{ $cleanPhone }}">
        <input type="hidden" name="is_hidden" value="{{ $number && $number->is_hidden ? '0' : '1' }}">
        
        <button type="submit" class="{{ $number && $number->is_hidden ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-sm">
            {{ $number && $number->is_hidden ? 'Tampilkan Nomor Saya' : 'Sembunyikan Nomor Saya' }}
        </button>
    </form>
</div>
@endauth

@if(session('success'))
<div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

@endsection
