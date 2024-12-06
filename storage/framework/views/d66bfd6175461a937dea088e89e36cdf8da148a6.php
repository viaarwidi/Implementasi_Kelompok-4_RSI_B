<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni Dashboard</title>
    <link rel="stylesheet" href="css/testimoniDashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <span class="logo-blue">Donasi</span><span class="logo-orange">Aja!</span>
            </div>
            <a href="/adminDashboard">
                <div class="menu-item">Admin Dashboard</div>
            </a>
            <a href="/testimoni">
                <div class="menu-item active">Testimoni</div>
            </a>
            <div class="menu-item logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="header">
                <h1>Testimoni</h1>
            </div>
            <div class="controls">
                <div class="search-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search by Message" id="searchInput">
                    </div>
                </div>
                <button class="btn btn-success" onclick="openAddTestimoniModal()">Tambah Testimoni</button>
            </div>

            <div class="table-wrapper">
                <table id="testimoniTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pengguna</th>
                            <th>Program</th>
                            <th>Pesan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="testimoniModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
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
                            <label for="pengguna-id" class="form-label">ID Pengguna</label>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchTestimoni();
        });

        async function fetchTestimoni() {
            const response = await fetch('/api/testimoni');
            const testimoni = await response.json();
            const tableBody = document.querySelector('#testimoniTable tbody');
            tableBody.innerHTML = '';

            testimoni.forEach(item => {
                const row = `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.pengguna.nama || 'Unknown'}</td>
                        <td>${item.programDonasi.nama_program || 'Unknown'}</td>
                        <td>${item.pesan}</td>
                        <td>
                            <button class="btn btn-warning" onclick="openEditTestimoniModal(${item.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteTestimoni(${item.id})">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        function openAddTestimoniModal() {
            document.getElementById('testimoniForm').reset();
            document.getElementById('modalLabel').textContent = 'Tambah Testimoni';
            const modal = new bootstrap.Modal(document.getElementById('testimoniModal'));
            modal.show();
        }

        async function openEditTestimoniModal(id) {
            const response = await fetch(`/api/testimoni/${id}`);
            const testimoni = await response.json();

            document.getElementById('testimoni-id').value = testimoni.id;
            document.getElementById('pengguna-id').value = testimoni.id_pengguna;
            document.getElementById('program-id').value = testimoni.id_program;
            document.getElementById('pesan').value = testimoni.pesan;

            document.getElementById('modalLabel').textContent = 'Edit Testimoni';
            const modal = new bootstrap.Modal(document.getElementById('testimoniModal'));
            modal.show();
        }

        async function submitTestimoni() {
            const id = document.getElementById('testimoni-id').value;
            const data = {
                id_pengguna: document.getElementById('pengguna-id').value,
                id_program: document.getElementById('program-id').value,
                pesan: document.getElementById('pesan').value
            };

            const url = id ? `/api/testimoni/${id}` : '/api/testimoni';
            const method = id ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            alert(result.message);
            fetchTestimoni();
            const modal = bootstrap.Modal.getInstance(document.getElementById('testimoniModal'));
            modal.hide();
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
<?php /**PATH C:\xampp\htdocs\Donasiweb\resources\views/testimoni.blade.php ENDPATH**/ ?>