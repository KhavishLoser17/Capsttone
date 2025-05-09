@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="grid grid-cols-6 col-span-6 rounded-md gap-4">
    <div class="col-span-12 shadow-md bg-white rounded-lg">
        <div class="flex flex-row gap-4 items-center justify-between py-4 px-6 border-b border-gray-200">
            <h2 class="text-md font-semibold">Training Management</h2>
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" onclick="document.getElementById('addModalTMS').classList.remove('hidden')">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>
        <div class="p-4">
            <table id="learningManagementTable" class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 border">ID</th>
                        <th class="px-4 py-3 border">Title</th>
                        <th class="px-4 py-3 border">Location</th>
                        <th class="px-4 py-3 border">Instructor</th>
                        <th class="px-4 py-3 border">Department</th>
                        <th class="px-4 py-3 border">Goals & Objective</th>
                        <th class="px-4 py-3 border">Date & Time</th>
                        <th class="px-4 py-3 border">Due Date</th>
                        <th class="px-4 py-3 border">Estimated Budget</th>
                        <th class="px-4 py-3 border">Video</th>
                        <th class="px-4 py-3 border w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($list as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center border">{{ $item->id }}</td>
                            <td class="px-4 py-3 border">{{ $item->title }}</td>
                            <td class="px-4 py-3 border">{{ $item->location }}</td>
                            <td class="px-4 py-3 border">{{ $item->instructor }}</td>
                            <td class="px-4 py-3 border">{{ $item->department }}</td>
                            <td class="px-4 py-3 border">{{ $item->description }}</td>
                            <td class="px-4 py-3 border">{{ $item->date_time }}</td>
                            <td class="px-4 py-3 border">{{ $item->created_at }}</td>
                            <td class="px-4 py-3 border">₱{{ number_format($item->estimated_budget, 2) }}</td>

                            <td class="px-4 py-3 border">
                                @if($item->video_path)
                                    <video width="120" height="90" controls>
                                        <source src="{{ asset('storage/' . $item->video_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    No Video Available
                                @endif
                            </td>

                            <td class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    <button type="button" onclick="editItem({{ $item->id }})"
                                        class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button type="button" onclick="deleteItem({{ $item->id }})"
                                        class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700 transition">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Add pagination links --}}

        </div>
    </div>
</div>


{{-- ADD TMS MODAL --}}

