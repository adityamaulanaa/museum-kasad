<footer class="bg-black text-white border-t border-gray-800 pt-8 pb-4 mt-12">
    <div class="container mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        
        <div class="flex flex-col items-center md:items-start">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Museum" class="h-12 mb-3">
            <h2 class="text-xl font-serif tracking-widest text-yellow-500 text-center md:text-left">
            </h2>
        </div>

        <div class="font-serif tracking-wide text-center md:text-left">
            <h3 class="text-lg text-yellow-500 mb-2">ALAMAT</h3>
            <p class="text-gray-300 text-xs md:text-sm leading-relaxed">
                Jl. ABCDE, Kota Bogor,
                Jawa Barat, Indonesia
            </p>
        </div>

        <div class="font-serif tracking-wide text-center md:text-right">
            <h3 class="text-lg text-yellow-500 mb-2">CONTACT US</h3>
            <div class="text-gray-300 text-xs md:text-sm leading-relaxed space-y-1">
                <p>Email : contact@kasad.id</p>
                <p>instagram : @museum_kasad</p>
                <p>Telepon : 0251 651 998</p>
            </div>
        </div>

    </div>

    <div class="text-center text-gray-500 text-xs border-t border-gray-800 pt-4 mt-8">
        &copy; {{ date('Y') }} Museum KASAD. All Rights Reserved.
    </div>
</footer>