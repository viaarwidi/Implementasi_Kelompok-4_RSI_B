// // adminDashboard.js

// document.addEventListener('DOMContentLoaded', () => {
//     // Load initial data
//     fetchProgramDonasi();

//     // Setup event listeners for filtering, search, etc.
//     setupEventListeners();
// });

// /**
//  * Fetch all program donations and update the table.
//  */
// async function fetchProgramDonasi() {
//     try {
//         const response = await fetch('/api/program-donasi');
//         const data = await response.json();

//         updateTable(data);
//         updateProjectCount(data.length);
//     } catch (error) {
//         console.error('Error fetching data:', error);
//     }
// }

// /**
//  * Update the table with data from the API.
//  * @param {Array} data - Array of program donations.
//  */
// function updateTable(data) {
//     const tbody = document.querySelector('#eventTable tbody');
//     tbody.innerHTML = '';

//     data.forEach(program => {
//         const row = `
//             <tr data-status="${program.status}">
//                 <td>
//                     <div class="admin-avatar">${program.id_admin || 'N/A'}</div>
//                 </td>
//                 <td>${program.nama_program}</td>
//                 <td>${formatDate(program.tanggal_selesai)}</td>
//                 <td><span class="status ${program.status}">${capitalizeFirstLetter(program.status)}</span></td>
//                 <td class="actions">
//                     <button class="btn-action" onclick="editProgram(${program.id})">
//                         <i class="far fa-edit"></i>
//                     </button>
//                     <button class="btn-action" onclick="deleteProgram(${program.id})">
//                         <i class="far fa-trash-alt"></i>
//                     </button>
//                 </td>
//             </tr>
//         `;
//         tbody.insertAdjacentHTML('beforeend', row);
//     });
// }

// /**
//  * Delete a program by ID.
//  * @param {number} id - The ID of the program to delete.
//  */
// async function deleteProgram(id) {
//     if (confirm('Are you sure you want to delete this program?')) {
//         try {
//             const response = await fetch(`/api/program-donasi/${id}`, {
//                 method: 'DELETE',
//             });

//             if (response.ok) {
//                 fetchProgramDonasi();
//             } else {
//                 console.error('Error deleting program:', response.statusText);
//             }
//         } catch (error) {
//             console.error('Error deleting program:', error);
//         }
//     }
// }

// /**
//  * Edit a program by fetching its details.
//  * @param {number} id - The ID of the program to edit.
//  */
// async function editProgram(id) {
//     try {
//         const response = await fetch(`/api/program-donasi/${id}`);
//         const program = await response.json();

//         // Implement your edit form logic here (e.g., show a modal with a form pre-filled with the program details)
//         console.log('Program to edit:', program);
//     } catch (error) {
//         console.error('Error fetching program details:', error);
//     }
// }

// /**
//  * Format a date string into a more readable format.
//  * @param {string} dateString - The date string to format.
//  * @returns {string} - Formatted date.
//  */
// function formatDate(dateString) {
//     const date = new Date(dateString);
//     return date.toLocaleDateString('id-ID', {
//         day: 'numeric',
//         month: 'short',
//         year: 'numeric',
//     });
// }

// /**
//  * Capitalize the first letter of a string.
//  * @param {string} string - The string to capitalize.
//  * @returns {string} - The capitalized string.
//  */
// function capitalizeFirstLetter(string) {
//     return string.charAt(0).toUpperCase() + string.slice(1);
// }

// /**
//  * Update the project count display.
//  * @param {number} count - The number of projects.
//  */
// function updateProjectCount(count) {
//     document.querySelector('.project-count').textContent = `${count} project`;
// }

// /**
//  * Setup event listeners for filtering and searching.
//  */
// function setupEventListeners() {
//     // Filter buttons
//     document.querySelectorAll('.btn-view').forEach(button => {
//         button.addEventListener('click', async () => {
//             const filter = button.dataset.filter;

//             // Update active button
//             document.querySelectorAll('.btn-view').forEach(btn => btn.classList.remove('active'));
//             button.classList.add('active');

//             // Fetch and filter data
//             const response = await fetch('/api/program-donasi');
//             const data = await response.json();

//             if (filter === 'all') {
//                 updateTable(data);
//             } else {
//                 const filteredData = data.filter(program => program.status === filter);
//                 updateTable(filteredData);
//             }
//         });
//     });

//     // Search functionality
//     const searchInput = document.querySelector('.search-box input');
//     searchInput.addEventListener('input', async (e) => {
//         const searchTerm = e.target.value.toLowerCase();

//         const response = await fetch('/api/program-donasi');
//         const data = await response.json();

//         const filteredData = data.filter(program => 
//             program.nama_program.toLowerCase().includes(searchTerm) ||
//             program.id_admin?.toLowerCase().includes(searchTerm)
//         );

//         updateTable(filteredData);
//     });
// }
