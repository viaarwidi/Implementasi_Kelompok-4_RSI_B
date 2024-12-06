<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main-container">
       <!-- Sidebar -->
       <div class="sidebar">
            <div class="logo">
                <span class="logo-blue">Donasi</span><span class="logo-orange">Aja!</span>
            </div>
            <a href="/adminDashboard" class="menu-item inactive">Admin Dashboard</a>
            <a href="/daftarevent" class="menu-item with-icon">
                <i class="far fa-calendar"></i>
                Program Donasi
            </a>
            <a href="/daftartestimoni" class="menu-item with-icon">
                <i class="far fa-comment"></i>
                Testimoni
            </a>
            <a href="/settings" class="menu-item with-icon">
                <i class="fas fa-cog"></i>
                Settings
            </a>
            <div class="logout">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </div>
        </div>
        <!-- Main Content -->
        <div class="content">
            <div class="header">
                <div class="title-group">
                    <h1>Daftar Testimoni</h1>
                    <i class="fas fa-external-link-alt"></i>
                </div>
                <div class="event-info">
                    <span>Event</span>
                    <div class="project-count">240 project</div>
                </div>
            </div>
            <div class="controls">
                <div class="search-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search">
                    </div>
                    <button class="btn-filters">
                        <i class="fas fa-sliders-h"></i>
                        Filters
                    </button>
                </div>
                <div class="d-flex justify-content-end">
                <!-- Add Program Button -->
                <button class="btn btn-outline-primary" id="addProgramButton" onclick="openAddTestimoniModal()">Add Testimoni</button>
            </div> 
            </div>
            <div class="table-wrapper">
                <table id="eventTable">
                    <thead>
                    <tr>
                    <th>ID Testimoni</th>
                            <th>Pengguna</th>
                            <th>Program</th>
                            <th>Pesan</th>
                            <th>Actions</th>
                        </tr>    
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="button-container">
            </div> <div class="pagination">
                <button class="btn-nav">
                    <i class="fas fa-chevron-left"></i>
                    Previous
                </button>
                <span>Page 1 of 10</span>
                <button class="btn-nav">
                    Next
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Edit Program Modal -->
<!-- Modal Structure -->
< <div class="modal fade" id="testimoniModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="testimoniForm">
                        <input type="hidden" id="testimoni-id">
                        <div class="mb-3">
                            <label for="pengguna-id" class="form-label">ID Admin</label>
                            <input type="number" id="pengguna-id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="program-id" class="form-label">ID Program</label>
                            <input type="number" id="program-id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea id="pesan" class="form-control" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitTestimoni()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Script Section -->
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            fetchTestimoni();
        });

async function fetchTestimoni() {
    try {
        const response = await fetch('/api/testimoni');
        const testimoni = await response.json();
        console.log('Testimoni Data:', testimoni);

        const tableBody = document.querySelector('#eventTable tbody');
        tableBody.innerHTML = '';

        testimoni.forEach(item => {
            const row = `
                <tr>
                    <td>${item.id_testimoni}</td>
                    <td>${item.pengguna?.nama_lengkap || 'Unknown'}</td>
                    <td>${item.program_donasi?.nama_program || 'Unknown'}</td>
                    <td>${item.pesan}</td>
                    <td class="actions">
                    <button class="btn-action" onclick="openEditTestimoniModal(${item.id_testimoni})">
                        <i class="far fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="deleteTestimoni(${item.id_testimoni})">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    } catch (error) {
        console.error('Error fetching testimoni:', error);
    }
}

        function openAddTestimoniModal() {
            // document.getElementById('testimoniForm').reset();
            document.getElementById('testimoni-id').value = '';
            document.getElementById('pengguna-id').value = '';
            document.getElementById('program-id').value = '';
            document.getElementById('pesan').value = '';
            document.getElementById('modalLabel').textContent = 'Tambah Testimoni';
            const modal = new bootstrap.Modal(document.getElementById('testimoniModal'));
            modal.show();
        }

        async function openEditTestimoniModal(id) {
            const response = await fetch(`/api/testimoni/${id}`);
            const testimoni = await response.json();

            document.getElementById('testimoni-id').value = testimoni.id_testimoni;
            document.getElementById('pengguna-id').value = testimoni.id_pengguna;
            document.getElementById('program-id').value = testimoni.id_program;
            document.getElementById('pesan').value = testimoni.pesan;

            document.getElementById('modalLabel').textContent = 'Edit Testimoni';
            const modal = new bootstrap.Modal(document.getElementById('testimoniModal'));
            modal.show();
                }
                
            
    async function submitTestimoni() {
    const id = document.getElementById('testimoni-id').value.trim();
    const data = {
        id_pengguna: document.getElementById('pengguna-id').value.trim(),
        id_program: document.getElementById('program-id').value.trim(),
        pesan: document.getElementById('pesan').value.trim(),
    };

    // Validasi: pastikan semua kolom diisi
    for (const [key, value] of Object.entries(data)) {
        if (!value) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: `Form "${key.replace('_', ' ')}" tidak boleh kosong!`,
            });
            return; // Hentikan eksekusi jika ada form kosong
        }
    }

    const url = id ? `/api/testimoni/${id}` : '/api/testimoni';
    const method = id ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            // Tangani error berdasarkan status kode
            const error = await response.json();
            if (response.status === 404) {
                Swal.fire({
                    icon: 'error',
                    title: 'ID Tidak Ditemukan',
                    text: 'ID yang dimasukkan tidak tersedia di database. Silakan periksa kembali.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: error.message || 'Terjadi kesalahan saat memproses permintaan.',
                });
            }
            return; // Hentikan eksekusi jika terjadi error
        }

        // Jika berhasil
        const result = await response.json();
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: result.message,
        }).then(() => {
            fetchTestimoni();
            const modal = bootstrap.Modal.getInstance(document.getElementById('testimoniModal'));
            modal.hide();
        });
    } catch (error) {
        console.error('Error saat mengirim data:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal Submit data',
            text: 'ID Pengguna / ID Program tidak ada di database. Silakan periksa kembali.'
        });
    }
}

        async function deleteTestimoni(id) {
            if (confirm('Are you sure?')) {
                const response = await fetch(`/api/testimoni/${id}`, { method: 'DELETE' });
                const result = await response.json();
                alert(result.message);
                fetchTestimoni();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
