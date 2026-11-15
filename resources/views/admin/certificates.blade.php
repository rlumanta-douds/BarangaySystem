@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-title h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; }
    .page-title p { color: #64748b; font-size: 0.9rem; margin-top: 4px; }

    /* Action & Search */
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

    /* Light Green & Status Badges */
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-approved { background-color: #dcfce7; color: #15803d; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }
    .badge-released { background-color: #e0f2fe; color: #0369a1; }

    /* Empty State */
    .empty-state { text-align: center; padding: 50px 20px; color: #64748b; }
    .empty-state i { font-size: 2.5rem; color: #86efac; margin-bottom: 10px; }

    /* Modal */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 500px; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { font-size: 1.2rem; font-weight: 700; color: #1e293b; }
    .close-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #475569; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none; }
</style>

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
            <input type="text" placeholder="Search by requestor or document...">
        </div>
    </div>

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
            <!-- Sample Request 1 -->
            <tr>
                <td><strong>#CERT-1001</strong></td>
                <td>Juan Dela Cruz</td>
                <td>Barangay Clearance</td>
                <td>Local Employment</td>
                <td><span class="badge badge-approved">Approved</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Print"><i class="fa-solid fa-print"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Sample Request 2 -->
            <tr>
                <td><strong>#CERT-1002</strong></td>
                <td>Maria Santos</td>
                <td>Certificate of Indigency</td>
                <td>Medical Assistance</td>
                <td><span class="badge badge-released">Released</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Print"><i class="fa-solid fa-print"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Sample Request 3 -->
            <tr>
                <td><strong>#CERT-1003</strong></td>
                <td>Pedro Penduko</td>
                <td>Certificate of Residency</td>
                <td>Bank Requirement</td>
                <td><span class="badge badge-pending">Pending</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Print"><i class="fa-solid fa-print"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Sample Request 4 -->
            <tr>
                <td><strong>#CERT-1004</strong></td>
                <td>Ana Reyes</td>
                <td>Business Permit Clearance</td>
                <td>Sari-Sari Store Operation</td>
                <td><span class="badge badge-approved">Approved</span></td>
                <td style="text-align: right;">
                    <button style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right:10px;" title="Print"><i class="fa-solid fa-print"></i></button>
                    <button style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Issue Certificate Modal -->
<div class="modal" id="certificateModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Issue New Certificate</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label>Resident Full Name</label>
                <input type="text" name="resident_name" placeholder="e.g. Maria Santos" required>
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
                <input type="text" name="purpose" placeholder="e.g. Employment / Scholarship / ID Application" required>
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
                <button type="submit" class="btn-primary">Generate Request</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('certificateModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('certificateModal').style.display = 'none';
    }
</script>
@endsection