<div id="addModalTMS" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-4xl mx-auto overflow-hidden">
      <div class="flex justify-between items-center px-4 py-2 bg-gray-100">
        <h5 class="text-lg font-semibold">Add TMS</h5>
        <button class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('addModalTMS').classList.add('hidden')">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="p-6">
        <form action="{{ route('register-video-api') }}" method="POST" id="videoForm" enctype="multipart/form-data">
            @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="mb-4">
              <label class="block text-gray-700">Title</label>
              <input type="text" id="addTitle" name="vidTitle" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <!-- Description -->
            <div class="mb-4">
              <label class="block text-gray-700">Goals and Objective</label>
              <textarea id="addDescription" name="vidDesc" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"></textarea>
            </div>
            <!-- Instructor -->
            <div class="mb-4">
              <label class="block text-gray-700">Instructor</label>
              <input type="text" id="addInstructor" name="vidIns" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <!-- Department -->
            <div class="mb-4">
                <label class="block text-gray-700">Department</label>
                <select id="addDepartment" name="vidDep" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">Select Department</option>
                    <option value="Human Resource">Human Resource</option>
                    <option value="Finance">Finance</option>
                    <option value="Logistic">Logistic</option>
                    <option value="Core">Core</option>
                    <option value="Administrative">Administrative</option>
                    <option value="All Department">All Department</option>
                </select>
            </div>
            
            <!-- Location -->
            <div class="mb-4">
              <label class="block text-gray-700">Location</label>
              <input type="text" id="addLocation" name="vidLoc" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Date&Time</label>
                <input type="datetime-local" id="addDate" name="vidDate" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
              </div>
            <!-- Estimated Budget -->
            <div class="mb-4">
                <label class="block text-gray-700">Estimated Budget</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.656 0-3 1.344-3 3s1.344 3 3 3 3-1.344 3-3-1.344-3-3-3z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z"></path>
                        </svg>
                    </span>
                    <input type="number" id="addBudget" name="vidBud" placeholder="Enter estimated budget" class="w-full px-3 py-2 pl-10 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" oninput="formatCurrency(this)">
                </div>
            </div>
            <!-- Video -->
            <div class="mb-4 md:col-span-2">
              <label class="block text-gray-700">Video</label>
              <input type="file" id="addVideo" name="video" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
          </div>
          <div class="flex justify-end mt-4">
            <button type="button" id="closeAddModal" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  {{-- EDIT MODAL --}}
  <div id="editModalTMS" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-4xl mx-auto overflow-hidden">
        <div class="flex justify-between items-center px-4 py-2 bg-gray-100">
            <h5 class="text-lg font-semibold">Edit TMS</h5>
            <button onclick="document.getElementById('editModalTMS').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <form id="editForm" action="" method="POST" enctype="multipart/form-data" onsubmit="confirmUpdate(event)">
                @csrf
                @method('PUT')
                <!-- Grid container -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Title</label>
                        <input type="text" id="vidTitle" name="vidTitle" required class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700">Instructor</label>
                        <input type="text" id="vidIns" name="vidIns" required class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700">Description</label>
                        <textarea id="vidDesc" name="vidDesc" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700">Department</label>
                        <select id="vidDep" name="vidDep" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">Select Department</option>
                            <option value="Human Resource">Human Resource</option>
                            <option value="Finance">Finance</option>
                            <option value="Logistic">Logistic</option>
                            <option value="Core">Core</option>
                            <option value="Administrative">Administrative</option>
                            <option value="All Department">All Department</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700">Location</label>
                        <input type="text" id="vidLoc" name="vidLoc" required class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700">Date & Time</label>
                        <input type="datetime-local" id="vidDate" name="vidDate" required class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700">Estimated Budget</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.656 0-3 1.344-3 3s1.344 3 3 3 3-1.344 3-3-1.344-3-3-3z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z"></path>
                                </svg>
                            </span>
                            <input type="number" id="vidBud" name="vidBud" placeholder="Enter estimated budget" class="w-full px-3 py-2 pl-10 border rounded-lg">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700">Video</label>
                        <p id="video" class="text-sm text-gray-500">No video uploaded</p>
                        <input type="file" name="video" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="document.getElementById('editModalTMS').classList.add('hidden')" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoForm = document.getElementById("videoForm");

        if (videoForm) {
            videoForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent default form submission

                // Use SweetAlert2 for confirmation
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to add a new Seminar Presentation.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, add it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData(this);

                        fetch("{{ route('register-video-api') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => {
                            // Always try to parse as JSON
                            return response.json().then(data => {
                                if (!response.ok) {
                                    throw new Error(data.message || 'Something went wrong');
                                }
                                return data;
                            });
                        })
                        .then(data => {
                            // Success case
                            if (data.success) {
                                Swal.fire({
                                    title: "Success!",
                                    text: data.message || "Seminar Presentation added successfully!",
                                    icon: "success"
                                }).then(() => {
                                    // Optional: Reload page or update UI
                                    window.location.reload();
                                });
                            } else {
                                // Handle case where success is false
                                Swal.fire({
                                    title: "Error!",
                                    text: data.message || "Failed to add Seminar Presentation",
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            // Error handling
                            console.error('Error:', error);
                            Swal.fire({
                                title: "Error!",
                                text: error.message || "An unexpected error occurred",
                                icon: "error"
                            });
                        });
                    }
                });
            });
        }

        window.formatCurrency = function(input) {
        let value = input.value.replace(/[^\d.]/g, '');
        let parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        input.value = value;
    };
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function editItem(itemId) {
        // Show the edit modal
        const editModal = document.getElementById('editModalTMS');
        editModal.classList.remove('hidden');

        // Fetch the item details via AJAX
        fetch(`/training/${itemId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch item details');
                }
                return response.json();
            })
            .then(item => {
                // Populate the form fields with the fetched item details
                document.getElementById('vidTitle').value = item.title;
                document.getElementById('vidIns').value = item.instructor;
                document.getElementById('vidDesc').value = item.description;
                document.getElementById('vidDep').value = item.department;
                document.getElementById('vidLoc').value = item.location;

                // Safe date formatting
                let formattedDate = '';
                try {
                    // Try parsing the date
                    const dateObj = new Date(item.date_time);

                    // Check if date is valid
                    if (!isNaN(dateObj.getTime())) {
                        // Format to datetime-local input requirement
                        const year = dateObj.getFullYear();
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const hours = String(dateObj.getHours()).padStart(2, '0');
                        const minutes = String(dateObj.getMinutes()).padStart(2, '0');

                        formattedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
                    } else {
                        throw new Error('Invalid date');
                    }
                } catch (error) {
                    console.error('Date formatting error:', error);
                    formattedDate = ''; // Reset to empty if can't format
                }

                document.getElementById('vidDate').value = formattedDate;
                document.getElementById('vidBud').value = item.estimated_budget;

                // Update video information
                const videoElement = document.getElementById('video');
                videoElement.textContent = item.video_path ? item.video_path.split('/').pop() : 'No video uploaded';

                // Update form action to include the specific item ID
                const editForm = document.getElementById('editForm');
                editForm.action = `/training/${itemId}`;
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to load item details!',
                    confirmButtonColor: '#3085d6'
                });
            });
    }

    function confirmUpdate(event) {
        event.preventDefault();

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update this Seminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = event.target;

                // Create FormData object
                const formData = new FormData(form);

                // Send AJAX request
                fetch(form.action, {
                    method: 'POST', // Use POST method with @method('PUT') for Laravel
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Update failed');
                    }
                    return response.json();
                })
                .then(data => {
                    // Close modal
                    document.getElementById('editModalTMS').classList.add('hidden');

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Your seminar has been updated successfully.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        // Refresh the page or update the table
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to update the training item!',
                        confirmButtonColor: '#3085d6'
                    });
                });
            }
        });
    }
    </script>
    <script>
        function deleteItem(itemId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this seminar? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/training/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
        
                        const data = await response.json();
        
                        if (!response.ok) {
                            throw new Error(data.message || 'Delete failed');
                        }
        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Seminar deleted successfully.',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            // Optionally, refresh or update the UI
                            location.reload();
                        });
        
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message || 'Failed to delete the seminar!',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                }
            });
        }
        </script>
        

@endsection
