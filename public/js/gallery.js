// Modal gallery image preview
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("image-modal");
    const modalImg = document.getElementById("modal-img");
    const captionText = document.getElementById("caption");
    const closeBtn = document.getElementsByClassName("close")[0];

    // Buka modal saat gambar diklik
    const images = document.querySelectorAll(".gallery-img");
    images.forEach((img) => {
        img.addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt || "";
        });
    });

    // Tutup modal saat tombol 'x' diklik
    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    // Tutup modal saat klik di luar gambar
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});
