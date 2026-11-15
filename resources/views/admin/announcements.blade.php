@extends('layouts.app')

@section('content')
<style>
    .container-fluid { padding: 20px 30px; }
    .page-header { margin-bottom: 25px; }
    .page-header h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 0; }
    .page-header p { color: #64748b; font-size: 0.9rem; margin-top: 4px; margin-bottom: 0; }

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
    
    .card-footer { border-top: 1px solid #f1f5f9; padding-top: 12px; font-size: 0.85rem; color: #64748b; display: flex; justify-content: space-between; align-items: center; }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1>Barangay Announcements</h1>
        <p>Read important notices, community updates, schedules, and public health advisories from your barangay.</p>
    </div>

    <div class="announcements-grid">
        @forelse($announcements as $item)
            @php
                $category = $item->category ?? 'General Notice';
                $badgeClass = 'badge-general';
                if(strtolower($category) == 'urgent advisory') $badgeClass = 'badge-urgent';
                elseif(strtolower($category) == 'community event') $badgeClass = 'badge-event';
                elseif(strtolower($category) == 'financial assistance') $badgeClass = 'badge-financial';
            @endphp
            <div class="announcement-card">
                <div>
                    <div class="card-top">
                        <span class="badge {{ $badgeClass }}">{{ $category }}</span>
                        <span class="time-text"><i class="fa-regular fa-clock"></i> {{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="announcement-title">{{ $item->title }}</div>
                    <div class="announcement-content">{{ $item->content }}</div>
                </div>
                <div class="card-footer">
                    <span><i class="fa-solid fa-user-gear"></i> Posted by {{ $item->posted_by ?? 'Admin' }}</span>
                    <span>{{ $item->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 40px; background: white; border-radius: 12px; border: 1px solid #e2e8f0;">
                No public announcements available at this time.
            </div>
        @endforelse
    </div>
</div>
@endsection