<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- Pengaturan Dasar & Layout --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f5f7;
            color: #333;
        }

        /* a. Bagian atas berisi header [cite: 109] */
        header {
            background-color: #0080ff; /* Warna biru gelap / slate grey sesuai gambar */
            color: #ffffff;
            padding: 12px 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center; /* Menyejajarkan logo dan teks secara vertikal */
            gap: 15px; /* Jarak antara kotak logo dan teks */
        }

        .logo-box {
            background-color: rgba(255, 255, 255, 0.15); /* Efek background transparan terang */
            width: 40px;
            height: 40px;
            border-radius: 10px; /* Sudut tumpul persis seperti gambar */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }

        /* Desain Wadah Teks */
        .header-text {
            display: flex;
            flex-direction: column;
        }

        .judul-header {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 2px; /* Jarak tipis antara judul dan subjudul */
        }

        .subtitle-header {
            font-size: 12px;
            color: #aeb8c3; /* Warna abu-abu kebiruan terang untuk subjudul */
            font-weight: normal;
        }

        .container {
            display: flex;
            height: calc(100vh - 60px);
        }

        /* b. Bagian kiri berisi navigasi [cite: 110] */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
        }

        .sidebar button {
            display: block;
            width: 100%;
            padding: 12px 25px;
            border: none;
            background: none;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
            color: #555;
            transition: all 0.2s;
        }

        .sidebar button i {
            width: 25px;
            color: #888;
        }

        .sidebar button:hover,
        .sidebar button.active {
            background-color: #f0f7ff;
            color: #0066cc;
            font-weight: 600;
            border-right: 3px solid #0066cc;
        }

        .sidebar button:hover i,
        .sidebar button.active i {
            color: #0066cc;
        }

        /* c. Bagian kanan menampilkan data [cite: 111] */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* --- Desain Komponen Konten --- */
        .header-konten {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-konten h2 {
            margin: 0;
            font-size: 22px;
        }

        /* Tombol Tambah (Hijau) */
        .btn-tambah {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        /* --- Desain Tabel --- */
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
        }

        /* Tombol Aksi Tabel */
        .btn-aksi {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            color: white;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #2196F3;
        }

        .btn-hapus-tabel {
            background-color: #f44336;
        }

        /* --- Desain Modal Formulir (Sesuai Gambar 3, 4, 7, 8, 11, 12 UTS) --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 450px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-box h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            color: #555;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-simpan {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-batal {
            background-color: #9e9e9e;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* --- Desain Modal Hapus (Sesuai Gambar 5, 9, 13 UTS) --- */
        .modal-hapus-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 350px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .icon-hapus-lingkaran {
            width: 60px;
            height: 60px;
            background-color: #ffebee;
            color: #f44336;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px auto;
        }

        .modal-hapus-box h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .modal-hapus-box p {
            color: #888;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .btn-hapus-merah {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .badge-biru {
            background-color: #e3f2fd;
            /* Warna latar biru muda */
            color: #0066cc;
            /* Warna teks biru tua */
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
        }

        /* --- Desain Grid untuk Form Penulis --- */
        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .foto-profil-tabel {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 90%;
            border: 1px solid #ddd;
        }

        .password-tersamarkan {
            font-family: monospace;
            letter-spacing: 2px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-family: inherit;
        }
    </style>
</head>

<body>

<header>
        <div class="logo-box">
            <i class="fas fa-newspaper"></i> 
        </div>
        
        <div class="header-text">
            <div class="judul-header">Sistem Manajemen Blog (CMS)</div>
            <div class="subtitle-header">Blog Keren</div>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <button onclick="loadMenu('penulis')" id="menu-penulis"><i class="fas fa-user"></i> Kelola Penulis</button>
            <button onclick="loadMenu('artikel')" id="menu-artikel"><i class="fas fa-file"></i> Kelola Artikel</button>
            <button onclick="loadMenu('kategori')" id="menu-kategori"><i class="fas fa-folder"></i> Kelola Kategori Artikel</button>
        </div>

        <div class="content" id="main-content">
            <div class="card">
                <h2>Selamat Datang di Sistem Manajemen Blog (CMS)</h2>
                <p>Silakan pilih menu di sebelah kiri untuk mulai mengelola data anda.</p>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalFormKategori">
        <div class="modal-box">
            <h3 id="judulModalKategori">Tambah Kategori</h3>
            <form id="formKategori">
                <input type="hidden" id="id_kategori">

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" id="input_nama_kategori" placeholder="Nama kategori..." required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea id="input_keterangan" rows="4" placeholder="Deskripsi kategori..." required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="tutupModalKategori()">Batal</button>
                    <button type="button" class="btn-simpan" id="btnSimpanKategori" onclick="simpanDataKategori()">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalFormPenulis">
        <div class="modal-box" style="width: 550px;">
            <h3 id="judulModalPenulis">Tambah Penulis</h3>
            <form id="formPenulis">
                <input type="hidden" id="id_penulis">

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Depan</label>
                        <input type="text" id="input_nama_depan" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Belakang</label>
                        <input type="text" id="input_nama_belakang" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="input_user_name" required>
                </div>

                <div class="form-group">
                    <label id="label_password">Password</label>
                    <input type="password" id="input_password">
                    <small id="hint_password" style="display:none; color:#888; font-size:12px;">(kosongkan jika tidak diganti)</small>
                </div>

                <div class="form-group">
                    <label id="label_foto">Foto Profil</label>
                    <input type="file" id="input_foto" accept="image/*">
                    <small id="hint_foto" style="display:none; color:#888; font-size:12px;">(kosongkan jika tidak diganti)</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="tutupModalPenulis()">Batal</button>
                    <button type="button" class="btn-simpan" id="btnSimpanPenulis" onclick="simpanDataPenulis()">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalFormArtikel">
        <div class="modal-box" style="width: 600px;">
            <h3 id="judulModalArtikel">Tambah Artikel</h3>
            <form id="formArtikel">
                <input type="hidden" id="id_artikel">

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" id="input_judul_artikel" placeholder="Judul artikel..." required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Penulis</label>
                        <select id="input_id_penulis" required>
                            <option value="">Pilih Penulis...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="input_id_kategori" required>
                            <option value="">Pilih Kategori...</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Isi Artikel</label>
                    <textarea id="input_isi_artikel" rows="5" placeholder="Tulis isi artikel di sini..." required></textarea>
                </div>

                <div class="form-group">
                    <label id="label_gambar_artikel">Gambar</label>
                    <input type="file" id="input_gambar_artikel" accept="image/*">
                    <small id="hint_gambar_artikel" style="display:none; color:#888; font-size:12px;">(kosongkan jika tidak diganti)</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="tutupModalArtikel()">Batal</button>
                    <button type="button" class="btn-simpan" id="btnSimpanArtikel" onclick="simpanDataArtikel()">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalHapus">
        <div class="modal-hapus-box">
            <div class="icon-hapus-lingkaran">
                <i class="fas fa-trash-alt"></i>
            </div>
            <h3>Hapus data ini?</h3>
            <p>Data yang dihapus tidak dapat dikembalikan.</p> <input type="hidden" id="id_hapus_target">
            <input type="hidden" id="jenis_hapus_target">

            <div style="display: flex; justify-content: center; gap: 10px;">
                <button type="button" class="btn-batal" onclick="tutupModalHapus()">Batal</button>
                <button type="button" class="btn-hapus-merah" onclick="eksekusiHapus()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        // Set menu aktif
        function setActiveMenu(menuId) {
            document.querySelectorAll('.sidebar button').forEach(btn => btn.classList.remove('active'));
            document.getElementById(menuId).classList.add('active');
        }

        // Fungsi Routing SPA
        function loadMenu(menu) {
            const contentDiv = document.getElementById('main-content');

            if (menu === 'kategori') {
                setActiveMenu('menu-kategori');
                contentDiv.innerHTML = `
                    <div class="header-konten">
                        <h2>Data Kategori Artikel</h2> <button class="btn-tambah" onclick="bukaModalKategori('tambah')"><i class="fas fa-plus"></i> Tambah Kategori</button>
                    </div>
                    <div class="card">
                        <table>
                            <thead>
                                <tr>
                                    <th>NAMA KATEGORI</th>
                                    <th>KETERANGAN</th>
                                    <th style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="data-kategori">
                                <tr><td colspan="3" style="text-align:center;">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>
                `;
                fetchDataKategori();

            } else if (menu === 'penulis') {
                setActiveMenu('menu-penulis');
                contentDiv.innerHTML = `
                    <div class="header-konten">
                        <h2>Data Penulis</h2> <button class="btn-tambah" onclick="bukaModalPenulis('tambah')"><i class="fas fa-plus"></i> Tambah Penulis</button>
                    </div>
                    <div class="card">
                        <table>
                            <thead>
                                <tr>
                                    <th>FOTO</th>
                                    <th>NAMA</th>
                                    <th>USERNAME</th>
                                    <th>PASSWORD</th>
                                    <th style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="data-penulis">
                                <tr><td colspan="5" style="text-align:center;">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>
                `;
                fetchDataPenulis();

            } else if (menu === 'artikel') {
                setActiveMenu('menu-artikel');
                contentDiv.innerHTML = `
                    <div class="header-konten">
                        <h2>Data Artikel</h2>
                        <button class="btn-tambah" onclick="bukaModalArtikel('tambah')"><i class="fas fa-plus"></i> Tambah Artikel</button>
                    </div>
                    <div class="card">
                        <table>
                            <thead>
                                <tr>
                                    <th>GAMBAR</th>
                                    <th>JUDUL</th>
                                    <th>KATEGORI</th>
                                    <th>PENULIS</th>
                                    <th>TANGGAL</th>
                                    <th style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="data-artikel">
                                <tr><td colspan="6" style="text-align:center;">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>
                `;
                fetchDataArtikel(); 
            }


        }

        // ==========================================
        // FUNGSI KENDALI MODAL (TAMPILAN)
        // ==========================================

        // Modal Form Kategori
        function bukaModalKategori(mode) {
            const modal = document.getElementById('modalFormKategori');
            modal.style.display = 'flex';

            if (mode === 'tambah') {
                document.getElementById('judulModalKategori').innerText = 'Tambah Kategori';
                document.getElementById('btnSimpanKategori').innerText = 'Simpan Data';
                document.getElementById('formKategori').reset();
                document.getElementById('id_kategori').value = '';
            } else {
                document.getElementById('judulModalKategori').innerText = 'Edit Kategori';
                document.getElementById('btnSimpanKategori').innerText = 'Simpan Perubahan';
            }
        }

        function tutupModalKategori() {
            document.getElementById('modalFormKategori').style.display = 'none';
        }

        // Modal Konfirmasi Hapus
        function konfirmasiHapus(id, jenis) {
            document.getElementById('modalHapus').style.display = 'flex';
            document.getElementById('id_hapus_target').value = id;
            document.getElementById('jenis_hapus_target').value = jenis; // untuk bedakan hapus kategori/penulis/artikel
        }

        function tutupModalHapus() {
            document.getElementById('modalHapus').style.display = 'none';
        }

        function eksekusiHapus() {
            // Nanti dihubungkan dengan Fetch API hapus_kategori.php
            alert("Fungsi hapus akan dijalankan");
            tutupModalHapus();
        }

        // Load awal menu Kategori
        // loadMenu('kategori');

        // Fungsi untuk mengambil data kategori dari server [cite: 2012-2013]
        function fetchDataKategori() {
            fetch('ambil_kategori.php')
                .then(response => response.json()) // Mengubah respons menjadi JSON [cite: 2014]
                .then(data => {
                    const tabel = document.getElementById('data-kategori');

                    if (data.length === 0) {
                        tabel.innerHTML = `<tr><td colspan="3" style="text-align:center; color:#999; font-style: italic;">Belum ada data kategori.</td></tr>`;
                        return;
                    }

                    tabel.innerHTML = ''; // Kosongkan tabel sebelum diisi

                    data.forEach(baris => {
                        // Buat baris baru untuk tabel dengan badge biru pada Nama Kategori
                        tabel.innerHTML += `
                    <tr>
                        <td><span class="badge-biru">${baris.nama_kategori}</span></td>
                        <td>${baris.keterangan}</td>
                        <td>
                            <button class="btn-aksi btn-edit" onclick="editKategori(${baris.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-aksi btn-hapus-tabel" onclick="konfirmasiHapus(${baris.id}, 'kategori')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                `;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function simpanDataKategori() {
            const id = document.getElementById('id_kategori').value;
            const nama = document.getElementById('input_nama_kategori').value;
            const ket = document.getElementById('input_keterangan').value;

            const formData = new FormData();
            formData.append('nama_kategori', nama);
            formData.append('keterangan', ket);

            // Default file tujuan adalah simpan data baru
            let urlTujuan = 'simpan_kategori.php';

            // JIKA ID ADA ISINYA, UBAH TUJUAN MENJADI UPDATE
            if (id !== '') {
                formData.append('id', id);
                urlTujuan = 'update_kategori.php';
            }

            fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sukses') {
                        alert(data.pesan);
                        tutupModalKategori();
                        fetchDataKategori(); // Refresh tabel langsung
                    } else {
                        alert(data.pesan);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function editKategori(id) {
            const formData = new FormData();
            formData.append('id', id);

            // Minta data spesifik ke server
            fetch('ambil_satu_kategori.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Buka modal dengan tampilan 'edit' (judul dan tombol berubah)
                    bukaModalKategori('edit');

                    // Isi otomatis form-nya dengan data dari database [cite: 352-353]
                    document.getElementById('id_kategori').value = data.id;
                    document.getElementById('input_nama_kategori').value = data.nama_kategori;
                    document.getElementById('input_keterangan').value = data.keterangan;
                })
                .catch(error => console.error('Error:', error));
        }

        function eksekusiHapus() {
            // Ambil ID dan jenis data dari input tersembunyi di dalam modal
            const id = document.getElementById('id_hapus_target').value;
            const jenis = document.getElementById('jenis_hapus_target').value;

            // Jika yang sedang dihapus adalah kategori
            if (jenis === 'kategori') {
                const formData = new FormData();
                formData.append('id', id);

                // Kirim permintaan hapus ke server tanpa reload
                fetch('hapus_kategori.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'sukses') {
                            tutupModalHapus(); // Sembunyikan modal merah
                            fetchDataKategori(); // Refresh tabel secara otomatis
                        } else {
                            alert(data.pesan); // Tampilkan alert peringatan jika gagal
                            tutupModalHapus();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // ==========================================
        // FUNGSI KENDALI MODAL PENULIS
        // ==========================================
        function bukaModalPenulis(mode) {
            const modal = document.getElementById('modalFormPenulis');
            modal.style.display = 'flex';

            const hintPass = document.getElementById('hint_password');
            const hintFoto = document.getElementById('hint_foto');
            const labelPass = document.getElementById('label_password');
            const labelFoto = document.getElementById('label_foto');

            if (mode === 'tambah') {
                document.getElementById('judulModalPenulis').innerText = 'Tambah Penulis';
                document.getElementById('btnSimpanPenulis').innerText = 'Simpan Data';
                document.getElementById('formPenulis').reset();
                document.getElementById('id_penulis').value = '';

                // Wajib isi password saat tambah
                document.getElementById('input_password').required = true;

                // Sembunyikan hint "kosongkan jika tidak diganti"
                hintPass.style.display = 'none';
                hintFoto.style.display = 'none';
                labelPass.innerText = 'Password';
                labelFoto.innerText = 'Foto Profil';
            } else {
                document.getElementById('judulModalPenulis').innerText = 'Edit Penulis';
                document.getElementById('btnSimpanPenulis').innerText = 'Simpan Perubahan';

                // Password tidak wajib isi saat edit
                document.getElementById('input_password').required = false;

                // Tampilkan hint "kosongkan jika tidak diganti" sesuai UTS
                hintPass.style.display = 'inline';
                hintFoto.style.display = 'inline';
                labelPass.innerText = 'Password Baru ';
            }
        }

        function tutupModalPenulis() {
            document.getElementById('modalFormPenulis').style.display = 'none';
        }

        function simpanDataPenulis() {
            // Ambil semua nilai dari input
            const id = document.getElementById('id_penulis').value;
            const namaDepan = document.getElementById('input_nama_depan').value;
            const namaBelakang = document.getElementById('input_nama_belakang').value;
            const userName = document.getElementById('input_user_name').value;
            const password = document.getElementById('input_password').value;

            // Ambil file foto dari input type="file"
            const inputFoto = document.getElementById('input_foto');
            const fileFoto = inputFoto.files.length > 0 ? inputFoto.files[0] : null;

            // Bungkus data ke dalam objek FormData untuk dikirim via AJAX
            const formData = new FormData();
            formData.append('nama_depan', namaDepan);
            formData.append('nama_belakang', namaBelakang);
            formData.append('user_name', userName);
            formData.append('password', password);

            if (fileFoto) {
                formData.append('foto', fileFoto);
            }

            // Tentukan URL. Nanti kita tambahkan logika jika ID ada, maka update_penulis.php
            let urlTujuan = 'simpan_penulis.php';
            if (id !== '') {
                formData.append('id', id);
                urlTujuan = 'update_penulis.php';
            }

            fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sukses') {
                        alert(data.pesan);
                        tutupModalPenulis();
                        fetchDataPenulis();
                    } else {
                        alert(data.pesan); // Tampilkan pesan error jika foto kebesaran atau tipe salah
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchDataPenulis() {
            fetch('ambil_penulis.php')
                .then(response => response.json())
                .then(data => {
                    const tabel = document.getElementById('data-penulis');
                    tabel.innerHTML = '';

                    if (data.length === 0) {
                        tabel.innerHTML = `<tr><td colspan="5" style="text-align:center;">Belum ada data penulis.</td></tr>`;
                        return;
                    }

                    data.forEach(baris => {
                        // Susun path gambar ke folder uploads_penulis
                        const pathFoto = `uploads_penulis/${baris.foto}`;

                        tabel.innerHTML += `
                            <tr>
                                <td><img src="${pathFoto}" class="foto-profil-tabel" style="width:70px; height:50px; object-fit:cover; border-radius:4px; border:1px solid #ddd;" alt="Foto Profil"></td>
                                <td>${baris.nama_depan} ${baris.nama_belakang}</td>
                                <td><span class="badge-biru">${baris.user_name}</span></td>
                                <td><span class="password-tersamarkan">********</span></td>
                                <td>
                                    <button class="btn-aksi btn-edit" onclick="editPenulis(${baris.id})"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn-aksi btn-hapus-tabel" onclick="konfirmasiHapus(${baris.id}, 'penulis')"><i class="fas fa-trash"></i> Hapus</button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function editPenulis(id) {
            const formData = new FormData();
            formData.append('id', id);

            // Minta data ke server
            fetch('ambil_satu_penulis.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Ubah tampilan modal menjadi mode edit (menampilkan hint kosongkan password/foto) 
                    bukaModalPenulis('edit');

                    // Isi form dengan data lama
                    document.getElementById('id_penulis').value = data.id;
                    document.getElementById('input_nama_depan').value = data.nama_depan;
                    document.getElementById('input_nama_belakang').value = data.nama_belakang;
                    document.getElementById('input_user_name').value = data.user_name;

                    // Kosongkan input password dan foto agar user tidak bingung
                    document.getElementById('input_password').value = '';
                    document.getElementById('input_foto').value = '';
                })
                .catch(error => console.error('Error:', error));
        }

        function eksekusiHapus() {
            // Ambil ID dan jenis data dari input tersembunyi di dalam modal
            const id = document.getElementById('id_hapus_target').value;
            const jenis = document.getElementById('jenis_hapus_target').value;

            // Jika yang sedang dihapus adalah kategori
            if (jenis === 'kategori') {
                const formData = new FormData();
                formData.append('id', id);

                fetch('hapus_kategori.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'sukses') {
                            tutupModalHapus();
                            fetchDataKategori();
                        } else {
                            alert(data.pesan);
                            tutupModalHapus();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            // JIKA YANG SEDANG DIHAPUS ADALAH PENULIS
            else if (jenis === 'penulis') {
                const formData = new FormData();
                formData.append('id', id);

                fetch('hapus_penulis.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'sukses') {
                            tutupModalHapus(); // Sembunyikan modal merah
                            fetchDataPenulis(); // Refresh tabel penulis secara otomatis
                        } else {
                            alert(data.pesan); // Tampilkan alert peringatan jika gagal (misal masih ada artikel)
                            tutupModalHapus();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // JIKA YANG SEDANG DIHAPUS ADALAH ARTIKEL
            else if (jenis === 'artikel') {
                const formData = new FormData();
                formData.append('id', id);

                fetch('hapus_artikel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sukses') {
                        tutupModalHapus();
                        fetchDataArtikel(); // Refresh tabel artikel
                    } else {
                        alert(data.pesan);
                        tutupModalHapus();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // ==========================================
        // FUNGSI KENDALI MODAL ARTIKEL
        // ==========================================
        function bukaModalArtikel(mode) {
            const modal = document.getElementById('modalFormArtikel');
            modal.style.display = 'flex';

            const hintGambar = document.getElementById('hint_gambar_artikel');
            const labelGambar = document.getElementById('label_gambar_artikel');

            if (mode === 'tambah') {
                document.getElementById('judulModalArtikel').innerText = 'Tambah Artikel';
                document.getElementById('btnSimpanArtikel').innerText = 'Simpan Data';
                document.getElementById('formArtikel').reset();
                document.getElementById('id_artikel').value = '';

                document.getElementById('input_gambar_artikel').required = true;
                hintGambar.style.display = 'none';
                labelGambar.innerText = 'Gambar';
            } else {
                document.getElementById('judulModalArtikel').innerText = 'Edit Artikel';
                document.getElementById('btnSimpanArtikel').innerText = 'Simpan Perubahan';

                document.getElementById('input_gambar_artikel').required = false;
                hintGambar.style.display = 'inline';
                labelGambar.innerText = 'Gambar Baru ';
            }

            // Panggil API untuk mengisi dropdown Penulis dan Kategori
            isiDropdownOpsi();
        }

        function tutupModalArtikel() {
            document.getElementById('modalFormArtikel').style.display = 'none';
        }

        // Fungsi fetch untuk menyuplai data ke dalam tag <select>
        function isiDropdownOpsi() {
            fetch('ambil_opsi.php')
                .then(response => response.json())
                .then(data => {
                    const selectKategori = document.getElementById('input_id_kategori');
                    const selectPenulis = document.getElementById('input_id_penulis');

                    // Reset opsi menjadi default dulu
                    selectKategori.innerHTML = '<option value="">Pilih Kategori...</option>';
                    selectPenulis.innerHTML = '<option value="">Pilih Penulis...</option>';

                    // Isi dropdown Kategori
                    data.kategori.forEach(kat => {
                        selectKategori.innerHTML += `<option value="${kat.id}">${kat.nama_kategori}</option>`;
                    });

                    // Isi dropdown Penulis
                    data.penulis.forEach(pen => {
                        selectPenulis.innerHTML += `<option value="${pen.id}">${pen.nama_depan} ${pen.nama_belakang}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching options:', error));
        }

        function fetchDataArtikel() {
            fetch('ambil_artikel.php')
                .then(response => response.json())
                .then(data => {
                    const tabel = document.getElementById('data-artikel');
                    tabel.innerHTML = '';

                    if (data.length === 0) {
                        tabel.innerHTML = `<tr><td colspan="6" style="text-align:center;">Belum ada artikel.</td></tr>`;
                        return;
                    }

                    data.forEach(baris => {
                        const pathGambar = `uploads_artikel/${baris.gambar}`;

                        tabel.innerHTML += `
                    <tr>
                        <td><img src="${pathGambar}" style="width:70px; height:50px; object-fit:cover; border-radius:4px;"></td>
                        <td><strong>${baris.judul}</strong></td>
                        <td><span class="badge-biru">${baris.nama_kategori}</span></td>
                        <td>${baris.nama_penulis}</td>
                        <td><small>${baris.hari_tanggal}</small></td>
                        <td>
                            <button class="btn-aksi btn-edit" onclick="editArtikel(${baris.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn-aksi btn-hapus-tabel" onclick="konfirmasiHapus(${baris.id}, 'artikel')"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function simpanDataArtikel() {
            const id = document.getElementById('id_artikel').value;
            const judul = document.getElementById('input_judul_artikel').value;
            const penulis = document.getElementById('input_id_penulis').value;
            const kategori = document.getElementById('input_id_kategori').value;
            const isi = document.getElementById('input_isi_artikel').value;
            const inputGambar = document.getElementById('input_gambar_artikel');

            // Validasi sederhana
            if (!judul || !penulis || !kategori || !isi) {
                alert("Harap lengkapi semua data!");
                return;
            }

            const formData = new FormData();
            formData.append('judul_artikel', judul);
            formData.append('id_penulis', penulis);
            formData.append('id_kategori', kategori);
            formData.append('isi_artikel', isi);

            if (inputGambar.files.length > 0) {
                formData.append('gambar', inputGambar.files[0]);
            }

            let urlTujuan = 'simpan_artikel.php';
            if (id !== '') {
                formData.append('id', id);
                urlTujuan = 'update_artikel.php';
            }

            fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sukses') {
                        alert(data.pesan);
                        tutupModalArtikel();
                        fetchDataArtikel();
                    } else {
                        alert(data.pesan);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function editArtikel(id) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('ambil_satu_artikel.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                bukaModalArtikel('edit');
                
                document.getElementById('id_artikel').value = data.id;
                document.getElementById('input_judul_artikel').value = data.judul;
                document.getElementById('input_isi_artikel').value = data.isi;
                document.getElementById('input_gambar_artikel').value = '';

                // Tunggu 300 milidetik agar fungsi isiDropdownOpsi() selesai menarik data dari database
                setTimeout(() => {
                    document.getElementById('input_id_penulis').value = data.id_penulis;
                    document.getElementById('input_id_kategori').value = data.id_kategori;
                }, 300);
            })
            .catch(error => console.error('Error:', error));
        }


    </script>
</body>

</html>