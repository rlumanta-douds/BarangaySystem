@extends('layouts.app')

@section('content')
<style>
    .container-fluid { padding: 20px 30px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .page-title h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 0; }
    .page-title p { color: #64748b; font-size: 0.9rem; margin-top: 4px; margin-bottom: 0; }

    /* Action Buttons & Search Bar */
    .card-header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap; }
    .search-box { position: relative; width: 100%; max-width: 320px; }
    .search-box input { width: 100%; padding: 10px 15px 10px 38px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.9rem; background: white; box-sizing: border-box; }
    .search-box input:focus { border-color: #86efac; box-shadow: 0 0 0 3px rgba(134, 239, 172, 0.3); }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

    /* Light Green Primary Button */
    .btn-primary { background-color: #86efac; color: #14532d; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: background 0.2s; white-space: nowrap; }
    .btn-primary:hover { background-color: #4ade80; }

    /* Table Design */
    .table-container { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
    .table-responsive { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background-color: #f8fafc; padding: 14px 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
    td { padding: 16px 20px; font-size: 0.9rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; white-space: nowrap; }
    tr:last-child td { border-bottom: none; }
    tr:hover { background-color: #f0fdf4; }

    /* Light Green Badges */
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-active { background-color: #dcfce7; color: #15803d; }
    .badge-inactive { background-color: #fee2e2; color: #b91c1c; }
    .badge-senior { background-color: #e0f2fe; color: #0369a1; }

    /* Modal Styling */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; padding: 15px; box-sizing: border-box; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 520px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0; }
    .close-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #475569; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none; box-sizing: border-box; }
</style>

<div class="container-fluid">
    <div class="page-header">
        <div class="page-title">
            <h1>Resident Records</h1>
            <p>Manage registered barangay residents, update information, and track records.</p>
        </div>
        <button class="btn-primary" onclick="openModal()">
            <i class="fa-solid fa-user-plus"></i> Add Resident
        </button>
    </div>

    <div class="table-container">
        <div class="card-header-actions" style="padding: 20px 20px 0 20px;">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search by name, ID, or address...">
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Resident ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Contact No.</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                        <tr>
                            <td><strong>{{ $resident->resident_id ?? '#RES-' . $resident->id }}</strong></td>
                            <td>{{ $resident->name }}</td>
                            <td>{{ $resident->address }}</td>
                            <td>{{ $resident->contact }}</td>
                            <td>
                                <span class="badge {{ $resident->status == 'Senior Citizen' ? 'badge-senior' : 'badge-active' }}">
                                    {{ $resident->status }}
                                </span>
                            </td>
                            <td style="text-align: right; display: flex; justify-content: flex-end; gap: 5px; align-items: center;">
                                <!-- Edit Button triggers edit modal -->
                                <button type="button" style="border:none; background:none; color:#16a34a; cursor:pointer;" title="Edit" onclick="openEditModal('{{ $resident->id }}', '{{ addslashes($resident->name) }}', '{{ addslashes($resident->address) }}', '{{ addslashes($resident->contact) }}', '{{ $resident->status }}')"><i class="fa-solid fa-pen-to-square"></i></button>
                                
                                <!-- Delete Form -->
                                <form action="{{ route('residents.destroy', $resident->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resident?');" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">No resident records found. Click "Add Resident" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Resident Modal -->
<div class="modal" id="addResidentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Register New Resident</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form action="{{ route('residents.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="e.g. Juan Dela Cruz" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group">
                    <label>Address / Zone</label>
                    <input type="text" name="address" placeholder="e.g. Purok 1, Mabini St." required>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact" placeholder="e.g. 0917-000-0000" required>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Active">Active Resident</option>
                    <option value="Senior Citizen">Senior Citizen</option>
                    <option value="PWD">PWD</option>
                    <option value="Inactive">Inactive / Transferred</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Save Resident</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Resident Modal -->
<div class="modal" id="editResidentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Resident Information</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editResidentForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" id="edit_name" name="name" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group">
                    <label>Address / Zone</label>
                    <input type="text" id="edit_address" name="address" required>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" id="edit_contact" name="contact" required>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="edit_status" name="status">
                    <option value="Active">Active Resident</option>
                    <option value="Senior Citizen">Senior Citizen</option>
                    <option value="PWD">PWD</option>
                    <option value="Inactive">Inactive / Transferred</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Update Resident</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addResidentModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('addResidentModal').style.display = 'none';
    }

    function openEditModal(id, name, address, contact, status) {
        document.getElementById('editResidentForm').action = '/residents/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_address').value = address;
        document.getElementById('edit_contact').value = contact;
        document.getElementById('edit_status').value = status;
        document.getElementById('editResidentModal').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('editResidentModal').style.display = 'none';
    }

    // Live Search Filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
                row.style.title = '';
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection