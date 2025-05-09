@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection
@section('content')
<div class="grid grid-cols-6 col-span-6 rounded-md gap-4" >
    <div class="col-span-12 shadow-md bg-white rounded-lg">
        <div class="flex flex-row gap-4 items-center justify-between py-4 px-6 border-b border-gray-200">
            <h2 class="text-md font-semibold">Learning Management</h2>
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" onclick="document.getElementById('addModalLMS').classList.remove('hidden')">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto w-full">
                <table id="learningManagementTable" class="w-full border-collapse border border-gray-200 shadow-md rounded-lg">
                    <thead class="sticky top-0 bg-gray-100 z-10">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Instructor</th>
                            <th class="px-4 py-2 border">Department</th>
                            <th class="px-4 py-2 border">Goals & Objective</th>
                            <th class="px-4 py-2 border">Date & Time</th>
                            <th class="px-4 py-2 border">Due Date</th>
                            <th class="px-4 py-2 border">Estimated Budget</th>
                            <th class="px-4 py-2 border">Image</th>
                            <th class="px-4 py-2 border w-12">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($list as $item)
                        <tr id="row-{{ $item->id }}" class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-2 border">{{ $item->id }}</td>
                            <td class="px-4 py-2 border">{{ $item->title }}</td>
                            <td class="px-4 py-2 border">{{ $item->instructor }}</td>
                            <td class="px-4 py-2 border">{{ $item->department }}</td>
                            <td class="px-4 py-2 border">{{ $item->goals }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->dueDate)->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 border">₱{{ number_format($item->budget, 2) }}</td>
                            <td class="px-4 py-2 border">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="Training Image" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <span>No Image</span>
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
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">No training sessions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Add pagination links --}}
            <div class="mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>
  </div>

  {{-- ADD LMS MODAL --}}

  <div id="addModalLMS" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" style="z-index: 9999;">
      <div class="bg-white rounded-lg w-full max-w-4xl mx-auto overflow-hidden">
        <div class="flex justify-between items-center px-4 py-2 bg-gray-100 border-b">
          <h5 class="text-lg font-semibold">Add LMS</h5>
          <button class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('addModalLMS').classList.add('hidden')">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div class="p-6">
          <form action="{{ route('add-learning') }}" id="trainingForm" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <!-- Title -->
                  <div class="mb-4">
                      <label for="addTitle" class="block text-gray-700">Title</label>
                      <input type="text" name="title" id="addTitle" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                  </div>
                  <!-- Description -->
                  <div class="mb-4">
                      <label for="addDescription" class="block text-gray-700">Description</label>
                      <textarea name="description" id="addDescription" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required></textarea>
                  </div>
                  <!-- Instructor -->
                  <div class="mb-4">
                      <label for="addInstructor" class="block text-gray-700">Instructor</label>
                      <input type="text" name="instructor" id="addInstructor" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                  </div>
                  <!-- Department -->
                  <div class="mb-4">
                    <label for="addDepartment" class="block text-gray-700">Department</label>
                    <select name="department" id="addDepartment" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                        <option value="">Select Department</option>
                        <option value="Human Resource">Human Resource</option>
                        <option value="Finance">Finance</option>
                        <option value="Logistic">Logistic</option>
                        <option value="Core">Core</option>
                        <option value="Administrative">Administrative</option>
                        <option value="All Department">All Department</option>
                    </select>
                </div>                
                  <!-- Goals -->
                  <div class="mb-4">
                      <label for="addGoals" class="block text-gray-700">Goals & Objective</label>
                      <input type="text" name="goals" id="addGoals" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                  </div>
                  <!-- Date -->
                  <div>
                      <label for="addDate" class="block text-gray-700">Date & Time</label>
                      <input type="datetime-local" name="date" id="addDate" class="w-full px-3 py-2 border rounded-lg" required>
                  </div>
                  <!-- Due Date -->
                  <div>
                      <label for="addDue" class="block text-gray-700">Due Date</label>
                      <input type="datetime-local" name="dueDate" id="addDue" class="w-full px-3 py-2 border rounded-lg" required>
                  </div>
                  <!-- Budget -->
                  <div>
                      <label for="addBudget" class="block text-gray-700">Estimated Budget</label>
                      <input type="number" name="budget" id="addBudget" placeholder="Enter estimated budget" class="w-full px-3 py-2 border rounded-lg" required>
                  </div>
                  <!-- File -->
                  <div class="mb-4 sm:col-span-2">
                      <label for="addVideo" class="block text-gray-700">File</label>
                      <input type="file" name="image" id="addVideo" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                  </div>
              </div>
              <!-- Buttons -->
              <div class="flex justify-center mt-6 space-x-4">
                  <button type="button" id="closeAddModal" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                      Cancel
                  </button>
                  <button type="submit" class="px-10 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                      Add
                  </button>
              </div>
          </form>
        </div>
      </div>
    </div>



  {{-- Edit Lms MODAL --}}

  <div id="editModalLms" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
      <div class="bg-white rounded-lg w-full max-w-4xl mx-auto overflow-hidden">
          <div class="flex justify-between items-center px-4 py-2 bg-gray-100">
              <h5 class="text-lg font-semibold">Edit LMS</h5>
              <button class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('editModalLms').classList.add('hidden')">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
              </button>
          </div>
          <div class="p-4">
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                  @method('PUT')
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <!-- Left Column -->
                      <div class="mb-4">
                          <label class="block text-gray-700">Title</label>
                          <input type="text" id="editTitle" name="Title" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                      </div>
                      <div class="mb-4">
                          <label class="block text-gray-700">Description</label>
                          <textarea id="editDescription" name="Description" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"></textarea>
                      </div>
                      <div class="mb-4">
                          <label class="block text-gray-700">Instructor</label>
                          <input type="text" id="editInstructor" name="Instructor" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                      </div>
                      <div class="mb-4">
                        <label class="block text-gray-700">Department</label>
                        <select id="editDepartment" name="Department" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">Select Department</option>
                            <option value="Human Resource">Human Resource</option>
                            <option value="Finance">Finance</option>
                            <option value="Logistic">Logistic</option>
                            <option value="Core">Core</option>
                            <option value="Administrative">Administrative</option>
                            <option value="All Department">All Department</option>
                        </select>
                    </div>                    
                      <div class="mb-4">
                          <label for="editGoals" class="block text-gray-700">Goals & Objective</label>
                          <input type="text" name="goals" id="editGoals" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                      </div>

                      <!-- Right Column -->
                      <div class="mb-4">
                          <label for="editDate" class="block text-gray-700">Date & Time</label>
                          <input type="datetime-local" name="date" id="editDate" class="w-full px-3 py-2 border rounded-lg" required>
                      </div>
                      <div class="mb-4">
                          <label for="editDue" class="block text-gray-700">Due Date</label>
                          <input type="datetime-local" name="dueDate" id="editDue" class="w-full px-3 py-2 border rounded-lg" required>
                      </div>
                      <div class="mb-4">
                          <label for="editBudget" class="block text-gray-700">Estimated Budget</label>
                          <input type="number" name="budget" id="editBudget" placeholder="Enter estimated budget" class="w-full px-3 py-2 border rounded-lg" required>
                      </div>
                      <div class="mb-4">
                          <label class="block text-gray-700">Image</label>
                          <input type="file" id="editImage" name="image" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                      </div>
                  </div>
                  <div class="flex justify-end mt-4">
                      <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" onclick="document.getElementById('editModalLms').classList.add('hidden')">Cancel</button>
                      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update</button>
                  </div>
              </form>
          </div>
      </div>
  </div>


      {{-- For Adding LMS --}}
      <script>
       document.addEventListener('DOMContentLoaded', function() {
    const trainingForm = document.getElementById("trainingForm");
    const submitButton = trainingForm.querySelector('button[type="submit"]');
    const addModal = document.getElementById('addModalLMS');

    trainingForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Disable the submit button to prevent multiple submissions
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');

        let formData = new FormData(this);

        fetch("{{ route('add-learning') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                // First, hide the modal immediately
                if (addModal) {
                    addModal.classList.add('hidden');
                }

                // Then show success SweetAlert
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Training Session Created Successfully",
                    confirmButtonText: "OK"
                }).then(() => {
                    // Reload the page after confirmation
                    window.location.reload();
                });
            } else {
                // Re-enable the submit button
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.message || "Something went wrong!",
                });
            }
        })
        .catch(error => {
            // Re-enable the submit button
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');

            // Ensure modal is visible if there's an error
            if (addModal) {
                addModal.classList.remove('hidden');
            }

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "An error occurred. Please try again.",
            });
            console.error("Error:", error);
        });
    });

    // Close modal button functionality
    const closeAddModalBtn = document.getElementById('closeAddModal');
    if (closeAddModalBtn) {
        closeAddModalBtn.addEventListener('click', function() {
            if (addModal) {
                addModal.classList.add('hidden');
            }
        });
    }
});
        </script>

      {{-- FOR EDIT LMS --}}
      <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdown = event.currentTarget.nextElementSibling;

            // Close any other open dropdowns
            document.querySelectorAll('.dropdownAction').forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.add('hidden');
                }
            });

            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdownAction').forEach(dd => {
                dd.classList.add('hidden');
            });
        });

       // Updated JavaScript Functions
       function editItem(id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/learning/${id}/edit`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(errorBody => {
                console.error('Error Response:', response.status, errorBody);
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.status) {
            // Populate form fields
            document.getElementById('editTitle').value = data.data.title || '';
            document.getElementById('editDescription').value = data.data.description || '';
            document.getElementById('editInstructor').value = data.data.instructor || '';
            document.getElementById('editDepartment').value = data.data.department || '';
            document.getElementById('editGoals').value = data.data.goals || '';
            document.getElementById('editDate').value = data.data.date || '';
            document.getElementById('editDue').value = data.data.dueDate || '';
            document.getElementById('editBudget').value = data.data.budget || '';

            // Show edit modal
            const editModal = document.getElementById('editModalLms');
            if (editModal) {
                editModal.classList.remove('hidden');
            }
        } else {
            throw new Error(data.message || 'Failed to fetch training data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'An error occurred while fetching training data'
        });
    });
}

function deleteItem(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/learning/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(errorBody => {
                        console.error('Error Response:', response.status, errorBody);
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.status) {
                    Swal.fire(
                        'Deleted!',
                        'The training has been deleted.',
                        'success'
                    ).then(() => {
                        // Remove the specific row from the table
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            row.remove();
                        } else {
                            // Fallback to reload if row not found
                            window.location.reload();
                        }
                    });
                } else {
                    throw new Error(data.message || 'Failed to delete training');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'An error occurred while deleting the training'
                });
            });
        }
    });
}
          </script>

@endsection
