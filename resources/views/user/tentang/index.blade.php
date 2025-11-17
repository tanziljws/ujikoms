@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
        background: #f3f6fc;
        color: #333;
    }

    /* ===== Header ===== */
    .page-header {
        background-color: #1e40af;
        color: white;
        text-align: center;
        padding: 60px 20px;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        animation: fadeIn 1s ease;
    }
    .page-header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
        font-weight: 700;
    }
    .page-header p {
        font-size: 1.1em;
        opacity: 0.9;
    }

    /* ===== Section & Card ===== */
    section {
        padding: 40px 16px;
        max-width: 1200px;
        margin: auto;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 5px solid transparent;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-left-color: #2563eb;
    }

    h2 {
        color: #1e40af;
        font-size: 1.6em;
        margin-bottom: 15px;
        border-left: 4px solid #2563eb;
        padding-left: 10px;
        font-weight: 600;
    }

    p, li {
        line-height: 1.7;
        font-size: 1em;
    }

    /* ===== Grid & Feature Box ===== */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 18px;
        margin-top: 15px;
    }

    .feature {
        background-color: #2563eb;
        color: white;
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .feature:hover {
        background-color: #1d4ed8;
        transform: scale(1.04);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    .feature span {
        font-size: 2rem;
        display: block;
        margin-bottom: 8px;
    }

    /* ===== Iframe ===== */
    iframe {
        width: 100%;
        height: 350px;
        border: 0;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .page-header {
            padding: 50px 15px;
        }
        .page-header h1 {
            font-size: 2em;
        }
        .page-header p {
            font-size: 1em;
        }
        .card {
            padding: 20px;
        }
        .feature {
            padding: 20px;
            font-size: 0.95em;
        }
        iframe {
            height: 250px;
        }
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-10px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1>SMKN 4 Kota Bogor</h1>
    <p>💡 Mencetak Generasi Unggul, Berkarakter, dan Siap Bersaing!</p>
</div>

<section>
    <div class="card">
        <h2>🏫 Tentang Sekolah</h2>
        <p>
            SMKN 4 Kota Bogor merupakan salah satu sekolah menengah kejuruan negeri terbaik di Kota Bogor.
            Fokus utama kami adalah pendidikan vokasi untuk mencetak lulusan yang siap kerja, 
            berwirausaha, maupun melanjutkan ke jenjang pendidikan lebih tinggi.
        </p>

        <div style="margin-top: 20px;">
            <h3 style="color:#1e40af;">🎥 Video Profil Sekolah</h3>
            <iframe 
                src="https://www.youtube.com/embed/auya1s3yif4?si=cIDNtAfkhVm9e44q"
                title="Profil SMKN 4 Kota Bogor"
                allowfullscreen>
            </iframe>
        </div>
    </div>

    <div class="card">
        <h2>💼 Program Keahlian</h2>
        <div class="grid">
            <div class="feature"><span>💻</span>PPLG</div>
            <div class="feature"><span>📡</span>TJKT</div>
            <div class="feature"><span>⚙️</span>TFLM</div>
            <div class="feature"><span>🚗</span>TKRO</div>
        </div>
    </div>

    <div class="card">
        <h2>🏆 Prestasi Sekolah</h2>
        <ul>
            <li>🥇 Juara 1 LKS Tingkat Provinsi Jawa Barat</li>
            <li>🥈 Finalis Nasional OST 2023</li>
            <li>🤝 Best Partnership dengan PT Telkom Indonesia</li>
            <li>🌿 Sekolah Adiwiyata 2023</li>
        </ul>
    </div>

    <div class="card">
        <h2>🏢 Fasilitas Sekolah</h2>
        <div class="grid">
            <div class="feature"><span>🏫</span>Ruang Kelas Ber-AC</div>
            <div class="feature"><span>🔬</span>Laboratorium Lengkap</div>
            <div class="feature"><span>📚</span>Perpustakaan Modern</div>
            <div class="feature"><span>⚽</span>Lapangan Olahraga</div>
            <div class="feature"><span>🎤</span>Aula Kegiatan</div>
            <div class="feature"><span>☕</span>Kantin Bersih</div>
        </div>
    </div>

    <div class="card">
        <h2>📍 Lokasi Sekolah</h2>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.065268435975!2d106.82888927499153!3d-6.256978361299832!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5c59b53679b%3A0x9a8080f93aebbf51!2sSMKN%204%20Bogor!5e0!3m2!1sid!2sid!4v1694235871735!5m2!1sid!2sid" 
            allowfullscreen 
            loading="lazy">
        </iframe>
    </div>
</section>


@endsection
