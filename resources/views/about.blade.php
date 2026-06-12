@extends('layouts.app')

@section('content')
<div class="bg-black min-h-screen text-white pt-32 pb-16 font-sans">
    <div class="container mx-auto px-6 md:px-12 lg:px-20 mt-10 md:mt-16">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-20 items-center">
            
            <div class="w-full">
                <img src="{{ asset('images/about-museum.jpg') }}" alt="Suasana Museum" class="w-full h-auto object-cover rounded-xl shadow-2xl border border-gray-900 aspect-[4/5] opacity-90">
            </div>
            
            <div class="w-full space-y-6">
                <h3 class="text-yellow-600 font-semibold tracking-[0.2em] text-sm md:text-base uppercase">
                    SEJARAH KAMI
                </h3>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-white leading-tight mb-8">
                    Dari Koleksi Kecil<br>Menjadi Warisan Bangsa
                </h1>
                
                <div class="text-gray-300 leading-relaxed text-base md:text-lg space-y-6 font-serif">
                    <p>
                        Museum ASAD didirikan pada tahun 2025 dengan misi sederhana namun kuat yaitu melestarikan dan memperkenalkan kekayaan budaya dan seni kepada masyarakat luas.
                    </p>
                    <p>
                        Berawal dari koleksi pribadi yang disumbangkan oleh para pelopor seni, museum ini berkembang menjadi salah satu institusi budaya terkemuka yang menyimpan ribuan artefak berharga dari berbagai era dan peradaban.
                    </p>
                </div>

                <div class="pt-6">
                    <a href="{{ route('tiket') }}" class="inline-block bg-[#5a4e17] hover:bg-[#7a6b22] text-white font-medium text-sm md:text-base py-3 px-10 rounded-full transition-all duration-300 shadow-lg">
                        Beli Tiket
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

@include('components.footer')
@endsection