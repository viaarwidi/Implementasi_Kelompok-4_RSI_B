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
                    <h1>Daftar Event</h1>
                    <i class="fas fa-external-link-alt"></i>
                </div>
                <div class="event-info">
                    <span>Event</span>
                    <div class="project-count">240 project</div>
                </div>
            </div>
            <div class="controls">
                <div class="view-controls">
                    <button class="btn-view active" data-filter="all">View all</button>
                    <button class="btn-view" data-filter="accepted">Accepted</button>
                    <button class="btn-view" data-filter="declined">Declined</button>
                    <button class="btn-view" data-filter="pending">Pending</button>
                </div>
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
            </div>
            <div class="table-wrapper">
                <table id="eventTable">
                    <thead>
                    <tr>
                        <th class="sortable">
                               ID Admin Event
                                <i class="fas fa-chevron-down"></i>
                            </th>
                            <th class="sortable">
                                Nama Event
                                <i class="fas fa-chevron-down"></i>
                            </th>
                            <th>Deskripsi</th>
                            <th>Target Donasi</th>
                            <th>Tanggal Mulai</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Gambar</th>
                            <th>Actions</th>
                        </tr>    
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <!-- Add Program Button -->
                <button class="btn btn-outline-primary" id="addProgramButton" onclick="openAddProgramModal()">Add Program</button>
            </div> 
            <div class="pagination">
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
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to edit program -->
                <form id="editProgramForm">
                    <input type="hidden" id="edit-program-id" name="id">
                    <div class="mb-3">
                        <label for="program-id-admin" class="form-label">ID Admin</label>
                        <input type="text" class="form-control" id="program-id-admin" name="id_admin" required>
                    </div>
                    <div class="mb-3">
                        <label for="program-name" class="form-label">Program Name</label>
                        <input type="text" class="form-control" id="program-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="program-description" class="form-label">Description</label>
                        <textarea class="form-control" id="program-description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="program-target" class="form-label">Target Amount</label>
                        <input type="number" class="form-control" id="program-target" name="target_donasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="program-mulai" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="program-mulai" name="tanggal_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="program-selesai" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="program-selesai" name="tanggal_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="program-gambar" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="program-gambar" name="gambar" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitProgramForm()">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Add Program Button -->
 <div class="add-program-btn">
        <button class="btn btn-success" onclick="openAddProgramModal()">Tambah Program</button>
    </div>
    <!-- Script Section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    fetchProgramDonasi();
    setupEventListeners();
});
//buat munculin data
async function fetchProgramDonasi() {
    try {
        const response = await fetch('/api/program-donasi');
        const data = await response.json();
        updateTable(data);
        updateProjectCount(data.length);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

function updateTable(data) {
    const tbody = document.querySelector('#eventTable tbody');
    tbody.innerHTML = '';
    data.forEach(program => {
        const row = `
            <tr data-status="${program.status}">
                <td>
                    <div class="admin-avatar">${program.id_admin || 'N/A'}</div>
                </td>
                <td>${program.nama_program}</td>
                <td>${program.deskripsi}</td>
                <td>${program.target_donasi}</td>
                <td>${formatDate(program.tanggal_mulai)}</td>
                <td>${formatDate(program.tanggal_selesai)}</td>
                <td><span class="status ${program.status}">${capitalizeFirstLetter(program.status)}</span></td>
                <td>${program.gambar}</td>
                <td class="actions">
                    <button class="btn-action" onclick="openEditModal(${program.id_program})">
                        <i class="far fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="deleteProgram(${program.id_program})">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

async function deleteProgram(id) {
    if (confirm('Are you sure you want to delete this program?')) {
        try {
            const response = await fetch(`/api/program-donasi/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                alert('Program successfully deleted!');
                // Refresh data from the server to keep it consistent
                fetchProgramDonasi();
            } else {
                alert('Failed to delete the program!');
            }
        } catch (error) {
            console.error('Error deleting program:', error);
        }
    }
}


function openEditModal(id) {
    // Fetch program data and pre-fill the form
    fetch(`/api/program-donasi/${id}`)
        .then(response => response.json())
        .then(program => {
                console.log(program);
            // Populate form fields with program data
            document.getElementById('program-id-admin').value = program.id_admin;
            document.getElementById('edit-program-id').value = program.id_program;
            document.getElementById('program-name').value = program.nama_program;
            document.getElementById('program-description').value = program.deskripsi;
            document.getElementById('program-target').value = program.target_donasi;
            document.getElementById('program-mulai').value = program.tanggal_mulai;
            document.getElementById('program-selesai').value = program.tanggal_selasai;
            document.getElementById('program-gambar').value = program.gambar;
            

            // Change modal title for editing
            const modalTitle = document.getElementById('editModalLabel');
            modalTitle.textContent = 'Edit Program';

            // Show the modal
            const programModal = new bootstrap.Modal(document.getElementById('editModal'));
            programModal.show();
        })
        .catch(error => console.error('Error fetching program data:', error));
}

function openAddProgramModal() {
    // Clear the form fields for adding a new program
  
    document.getElementById('edit-program-id').value = '';
    document.getElementById('program-id-admin').value = '';
    document.getElementById('program-name').value = '';
    document.getElementById('program-description').value = '';
    document.getElementById('program-target').value = '';
    document.getElementById('program-mulai').value ='';
    document.getElementById('program-selesai').value = '';
    document.getElementById('program-gambar').value = '';

    // Change modal title for adding
    const modalTitle = document.getElementById('editModalLabel');
    modalTitle.textContent = 'Tambah Program';

    // Show the modal
    const programModal = new bootstrap.Modal(document.getElementById('editModal'));
    programModal.show();

}
async function submitProgramForm() {
    const programId = document.getElementById('edit-program-id').value;
    const programData = {
        id_admin: document.getElementById('program-id-admin').value.trim(),
        nama_program: document.getElementById('program-name').value.trim(),
        deskripsi: document.getElementById('program-description').value.trim(),
        target_donasi: document.getElementById('program-target').value.trim(),
        tanggal_mulai: document.getElementById('program-mulai').value.trim(),
        tanggal_selesai: document.getElementById('program-selesai').value.trim(),
        gambar: document.getElementById('program-gambar').value.trim(),
    };

    // Validasi form: cek apakah ada kolom yang kosong
    for (const [key, value] of Object.entries(programData)) {
        if (!value) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: `Form "${key.replace('_', ' ')}" tidak boleh kosong!`,
                confirmButtonText: 'OK',
            });
            return; // Hentikan eksekusi jika ada form kosong
        }
    }

    try {
        let response;
        if (programId) {
            // Update existing program (Edit)
            response = await fetch(`/api/program-donasi/${programId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(programData),
            });
        } else {
            // Add new program
            response = await fetch('/api/program-donasi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(programData),
            });
        }

        if (response.ok) {
            const result = await response.json();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: result.message,
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.reload(); // Refresh halaman untuk menampilkan perubahan
            });
        } else {
            const error = await response.json();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: `Error: ${error.message}`,
                confirmButtonText: 'OK',
            });
        }
    } catch (error) {
        console.error('Error submitting program form:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terdapat Kesalahan',
            text: 'Tanggal Due date mendahului start date.',
            confirmButtonText: 'OK',
        });
    }
}


// async function submitProgramForm() {
//     const programId = document.getElementById('edit-program-id').value;
//     const programData = {
//         id_admin: document.getElementById('program-id-admin').value,
//         nama_program: document.getElementById('program-name').value,
//         deskripsi: document.getElementById('program-description').value,
//         target_donasi: document.getElementById('program-target').value,
//         tanggal_mulai: document.getElementById('program-mulai').value,
//         tanggal_selesai: document.getElementById('program-selesai').value,
//         gambar: document.getElementById('program-gambar').value,
//     };

//     try {
//         let response;
//         if (programId) {
//             // Update existing program (Edit)
//             response = await fetch(`/api/program-donasi/${programId}`, {
//                 method: 'PUT',
//                 headers: {
//                     'Content-Type': 'application/json',
//                 },
//                 body: JSON.stringify(programData),
//             });
//         } else {
//             // Add new program
//             response = await fetch('/api/program-donasi', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                 },
//                 body: JSON.stringify(programData),
//             });
//         }

//         if (response.ok) {
//             const result = await response.json();
//             alert(result.message);
//             window.location.reload(); // Refresh the page to reflect changes
//         } else {
//             const error = await response.json();
//             alert(`Error: ${error.message}`);
//         }
//     } catch (error) {
//         console.error('Error submitting program form:', error);
//     }
// }


function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function updateProjectCount(count) {
    document.querySelector('.project-count').textContent = `${count} project`;
}

function setupEventListeners() {
    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', async () => {
            const filter = button.dataset.filter;
            document.querySelectorAll('.btn-view').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            const response = await fetch('/api/program-donasi');
            const data = await response.json();
            const filteredData = filter === 'all' ? data : data.filter(program => program.status === filter);
            updateTable(filteredData);
        });
    });

    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', async (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const response = await fetch('/api/program-donasi');
        const data = await response.json();
        const filteredData = data.filter(program =>
            program.nama_program.toLowerCase().includes(searchTerm) ||
            program.id_admin?.toLowerCase().includes(searchTerm)
        );
        updateTable(filteredData);
    });
}
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Donasiweb\resources\views/daftarevent.blade.php ENDPATH**/ ?>