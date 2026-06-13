<?php
// index.php - Satu halaman utama dengan sidebar + modal
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .sidebar { background: #2c3e50; min-height: 100vh; }
        .sidebar .nav-link { color: #ecf0f1; border-radius: 0; padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #1abc9c; color: white; }
        .content-area { padding: 20px; }
        .table img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
        .modal-lg { max-width: 800px; }
        .btn-action { margin: 0 3px; }
        .alert-fixed { position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 250px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="text-center py-4 text-white">
                <h4><i class="fas fa-blog"></i> Blog CMS</h4>
                <hr class="bg-light">
            </div>
            <nav class="nav flex-column">
                <a href="#" class="nav-link active" data-menu="penulis"><i class="fas fa-users me-2"></i> Kelola Penulis</a>
                <a href="#" class="nav-link" data-menu="artikel"><i class="fas fa-newspaper me-2"></i> Kelola Artikel</a>
                <a href="#" class="nav-link" data-menu="kategori"><i class="fas fa-tags me-2"></i> Kelola Kategori Artikel</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-0">
            <div class="content-area">
                <div id="dynamicTitle" class="d-flex justify-content-between align-items-center mb-3">
                    <h2 id="pageTitle">Kelola Penulis</h2>
                    <button id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</button>
                </div>
                <div id="tableContainer">
                    <div class="text-center p-5">Memuat data...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL PENULIS ==================== -->
<div class="modal fade" id="penulisModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="penulisModalTitle">Tambah Penulis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPenulis" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="penulisId">
                    <div class="mb-3">
                        <label>Nama Depan</label>
                        <input type="text" name="nama_depan" id="nama_depan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Belakang</label>
                        <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="mb-3">
                        <label>Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Max 2MB (JPG,PNG). Biarkan kosong jika tidak diubah.</small>
                        <div id="previewFoto" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL KATEGORI ==================== -->
<div class="modal fade" id="kategoriModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="kategoriModalTitle">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKategori">
                <div class="modal-body">
                    <input type="hidden" name="id" id="kategoriId">
                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL ARTIKEL ==================== -->
<div class="modal fade" id="artikelModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="artikelModalTitle">Tambah Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formArtikel" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="artikelId">
                    <div class="mb-3">
                        <label>Judul Artikel</label>
                        <input type="text" name="judul" id="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Penulis</label>
                        <select name="id_penulis" id="id_penulis" class="form-control" required></select>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-control" required></select>
                    </div>
                    <div class="mb-3">
                        <label>Isi Artikel</label>
                        <textarea name="isi" id="isi" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gambar Artikel (wajib upload untuk tambah)</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                        <div id="previewGambar" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Global state
let currentMenu = 'penulis';
let penulisModalObj, kategoriModalObj, artikelModalObj;

// Helper show alert
function showAlert(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-fixed`;
    alertDiv.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

// Load data berdasarkan menu
function loadData(menu) {
    let url = '';
    if (menu === 'penulis') url = 'ambil_penulis.php';
    else if (menu === 'artikel') url = 'ambil_artikel.php';
    else url = 'ambil_kategori.php';

    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                renderTable(menu, data.data);
            } else {
                document.getElementById('tableContainer').innerHTML = `<div class="alert alert-danger">Gagal memuat data</div>`;
            }
        })
        .catch(err => {
            document.getElementById('tableContainer').innerHTML = `<div class="alert alert-danger">Error: ${err.message}</div>`;
        });
}

// Render HTML table berdasarkan menu
function renderTable(menu, items) {
    let html = '<div class="table-responsive"><table class="table table-bordered table-hover bg-white"><thead class="table-dark"><tr>';
    if (menu === 'penulis') {
        html += '<th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th>';
    } else if (menu === 'artikel') {
        html += '<th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th>';
    } else {
        html += '<th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th>';
    }
    html += '</tr></thead><tbody>';

    if (items.length === 0) {
        html += '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
    } else {
        items.forEach(item => {
            if (menu === 'penulis') {
                const fotoSrc = item.foto ? `uploads_penulis/${item.foto}` : 'uploads_penulis/default.png';
                html += `<tr>
                            <td><img src="${fotoSrc}" width="50"></td>
                            <td>${escapeHtml(item.nama)}</td>
                            <td>${escapeHtml(item.user_name)}</td>
                            <td>●●●●●●</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${item.id}"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}"><i class="fas fa-trash"></i> Hapus</button>
                            </td>
                        </tr>`;
            } else if (menu === 'artikel') {
                const imgSrc = `uploads_artikel/${item.gambar}`;
                html += `<tr>
                            <td><img src="${imgSrc}" width="50"></td>
                            <td>${escapeHtml(item.judul)}</td>
                            <td>${escapeHtml(item.nama_kategori)}</td>
                            <td>${escapeHtml(item.penulis)}</td>
                            <td>${escapeHtml(item.hari_tanggal)}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${item.id}"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}"><i class="fas fa-trash"></i> Hapus</button>
                            </td>
                        </tr>`;
            } else {
                html += `<tr>
                            <td>${escapeHtml(item.nama_kategori)}</td>
                            <td>${escapeHtml(item.keterangan || '-')}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${item.id}"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}"><i class="fas fa-trash"></i> Hapus</button>
                            </td>
                        </tr>`;
            }
        });
    }
    html += '</tbody></table></div>';
    document.getElementById('tableContainer').innerHTML = html;

    // Attach event listeners tombol edit & hapus
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = btn.getAttribute('data-id');
            openEditModal(menu, id);
        });
    });
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = btn.getAttribute('data-id');
            if (confirm('Yakin ingin menghapus data ini?')) {
                deleteItem(menu, id);
            }
        });
    });
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// ---- Operasi Hapus ----
function deleteItem(menu, id) {
    let url = '';
    if (menu === 'penulis') url = 'hapus_penulis.php';
    else if (menu === 'artikel') url = 'hapus_artikel.php';
    else url = 'hapus_kategori.php';

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showAlert(data.message, 'success');
            loadData(currentMenu);
        } else {
            showAlert(data.message, 'danger');
        }
    });
}

// Buka modal edit + ambil data detail
function openEditModal(menu, id) {
    let url = '';
    if (menu === 'penulis') {
        url = `ambil_satu_penulis.php?id=${id}`;
        fetch(url).then(res=>res.json()).then(data=>{
            if(data.status==='success'){
                document.getElementById('penulisModalTitle').innerText = 'Edit Penulis';
                document.getElementById('penulisId').value = data.data.id;
                document.getElementById('nama_depan').value = data.data.nama_depan;
                document.getElementById('nama_belakang').value = data.data.nama_belakang;
                document.getElementById('user_name').value = data.data.user_name;
                document.getElementById('password').value = '';
                document.getElementById('previewFoto').innerHTML = data.data.foto ? `<img src="uploads_penulis/${data.data.foto}" width="80">` : '';
                new bootstrap.Modal(document.getElementById('penulisModal')).show();
            }
        });
    } else if (menu === 'kategori') {
        url = `ambil_satu_kategori.php?id=${id}`;
        fetch(url).then(res=>res.json()).then(data=>{
            if(data.status==='success'){
                document.getElementById('kategoriModalTitle').innerText = 'Edit Kategori';
                document.getElementById('kategoriId').value = data.data.id;
                document.getElementById('nama_kategori').value = data.data.nama_kategori;
                document.getElementById('keterangan').value = data.data.keterangan;
                new bootstrap.Modal(document.getElementById('kategoriModal')).show();
            }
        });
    } else if (menu === 'artikel') {
        url = `ambil_satu_artikel.php?id=${id}`;
        fetch(url).then(res=>res.json()).then(data=>{
            if(data.status==='success'){
                document.getElementById('artikelModalTitle').innerText = 'Edit Artikel';
                document.getElementById('artikelId').value = data.data.id;
                document.getElementById('judul').value = data.data.judul;
                document.getElementById('isi').value = data.data.isi;
                // load dropdown penulis & kategori
                loadPenulisDropdown(data.data.id_penulis);
                loadKategoriDropdown(data.data.id_kategori);
                document.getElementById('previewGambar').innerHTML = `<img src="uploads_artikel/${data.data.gambar}" width="100"> <p>Gambar saat ini: ${data.data.gambar}</p>`;
                new bootstrap.Modal(document.getElementById('artikelModal')).show();
            }
        });
    }
}

function loadPenulisDropdown(selectedId = null) {
    fetch('ambil_penulis_list.php')
        .then(res => res.json())
        .then(data => {
            let options = '<option value="">-- Pilih Penulis --</option>';
            if (data.status === 'success') {
                data.data.forEach(penulis => {
                    options += `<option value="${penulis.id}" ${selectedId == penulis.id ? 'selected' : ''}>${escapeHtml(penulis.nama_lengkap)}</option>`;
                });
            }
            document.getElementById('id_penulis').innerHTML = options;
        });
}

function loadKategoriDropdown(selectedId = null) {
    fetch('ambil_kategori_list.php')
        .then(res => res.json())
        .then(data => {
            let options = '<option value="">-- Pilih Kategori --</option>';
            if (data.status === 'success') {
                data.data.forEach(kat => {
                    options += `<option value="${kat.id}" ${selectedId == kat.id ? 'selected' : ''}>${escapeHtml(kat.nama_kategori)}</option>`;
                });
            }
            document.getElementById('id_kategori').innerHTML = options;
        });
}

// Event handler menu sidebar
document.querySelectorAll('[data-menu]').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('[data-menu]').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        currentMenu = link.getAttribute('data-menu');
        let title = '';
        if (currentMenu === 'penulis') title = 'Kelola Penulis';
        else if (currentMenu === 'artikel') title = 'Kelola Artikel';
        else title = 'Kelola Kategori Artikel';
        document.getElementById('pageTitle').innerText = title;
        loadData(currentMenu);
    });
});

// Tombol tambah data
document.getElementById('btnAdd').addEventListener('click', () => {
    if (currentMenu === 'penulis') {
        document.getElementById('penulisModalTitle').innerText = 'Tambah Penulis';
        document.getElementById('formPenulis').reset();
        document.getElementById('penulisId').value = '';
        document.getElementById('previewFoto').innerHTML = '';
        new bootstrap.Modal(document.getElementById('penulisModal')).show();
    } else if (currentMenu === 'kategori') {
        document.getElementById('kategoriModalTitle').innerText = 'Tambah Kategori';
        document.getElementById('formKategori').reset();
        document.getElementById('kategoriId').value = '';
        new bootstrap.Modal(document.getElementById('kategoriModal')).show();
    } else if (currentMenu === 'artikel') {
        document.getElementById('artikelModalTitle').innerText = 'Tambah Artikel';
        document.getElementById('formArtikel').reset();
        document.getElementById('artikelId').value = '';
        loadPenulisDropdown();
        loadKategoriDropdown();
        document.getElementById('previewGambar').innerHTML = '';
        new bootstrap.Modal(document.getElementById('artikelModal')).show();
    }
});

// Submit forms
document.getElementById('formPenulis').addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const id = document.getElementById('penulisId').value;
    const url = id ? 'update_penulis.php' : 'simpan_penulis.php';
    fetch(url, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message);
                bootstrap.Modal.getInstance(document.getElementById('penulisModal')).hide();
                loadData('penulis');
            } else showAlert(data.message, 'danger');
        });
});

document.getElementById('formKategori').addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const id = document.getElementById('kategoriId').value;
    const url = id ? 'update_kategori.php' : 'simpan_kategori.php';
    fetch(url, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message);
                bootstrap.Modal.getInstance(document.getElementById('kategoriModal')).hide();
                loadData('kategori');
            } else showAlert(data.message, 'danger');
        });
});

document.getElementById('formArtikel').addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const id = document.getElementById('artikelId').value;
    const url = id ? 'update_artikel.php' : 'simpan_artikel.php';
    fetch(url, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message);
                bootstrap.Modal.getInstance(document.getElementById('artikelModal')).hide();
                loadData('artikel');
            } else showAlert(data.message, 'danger');
        });
});

// Inisialisasi awal
loadData('penulis');
</script>
</body>
</html>