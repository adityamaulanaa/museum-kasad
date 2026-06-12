@extends('layouts.app')

@section('content')
    <div x-data="{ 
            activeSlide: 1, 
            slides: [1, 2, 3, 4, 5], 
            init() { 
                setInterval(() => { 
                    this.activeSlide = this.activeSlide === this.slides.length ? 1 : this.activeSlide + 1; 
                }, 5000); 
            } 
        }" 
        class="relative h-screen w-full overflow-hidden bg-black">

        <template x-for="slide in slides" :key="slide">
            <div x-show="activeSlide === slide" 
                 x-transition:enter="transition-opacity ease-in-out duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in-out duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 z-0">
                
                <img :src="`/images/bg-${slide}.jpg`" alt="Background Museum" class="w-full h-full object-cover">
                
                <div class="absolute inset-0 bg-black/50"></div>
            </div>
        </template>

        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-center px-4">
            <h2 class="text-xl md:text-2xl text-yellow-500 tracking-widest font-serif mb-2">SELAMAT DATANG DI</h2>
            <h1 class="text-5xl md:text-7xl font-bold text-white tracking-wider mb-8 font-serif">MUSEUM<br>KASAD</h1>
            
            <a href="{{ route('tiket') }}" 
               class="bg-transparent border border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-300 px-8 py-3 rounded-sm text-lg tracking-widest font-semibold">
                PESAN TIKET
            </a>
        </div>

        <div class="absolute bottom-10 left-0 right-0 z-10 flex justify-center gap-3">
            <template x-for="slide in slides" :key="slide">
                <button @click="activeSlide = slide" 
                        :class="{'w-8 bg-yellow-500': activeSlide === slide, 'w-3 bg-white/50 hover:bg-white': activeSlide !== slide}" 
                        class="h-3 rounded-full transition-all duration-500 focus:outline-none">
                </button>
            </template>
        </div>

    </div>
    @include('components.footer')
@endsection