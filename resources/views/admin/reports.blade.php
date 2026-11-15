@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .page-title h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; }
    .page-title p { color: #64748b; font-size: 0.9rem; margin-top: 4px; }

    /* Light Green Primary Button */
    .btn-primary { background-color: #86efac; color: #14532d; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none; transition: background 0.2s; }
    .btn-primary:hover { background-color: #4ade80; }

    /* Filter Bar */
    .filter-card { background: white; padding: 15px 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .filter-group { display: flex; align-items: center; gap: 10px; }
    .filter-group label { font-size: 0.85rem; font-weight: 600; color: #475569; }
    .filter-group input, .filter-group select { padding: 7px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.85rem; outline: none; }
    .filter-group input:focus, .filter-group select:focus { border-color: #86efac; }

    /* Compact Horizontal Reports List */
    .reports-list { display: flex; flex-direction: column; gap: 12px; margin-bottom: 30px; }
    .report-row { background: white; border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between; gap: 15px; transition: all 0.2s; }
    .report-row:hover { border-color: #86efac; transform: translateX(3px); }

    .report-left { display: flex; align-items: center; gap: 15px; flex: 1; min-width: 0; }
    .report-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; background-color: #f0fdf4; color: #16a34a; flex-shrink: 0; }
    
    .report-info { flex: 1; min-width: 0; }
    .report-title-wrap { display: flex; align-items: center; gap: 10px; }
    .report-title { font-size: 0.95rem; font-weight: 700; color: #1e293b; white-space: nowrap; }
    .report-count-badge { background-color: #dcfce7; color: #15803d; font-size: 0.8rem; font-weight: 700; padding: 2px 8px; border-radius: 12px; }
    .report-desc { font-size: 0.8rem; color: #64748b; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .report-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .btn-small { padding: 6px 12px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #334155; font-size: 0.8rem; font-weight: 600; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 5px; transition: all 0.2s; }
    .btn-small:hover { background-color: #f0fdf4; border-color: #86efac; color: #14532d; }

    /* Summary Table Container */
    .table-container { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
    .table-header { padding: 18px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
    .table-header h3 { font-size: 1.05rem; font-weight: 700; color: #1e293b; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background-color: #f8fafc; padding: 12px 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
    td { padding: 14px 20px; font-size: 0.88rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
</style>

<div class="page-header">
    <div class="page-title">
        <h1>Barangay Reports</h1>
        <p>View, generate, and export official barangay management summaries and statistics.</p>
    </div>
    <button class="btn-primary" onclick="window.print()">
        <i class="fa-solid fa-print"></i> Print Overall Summary
    </button>
</div>

<!-- Date Filter Section -->
<div class="filter-card">
    <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <div class="filter-group">
            <label>Start Date:</label>
            <input type="date" value="{{ date('Y-m-01') }}">
        </div>
        <div class="filter-group">
            <label>End Date:</label>
            <input type="date" value="{{ date('Y-m-d') }}">
        </div>
        <div class="filter-group">
            <label>Category:</label>
            <select>
                <option value="all">All Categories</option>
                <option value="residents">Residents Demographic</option>
                <option value="certificates">Certificates Issued</option>
                <option value="blotter">Blotter / Complaints</option>
            </select>
        </div>
    </div>
    <button class="btn-primary" style="padding: 7px 14px; font-size: 0.85rem;">
        <i class="fa-solid fa-filter"></i> Apply Filter
    </button>
</div>

<!-- Horizontal Compact Reports List -->
<div class="reports-list">
    <!-- Resident Report -->
    <div class="report-row">
        <div class="report-left">
            <div class="report-icon"><i class="fa-solid fa-users"></i></div>
            <div class="report-info">
                <div class="report-title-wrap">
                    <span class="report-title">Residents Demographic</span>
                    <span class="report-count-badge">{{ $residentCount ?? 0 }} Total</span>
                </div>
                <div class="report-desc">Total registered citizens, household counts, age demographics, and voter records.</div>
            </div>
        </div>
        <div class="report-actions">
            <button class="btn-small" onclick="alert('Exporting PDF...')"><i class="fa-solid fa-file-pdf"></i> PDF</button>
            <button class="btn-small" onclick="alert('Exporting Excel...')"><i class="fa-solid fa-file-excel"></i> Excel</button>
        </div>
    </div>

    <!-- Certificate Report -->
    <div class="report-row">
        <div class="report-left">
            <div class="report-icon"><i class="fa-solid fa-file-lines"></i></div>
            <div class="report-info">
                <div class="report-title-wrap">
                    <span class="report-title">Certificates & Clearances</span>
                    <span class="report-count-badge">{{ $certificateCount ?? 0 }} Total</span>
                </div>
                <div class="report-desc">Breakdown of requested, pending, and issued barangay clearances and indigencies.</div>
            </div>
        </div>
        <div class="report-actions">
            <button class="btn-small" onclick="alert('Exporting PDF...')"><i class="fa-solid fa-file-pdf"></i> PDF</button>
            <button class="btn-small" onclick="alert('Exporting Excel...')"><i class="fa-solid fa-file-excel"></i> Excel</button>
        </div>
    </div>

    <!-- Blotter Incident Report -->
    <div class="report-row">
        <div class="report-left">
            <div class="report-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="report-info">
                <div class="report-title-wrap">
                    <span class="report-title">Blotters & Incidents</span>
                    <span class="report-count-badge">{{ $blotterCount ?? 0 }} Total</span>
                </div>
                <div class="report-desc">Summary of reported incidents, active disputes, and resolved mediation cases.</div>
            </div>
        </div>
        <div class="report-actions">
            <button class="btn-small" onclick="alert('Exporting PDF...')"><i class="fa-solid fa-file-pdf"></i> PDF</button>
            <button class="btn-small" onclick="alert('Exporting Excel...')"><i class="fa-solid fa-file-excel"></i> Excel</button>
        </div>
    </div>

    <!-- Announcements Summary -->
    <div class="report-row">
        <div class="report-left">
            <div class="report-icon"><i class="fa-solid fa-bullhorn"></i></div>
            <div class="report-info">
                <div class="report-title-wrap">
                    <span class="report-title">Public Notices & Updates</span>
                    <span class="report-count-badge">{{ $announcementCount ?? 0 }} Total</span>
                </div>
                <div class="report-desc">Log of published community updates, advisories, and public notifications.</div>
            </div>
        </div>
        <div class="report-actions">
            <button class="btn-small" onclick="alert('Exporting PDF...')"><i class="fa-solid fa-file-pdf"></i> PDF</button>
            <button class="btn-small" onclick="alert('Exporting Excel...')"><i class="fa-solid fa-file-excel"></i> Excel</button>
        </div>
    </div>
</div>

<!-- Detailed Summary Breakdown Table -->
<div class="table-container">
    <div class="table-header">
        <h3>System Report Summary Breakdown</h3>
        <span style="font-size: 0.85rem; color: #64748b;">Generated: {{ date('M d, Y') }}</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Report Category</th>
                <th>Total Recorded</th>
                <th>Active / Approved</th>
                <th>Pending / Ongoing</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Residents Demographic</strong></td>
                <td>{{ $residentCount ?? 0 }}</td>
                <td><span style="color: #15803d; font-weight: 600;">Active</span></td>
                <td>0</td>
                <td>Today</td>
            </tr>
            <tr>
                <td><strong>Certificates & Permits</strong></td>
                <td>{{ $certificateCount ?? 0 }}</td>
                <td>{{ $certificateCount ?? 0 }} Approved</td>
                <td>0 Pending</td>
                <td>Today</td>
            </tr>
            <tr>
                <td><strong>Blotter Cases</strong></td>
                <td>{{ $blotterCount ?? 0 }}</td>
                <td>0 Resolved</td>
                <td>{{ $blotterCount ?? 0 }} Ongoing</td>
                <td>Today</td>
            </tr>
            <tr>
                <td><strong>Announcements</strong></td>
                <td>{{ $announcementCount ?? 0 }}</td>
                <td>{{ $announcementCount ?? 0 }} Published</td>
                <td>0 Drafts</td>
                <td>Today</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection