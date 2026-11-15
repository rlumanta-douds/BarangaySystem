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

    /* Badges */
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-approved { background-color: #dcfce7; color: #15803d; }
    .badge-released { background-color: #e0f2fe; color: #0369a1; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }

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
            <h1>Certificate Requests</h1>
            <p>Issue, process, and manage official barangay certificates and clearances.</p>
        </div>
        <button class="btn-primary" onclick="openModal()">
            <i class="fa-solid fa-file-circle-plus"></i> Issue Certificate
        </button>
    </div>

    <div class="table-container">
        <div class="card-header-actions" style="padding: 20px 20px 0 20px;">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search by request ID, name, or type...">
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Resident Name</th>
                        <th>Certificate Type</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $cert)
                        @php
                            // Extract name cleanly across different possible column headers
                            $rawName = $cert->resident_name ?? $cert->name ?? $cert->resident ?? null;
                            $displayName = (!empty(trim($rawName))) ? $rawName : 'Resident #' . $cert->id;

                            $rawType = $cert->certificate_type ?? $cert->type ?? null;
                            $displayType = (!empty(trim($rawType))) ? $rawType : 'Barangay Clearance';
                        @endphp
                        <tr>
                            <td><strong>{{ $cert->certificate_id ?? '#CERT-' . $cert->id }}</strong></td>
                            <td>{{ $displayName }}</td>
                            <td>{{ $displayType }}</td>
                            <td>{{ $cert->purpose ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ ($cert->status ?? '') == 'Approved' ? 'badge-approved' : (($cert->status ?? '') == 'Released' ? 'badge-released' : 'badge-pending') }}">
                                    {{ $cert->status ?? 'Pending' }}
                                </span>
                            </td>
                            <td style="text-align: right; display: flex; justify-content: flex-end; gap: 5px; align-items: center;">
                                <button type="button" style="border:none; background:none; color:#16a34a; cursor:pointer;" title="Edit" onclick="openEditModal('{{ $cert->id }}', '{{ addslashes($rawName ?? '') }}', '{{ addslashes($displayType) }}', '{{ addslashes($cert->purpose ?? '') }}', '{{ $cert->status ?? 'Pending' }}')"><i class="fa-solid fa-pen-to-square"></i></button>
                                
                                <form action="{{ route('certificates.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certificate request?');" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">No certificate requests found. Click "Issue Certificate" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Issue Certificate Modal -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Issue New Certificate</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form action="{{ route('certificates.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Resident Name</label>
                <input type="text" name="resident_name" placeholder="e.g. Juan Dela Cruz" required>
            </div>
            <div class="form-group">
                <label>Certificate Type</label>
                <select name="certificate_type">
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                    <option value="Certificate of Residency">Certificate of Residency</option>
                    <option value="Business Permit Clearance">Business Permit Clearance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Purpose</label>
                <input type="text" name="purpose" placeholder="e.g. Local Employment" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Released">Released</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Save Certificate</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Certificate Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Certificate Request</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Resident Name</label>
                <input type="text" id="edit_resident_name" name="resident_name" required>
            </div>
            <div class="form-group">
                <label>Certificate Type</label>
                <select id="edit_certificate_type" name="certificate_type">
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                    <option value="Certificate of Residency">Certificate of Residency</option>
                    <option value="Business Permit Clearance">Business Permit Clearance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Purpose</label>
                <input type="text" id="edit_purpose" name="purpose" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="edit_status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Released">Released</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Update Certificate</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('addModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('addModal').style.display = 'none'; }

    function openEditModal(id, name, type, purpose, status) {
        document.getElementById('editForm').action = '/certificates/' + id;
        document.getElementById('edit_resident_name').value = name;
        document.getElementById('edit_certificate_type').value = type;
        document.getElementById('edit_purpose').value = purpose;
        document.getElementById('edit_status').value = status;
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }

    // Live Search Filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection