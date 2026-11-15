@extends('layouts.app')

@section('content')
<style>
    .container-fluid { padding: 20px 30px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .page-title h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 0; }
    .page-title p { color: #64748b; font-size: 0.9rem; margin-top: 4px; margin-bottom: 0; }

    /* Action & Search */
    .card-header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap; }
    .search-box { position: relative; width: 100%; max-width: 320px; }
    .search-box input { width: 100%; padding: 10px 15px 10px 38px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.9rem; background: white; box-sizing: border-box; }
    .search-box input:focus { border-color: #86efac; box-shadow: 0 0 0 3px rgba(134, 239, 172, 0.3); }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

    /* Table Design */
    .table-container { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
    .table-responsive { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background-color: #f8fafc; padding: 14px 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
    td { padding: 16px 20px; font-size: 0.9rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover { background-color: #f0fdf4; }

    /* Badges */
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }
    .badge-ongoing { background-color: #e0f2fe; color: #0369a1; }
    .badge-resolved { background-color: #dcfce7; color: #15803d; }

    /* Modal Styling */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; padding: 15px; box-sizing: border-box; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 520px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0; }
    .close-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #475569; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none; box-sizing: border-box; font-family: inherit; }
    .form-group textarea { resize: vertical; min-height: 90px; }
    .btn-primary { background-color: #86efac; color: #14532d; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; }
</style>

<div class="container-fluid">
    <div class="page-header">
        <div class="page-title">
            <h1>Blotter & Incident Reports</h1>
            <p>Monitor, track, and manage resident complaints, incident reports, and official disputes.</p>
        </div>
    </div>

    <div class="table-container">
        <div class="card-header-actions" style="padding: 20px 20px 0 20px;">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search by complainant, incident, or status...">
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Blotter ID</th>
                        <th>Filed By (Complainant)</th>
                        <th>Respondent / Concern</th>
                        <th>Incident / Subject</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Date Filed</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blotters as $item)
                        <tr>
                            <td><strong>#BLT-{{ $item->id }}</strong></td>
                            <td><i class="fa-solid fa-user-tag" style="color: #16a34a; margin-right: 5px;"></i> <strong>{{ $item->complainant }}</strong></td>
                            <td>{{ $item->respondent ?? 'Barangay Office' }}</td>
                            <td>{{ $item->incident }}</td>
                            <td style="max-width: 250px; white-space: normal; color: #64748b;">{{ $item->details }}</td>
                            <td>
                                <span class="badge {{ $item->status == 'Resolved' ? 'badge-resolved' : ($item->status == 'Ongoing' ? 'badge-ongoing' : 'badge-pending') }}">
                                    {{ $item->status ?? 'Pending' }}
                                </span>
                            </td>
                            <td style="white-space: nowrap;">{{ $item->created_at->format('M d, Y') }}</td>
                            <td style="text-align: right; white-space: nowrap;">
                                <button type="button" style="border:none; background:none; color:#16a34a; cursor:pointer; margin-right: 5px;" title="Edit Status" onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->complainant) }}', '{{ addslashes($item->respondent ?? '') }}', '{{ addslashes($item->incident) }}', '{{ addslashes($item->details) }}', '{{ $item->status ?? 'Pending' }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                
                                <form action="{{ route('blotter.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border:none; background:none; color:#ef4444; cursor:pointer;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 40px;">No blotter complaints or incident reports filed yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Blotter Status</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Complainant (Filed By)</label>
                <input type="text" id="edit_complainant" name="complainant" required>
            </div>
            <div class="form-group">
                <label>Respondent</label>
                <input type="text" id="edit_respondent" name="respondent" required>
            </div>
            <div class="form-group">
                <label>Incident / Subject</label>
                <input type="text" id="edit_incident" name="incident" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="edit_status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Resolved">Resolved</option>
                </select>
            </div>
            <div class="form-group">
                <label>Incident Details / Message</label>
                <textarea id="edit_details" name="details" required></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Update Entry</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, complainant, respondent, incident, details, status) {
        document.getElementById('editForm').action = '/blotter/' + id;
        document.getElementById('edit_complainant').value = complainant;
        document.getElementById('edit_respondent').value = respondent;
        document.getElementById('edit_incident').value = incident;
        document.getElementById('edit_details').value = details;
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