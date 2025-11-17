<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button id="close-lightbox" class="absolute -top-10 right-0 text-white text-2xl">
            <i class="fas fa-times"></i>
        </button>
        <div class="bg-white rounded-lg overflow-hidden">
            <img id="lightbox-image" src="#" alt="" class="w-full max-h-[70vh] object-contain" />
            <div class="p-4 bg-gray-800 text-white">
                <h3 id="lightbox-title" class="font-bold text-lg"></h3>
                <p id="lightbox-description" class="text-gray-300"></p>
                <p id="lightbox-date" class="text-sm text-gray-400 mt-2"></p>
            </div>
        </div>
        <button id="prev-btn" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 bg-white p-2 rounded-full shadow-lg hover:bg-gray-100">
            <i class="fas fa-chevron-left text-gray-800"></i>
        </button>
        <button id="next-btn" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 bg-white p-2 rounded-full shadow-lg hover:bg-gray-100">
            <i class="fas fa-chevron-right text-gray-800"></i>
        </button>
    </div>
</div>




