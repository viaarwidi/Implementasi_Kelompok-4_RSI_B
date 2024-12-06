<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
    <div class="main-container">
        
        <!-- Main Content -->
        <div class="content">
            <div class="header">
                <div class="title-group">
                    <h1>Admin Dashboard</h1>
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
            <div class="table-responsive">
            <table class="table">
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
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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

    <!-- Script Section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchProgramDonasi();
            setupEventListeners();
        });

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
                        <td>${formatDate(program.tanggal_selesai)}</td>
                        <td><span class="status ${program.status}">${capitalizeFirstLetter(program.status)}</span></td>
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
                // Jika penghapusan berhasil, lakukan refresh atau update tampilan
                alert('Program successfully deleted!');
                fetchProgramDonasi();  // Fungsi ini untuk memperbarui data program
            } else {
                alert('Failed to delete the program!');
            }
        } catch (error) {
            console.error('Error deleting program:', error);
        }
    }
}

async function editProgram(id) {
    try {
        const response = await fetch(`/api/program-donasi/${id}`);
        const program = await response.json();

        // Menampilkan data program pada form edit (misalnya menggunakan modal atau form inline)
        document.getElementById('program-name').value = program.name;
        document.getElementById('program-description').value = program.description;
        document.getElementById('edit-program-id').value = program.id;
        
        // Jika menggunakan modal untuk form edit, pastikan modal ditampilkan
        $('#editModal').modal('show');  // Jika menggunakan Bootstrap modal

    } catch (error) {
        console.error('Error fetching program details:', error);
    }
}


        // Fungsi untuk mengirimkan data yang sudah diedit ke server
        async function updateProgram() {
            const programId = document.getElementById('edit-program-id').value;
            const updatedData = {
                name: document.getElementById('program-name').value,
                description: document.getElementById('program-description').value,
                // Tambahkan properti lain yang sesuai dengan data program
            };

            try {
                const response = await fetch(`/api/program-donasi/${programId}`, {
                    method: 'PUT', // Atau PATCH tergantung preferensi
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(updatedData),
                });

                if (response.ok) {
                    const result = await response.json();
                    alert(result.message);
                    // Refresh data atau tampilkan perubahan yang sudah disimpan
                    fetchProgramDonasi(); // Asumsi fungsi ini untuk refresh data
                } else {
                    const error = await response.json();
                    alert(`Error: ${error.message}`);
                }
            } catch (error) {
                console.error('Error updating program:', error);
            }
        }

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
