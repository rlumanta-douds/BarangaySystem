@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-title h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; }
    .page-title p { color: #64748b; font-size: 0.9rem; margin-top: 4px; }

    /* Action Buttons & Search Bar */
    .card-header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; }
    .search-box { position: relative; width: 320px; }
    .search-box input { width: 100%; padding: 10px 15px 10px 38px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.9rem; background: white; }
    .search-box input:focus { border-color: #86efac; box-shadow: 0 0 0 3px rgba(134, 239, 172, 0.3); }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

    /* Light Green Primary Button */
    .btn-primary { background-color: #86efac; color: #14532d; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none; transition: background 0.2s; }
    .btn-primary:hover { background-color: #4ade80; }

    /* Table Design */
    .table-container { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background-color: #f8fafc; padding: 14px 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
    td { padding: 16px 20px; font-size: 0.9rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover { background-color: #f0fdf4; }

    /* Light Green Badges */
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-active { background-color: #dcfce7; color: #15803d; }
    .badge-inactive { background-color: #fee2e2; color: #b91c1c; }
    .badge-senior { background-color: #e0f2fe; color: #0369a1; }

    /* Modal Styling */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 520px; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { font-size: 1.2rem; font-weight: 700; color: #1e293b; }
    .close-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #475569; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none; }
</style>

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
            <input type="text" placeholder="Search by name, ID, or address...">
        </div>
    </div>

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
            <!-- Sample Resident 1 -->
            <tr>
                <td><strong>#RES-1001</strong></td>
                <td>Juan Dela Cruz</td>
                <td>Purok 1, Mabini St.</td>
                <td>0917-123-4567</td>
                <td><span class="badge badge-active">Active</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Sample Resident 2 -->
            <tr>
                <td><strong>#RES-1002</strong></td>
                <td>Maria Santos</td>
                <td>Purok 3, Rizal Ave.</td>
                <td>0928-987-6543</td>
                <td><span class="badge badge-active">Active</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Sample Resident 3 -->
            <tr>
                <td><strong>#RES-1003</strong></td>
                <td>Pedro Penduko</td>
                <td>Purok 2, Luna St.</td>
                <td>0908-555-1234</td>
                <td><span class="badge badge-senior">Senior Citizen</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Sample Resident 4 -->
            <tr>
                <td><strong>#RES-1004</strong></td>
                <td>Ana Reyes</td>
                <td>Purok 4, Sampaguita St.</td>
                <td>0919-444-8899</td>
                <td><span class="badge badge-active">Active</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Add Resident Modal -->
<div class="modal" id="addResidentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Register New Resident</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form action="#" method="POST">
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

<script>
    function openModal() {
        document.getElementById('addResidentModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('addResidentModal').style.display = 'none';
    }
</script>
@endsection