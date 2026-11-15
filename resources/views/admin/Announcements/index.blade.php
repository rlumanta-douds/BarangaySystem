@extends('layouts.app')

@section('content')
<style>
    .container-fluid { padding: 20px 30px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .page-title h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 0; }
    .page-title p { color: #64748b; font-size: 0.9rem; margin-top: 4px; margin-bottom: 0; }

    /* Search & Action */
    .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; flex-wrap: wrap; }
    .search-box { position: relative; width: 100%; max-width: 350px; }
    .search-box input { width: 100%; padding: 10px 15px 10px 38px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.9rem; background: white; box-sizing: border-box; }
    .search-box input:focus { border-color: #86efac; box-shadow: 0 0 0 3px rgba(134, 239, 172, 0.3); }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

    .btn-primary { background-color: #86efac; color: #14532d; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: background 0.2s; white-space: nowrap; }
    .btn-primary:hover { background-color: #4ade80; }

    /* Grid layout for announcements */
    .announcements-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
    .announcement-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; }
    .card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-urgent { background-color: #fee2e2; color: #991b1b; }
    .badge-event { background-color: #fef3c7; color: #b45309; }
    .badge-general { background-color: #dcfce7; color: #15803d; }
    .badge-financial { background-color: #e0f2fe; color: #0369a1; }

    .time-text { font-size: 0.8rem; color: #94a3b8; display: flex; align-items: center; gap: 4px; }
    .announcement-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    .announcement-content { font-size: 0.9rem; color: #475569; line-height: 1.5; margin-bottom: 20px; flex-grow: 1; }
    
    .card-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 12px; font-size: 0.85rem; color: #64748b; }
    .card-actions { display: flex; gap: 8px; }
    .card-actions button, .card-actions form button { background: none; border: none; cursor: pointer; font-size: 0.9rem; }
    .btn-edit { color: #16a34a; }
    .btn-delete { color: #ef4444; }

    /* Modal Styling */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; padding: 15px; box-sizing: border-box; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 520px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0; }
    .close-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #475569; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none; box-sizing: border-box; font-family: inherit; }
    .form-group textarea { resize: vertical; min-height: 100px; }
</style>

<div class="container-fluid">
    <div class="page-header">
        <div class="page-title">
            <h1>Barangay Announcements</h1>
            <p>Post and manage public notices, events, and emergency alerts for residents.</p>
        </div>
        <button class="btn-primary" onclick="openModal()">
            <i class="fa-solid fa-plus"></i> Create Announcement
        </button>
    </div>

    <div class="action-bar">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Search announcements...">
        </div>
    </div>

    <div class="announcements-grid" id="announcementsContainer">
        @forelse($announcements as $item)
            @php
                $badgeClass = 'badge-general';
                if(strtolower($item->category) == 'urgent advisory') $badgeClass = 'badge-urgent';
                elseif(strtolower($item->category) == 'community event') $badgeClass = 'badge-event';
                elseif(strtolower($item->category) == 'financial assistance') $badgeClass = 'badge-financial';
            @endphp
            <div class="announcement-card" data-search="{{ strtolower($item->title . ' ' . $item->content . ' ' . $item->category) }}">
                <div>
                    <div class="card-top">
                        <span class="badge {{ $badgeClass }}">{{ $item->category }}</span>
                        <span class="time-text"><i class="fa-regular fa-clock"></i> {{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="announcement-title">{{ $item->title }}</div>
                    <div class="announcement-content">{{ $item->content }}</div>
                </div>
                <div class="card-footer">
                    <span><i class="fa-solid fa-user-gear"></i> Posted by {{ $item->posted_by }}</span>
                    <div class="card-actions">
                        <button type="button" class="btn-edit" title="Edit" onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->content) }}', '{{ addslashes($item->category) }}', '{{ addslashes($item->posted_by) }}')"><i class="fa-solid fa-pen-to-square"></i></button>
                        
                        <form action="{{ route('announcements.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');" style="display:inline; margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 40px; background: white; border-radius: 12px; border: 1px solid #e2e8f0;">
                No announcements found. Click "Create Announcement" to post your first notice.
            </div>
        @endforelse
    </div>
</div>

<!-- Create Modal -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Create Announcement</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" placeholder="e.g. Scheduled Power Interruption" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="General Notice">General Notice</option>
                    <option value="Urgent Advisory">Urgent Advisory</option>
                    <option value="Community Event">Community Event</option>
                    <option value="Financial Assistance">Financial Assistance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Posted By (Committee / Role)</label>
                <input type="text" name="posted_by" value="Admin" placeholder="e.g. Health Committee">
            </div>
            <div class="form-group">
                <label>Content / Details</label>
                <textarea name="content" placeholder="Write full details here..." required></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Post Announcement</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Announcement</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="edit_title" name="title" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select id="edit_category" name="category">
                    <option value="General Notice">General Notice</option>
                    <option value="Urgent Advisory">Urgent Advisory</option>
                    <option value="Community Event">Community Event</option>
                    <option value="Financial Assistance">Financial Assistance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Posted By (Committee / Role)</label>
                <input type="text" id="edit_posted_by" name="posted_by">
            </div>
            <div class="form-group">
                <label>Content / Details</label>
                <textarea id="edit_content" name="content" required></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 15px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Update Announcement</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('addModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('addModal').style.display = 'none'; }

    function openEditModal(id, title, content, category, posted_by) {
        document.getElementById('editForm').action = '/announcements/' + id;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_content').value = content;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_posted_by').value = posted_by;
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }

    // Live Search Filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('.announcement-card');

        cards.forEach(card => {
            let searchData = card.getAttribute('data-search');
            if (searchData.includes(filter)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection