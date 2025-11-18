<footer class="bg-white text-gray-700 py-10 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6" x-data="{ open1:false, open2:false }">

        <!-- Grid Footer -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm md:text-base items-start text-center md:text-center">

            <!-- Kolom 1: Tentang Kami -->
            <div class="border-b border-gray-200 md:border-none pb-4 md:pb-0" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    class="flex justify-between md:justify-center items-center w-full md:cursor-default md:pointer-events-none"
                >
                    <h3 class="text-lg font-semibold mb-2 text-blue-600">Tentang Kami</h3>
                    <svg xmlns="https://www.w3.org/2000/svg"
                        class="h-5 w-5 text-blue-600 transform transition-transform duration-300 md:hidden"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div 
                    x-show="open || window.innerWidth >= 768" 
                    x-transition 
                    class="text-gray-600 leading-relaxed mt-2 max-w-sm mx-auto"
                >
                    SMKN 4 Kota Bogor berkomitmen mencetak siswa berprestasi, berakhlak, dan siap kerja.
                </div>
            </div>

            <!-- Kolom 2: Kontak -->
            <div class="border-b border-gray-200 md:border-none pb-4 md:pb-0" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    class="flex justify-between md:justify-center items-center w-full md:cursor-default md:pointer-events-none"
                >
                    <h3 class="text-lg font-semibold mb-2 text-blue-600">Kontak</h3>
                    <svg xmlns="https://www.w3.org/2000/svg"
                        class="h-5 w-5 text-blue-600 transform transition-transform duration-300 md:hidden"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul 
                    x-show="open || window.innerWidth >= 768" 
                    x-transition 
                    class="space-y-2 text-gray-600 mt-2"
                >
                    <li>📍 Jl. Raya Tajur No.45, Kota Bogor</li>
                    <li>📞 (0251) 832-1234</li>
                    <li>✉️ info@smkn4bogor.sch.id</li>
                </ul>
            </div>

            <!-- Kolom 3: Ikuti Kami -->
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-3 text-blue-600">Ikuti Kami</h3>
                <p class="text-gray-600 mb-3">Terhubung dengan kami di media sosial:</p>
                <div class="flex justify-center space-x-5 text-gray-600 text-lg">
                    <a href="#" class="hover:text-blue-600 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-blue-600 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-blue-600 transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-blue-600 transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

        </div>

        <!-- Hak cipta -->
        <div class="border-t border-gray-300 mt-10 pt-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} SMKN 4 Kota Bogor. Semua hak dilindungi.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
